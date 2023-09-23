<?php

namespace BeycanPress\CryptoPay;

use \BeycanPress\Http\Request;
use \BeycanPress\Http\Response;
use \BeycanPress\CryptoPay\Services;
use \BeycanPress\CryptoPay\Verifier;
use \BeycanPress\CryptoPay\PluginHero\Hook;
use \BeycanPress\CryptoPay\PluginHero\Api as AbstractApi;

class Api extends AbstractApi
{
    /**
     * @var int
     */
    private $userId;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var string
     */
    private $addon;

    /**
     * @var AbstractTransaction
     */
    private $model;

    /**
     * @var string
     */
    private $hash;

    /**
     * @var object
     */

    private $order;

    /**
     * @var object
     */
    private $network;

    /**
     * @var object
     */
    private $data;

    /**
     * @var array
     */
    private $errorMap = [
        'GNR101' => 'Please enter a valid data!',
        'INIT101' => 'There was a problem converting currency!',
        'INIT102' => 'There was a problem getting wallet address!',
        'CT102' => 'Transaction already exists!',
        'PAYF101' => 'Transaction record not found!',
        'PAYF102' => 'Payment not verified via Blockchain',
        'MOD103' => 'Model not found!',
        'ORDER_NOT_FOUND' => 'The relevant order was not found!',
    ];

    public function __construct()
    {
        $this->request = new Request();
        $this->userId = get_current_user_id();
        $this->addon = $this->request->getParam('cp_addon');

        add_filter('woocommerce_checkout_customer_id', function() {
            wp_set_current_user($this->userId);
            return $this->userId;
        }, 11);

        if ($this->addon) {
            $this->model = Services::getModelByAddon($this->addon);
            $this->hash = $this->request->getParam('hash');
            $this->order = $this->request->getParam('order');
            $this->network = $this->request->getParam('network');
            $this->data = (object) [
                'addon' => $this->addon,
                'userId' => $this->userId,
                'order' => $this->order,
                'hash' => $this->hash,
                'network' => $this->network,
                'model' => $this->model,
                'status' => 'pending',
                'params' => $this->request->getParam('params')
            ];

            $this->debugDefaultContext = [
                'addon' => $this->addon,
            ];
        }

        $this->addRoutes([
            'cryptopay' => [
                'init' => [
                    'callback' => 'init',
                    'methods' => ['GET']
                ],
                'create-transaction' => [
                    'callback' => 'createTransaction',
                    'methods' => ['POST']
                ],
                'payment-finished' => [
                    'callback' => 'paymentFinished',
                    'methods' => ['POST']
                ],
                'currency-converter' => [
                    'callback' => 'currencyConverter',
                    'methods' => ['GET']
                ],
                'verify-pending-transactions' => [
                    'callback' => 'verifyPendingTransactions',
                    'methods' => ['GET']
                ],
                'custom-endpoints' => [
                    'callback' => 'customEndpoint',
                    'methods' => ['GET', 'POST']
                ],
            ]
        ]);
    }

    /**
     * @return void
     */
    public function init() : void
    {   
        Hook::callAction('init_' . $this->addon, $this->data);
        // Check order or update
        $this->data->order = $this->order = Hook::callFilter('check_order_' . $this->addon, $this->order);
        
        $this->debug('Initialize process (API)', 'INFO', [
            'addon' => $this->addon,
            'order' => $this->order,
            'network' => $this->network,
        ]);

        $this->debug('Calculating payment amount (API)');
        $paymentAmount = Services::calculatePaymentAmont(
            $this->order->currency, $this->order->paymentCurrency, $this->order->amount, $this->network
        );

        if (is_null($paymentAmount)) {
            $this->debug('There was a problem converting currency! (API)', 'ERROR', [
                'addon' => $this->addon,
                'order' => $this->order,
                'network' => $this->network,
            ]);
            Response::error(esc_html__('There was a problem converting currency! Make sure your currency value is available in the relevant API or you define a custom value for your currency.', 'cryptopay'), 'INIT101');
        }

        $variables = Services::getVariableParams($this->data);

        if (!$variables['receiver']) {
            $this->debug('There was a problem getting wallet address! (API)', 'ERROR', [
                'addon' => $this->addon,
                'order' => $this->order,
                'network' => $this->network,
            ]);
            Response::error(esc_html__('There was a problem getting wallet address! Please make sure you enter a wallet (receiving) address!', 'cryptopay'), 'INIT102');
        }

        Response::success(null, 
            array_merge(
                $variables,
                [
                    'amount' => $this->order->amount,
                    'paymentAmount' => $paymentAmount,
                ]
            )
        );
    }

    /**
     * @return void
     */
    public function createTransaction() : void
    {
        if ($this->model) {
            // Check order or update
            $this->data->order = $this->order = Hook::callFilter('check_order_' . $this->addon, $this->order);
            // data customizer
            $this->data = Hook::callFilter('before_payment_started_' . $this->addon, $this->data);

            $this->debug('Create transaction process');

            if (!$this->hash) {
                $this->debug('Please enter a valid data', 'ERROR', [
                    'addon' => $this->addon,
                    'order' => $this->order,
                ]);
                Response::badRequest(esc_html__('Please enter a valid data.', 'cryptopay'), 'CT101', [
                    'redirect' => 'reload'
                ]);
            }
            
            $this->debug('Checking transaction hash');
            $date = date('Y-m-d H:i:s', $this->getUTCTime()->getTimestamp());
            if ($this->model->findOneBy(['hash' => $this->hash])) {
                $this->debug('Transaction already exists!', 'ERROR', [
                    'addon' => $this->addon,
                    'order' => $this->order,
                    'hash' => $this->hash,
                ]);
                Response::error(esc_html__('Transaction already exists!', 'cryptopay'), 'CT102', [
                    'redirect' => 'reload'
                ]);
            }
            
            $this->debug('Inserting transaction');
            $this->model->insert([
                'hash' => $this->hash,
                'order' => json_encode($this->order),
                'orderId' => $this->order->id ?? null,
                'userId' => $this->userId,
                'network' => json_encode($this->network),
                'params' => json_encode($this->data->params),
                'code' => $this->network->code,
                'testnet' => boolval(Settings::get('testnet')),
                'status' => Hook::callFilter('transaction_status_' . $this->addon, 'pending'),
                'updatedAt' => $date,
                'createdAt' => $date,
            ]);

            $this->debug('Payment started');
            Hook::callAction('payment_started_' . $this->addon, $this->data);
            Response::success();
        }

        Response::error(esc_html__('Model not found!', 'cryptopay'), 'MOD103', [
            'redirect' => 'reload'
        ]);
    }

    /**
     * @return void
     */
    public function paymentFinished() : void
    {   
        if ($this->model) {
            // Check order or update
            $this->data->order = $this->order = Hook::callFilter('check_order_' . $this->addon, $this->order);
            // data customizer
            $this->data = Hook::callFilter('before_payment_finished_' . $this->addon, $this->data);
            
            $this->debug('Payment finished process');

            if (!$this->hash) {
                $this->debug('Please enter a valid data', 'ERROR', [
                    'addon' => $this->addon,
                    'order' => $this->order,
                ]);
                Response::badRequest(esc_html__('Please enter a valid data.', 'cryptopay'), 'GNR101', [
                    'redirect' => 'reload'
                ]);
            }

            $this->debug('Getting transaction record');
            if (!$transaction = $this->model->findOneBy(['hash' => $this->hash])) {
                $this->debug('Transaction record not found!', 'ERROR', [
                    'addon' => $this->addon,
                    'order' => $this->order,
                    'hash' => $this->hash,
                ]);
                Response::error(esc_html__('Transaction record not found!', 'cryptopay'), 'PAYF101', [
                    'redirect' => 'reload'
                ]);
            }

            $this->debug('Verifying transaction', 'INFO', [
                'hash' > $this->hash,
            ]);
            try {
                $this->data->status = (new Verifier($this->model))->verifyTransaction($transaction);
            } catch (\Exception $e) {
                $this->debug('Transaction verify process problem!', 'CRITICAL', [
                    'addon' => $this->addon,
                    'network' => $this->network,
                    'hash' => $this->hash,
                    'error' => $e->getMessage(),
                ]);
                $this->data->status = false;
            }

            $this->debug('Payment finished (API)');
            Hook::callAction('payment_finished_' . $this->addon, $this->data);

            $urls = Hook::callFilter('payment_redirect_urls_' . $this->addon, $this->data);

            if (is_object($urls)) {
                $this->debug('Redirect links cannot finded!', 'ERROR', [
                    'addon' => $this->addon,
                    'order' => $this->order,
                ]);
                Response::badRequest(esc_html__('Redirect links cannot finded!', 'cryptopay'), 'GNR102', [
                    'redirect' => 'reload'
                ]);
            }

            if ($this->data->status) {

                $this->model->updateStatusToVerifiedByHash($transaction->hash);

                Response::success(Hook::callFilter(
                    'payment_success_message_' . $this->addon, 
                    esc_html__('Payment completed successfully', 'cryptopay')
                ), [
                    'redirect' => $urls['success']
                ]);
            } else {
                
                $this->model->updateStatusToFailedByHash($transaction->hash);
                
                Response::error(Hook::callFilter(
                    'payment_failed_message_' . $this->addon, 
                    esc_html__('Payment not verified via Blockchain', 'cryptopay')
                ), 'PAYF102', [
                    'redirect' => $urls['failed']
                ]);
            }
        }

        Response::error(esc_html__('Model not found!', 'cryptopay'), 'MOD103', [
            'redirect' => 'reload'
        ]);
    }

    /**
     * @return void
     */
    public function currencyConverter() : void
    {   
        $this->debug('Currency converter process');
        $paymentAmount = Services::calculatePaymentAmont(
            $this->order->currency, $this->order->paymentCurrency, $this->order->amount, $this->network
        );

        if (is_null($paymentAmount)) {
            $this->debug('There was a problem converting currency!', 'ERROR', [
                'addon' => $this->addon,
                'order' => $this->order,
                'network' => $this->network,
            ]);
            Response::error(esc_html__('There was a problem converting currency! Make sure your currency value is available in the relevant API or you define a custom value for your currency.', 'cryptopay'), 'GNR101');
        }

        Response::success(null, $paymentAmount);
    }

    /**
     * @return void
     */
    public function verifyPendingTransactions() : void
    {
        if ($this->model) {
            $this->debug('Verify pending transactions process');
            $code = $this->request->getParam('code') ?? 'all';
            (new Verifier($this->model))->verifyPendingTransactions(0, $code);

            Response::success();
        }

        Response::error(esc_html__('Model not found!', 'cryptopay'), 'MOD103');
    }

    /**
     * @return void
     */
    public function customEndpoint() : void
    {
        $endpoint = $this->request->getParam('endpoint');

        if (!$endpoint) {
            Response::error(esc_html__('Endpoint not found!', 'cryptopay'), 'GNR101');
        }

        Hook::callAction('custom_endpoint_' . $endpoint, $this->data);
    }
}
