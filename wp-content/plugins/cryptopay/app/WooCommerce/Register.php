<?php

namespace BeycanPress\CryptoPay\WooCommerce;

use \BeycanPress\Http\Response;
use \BeycanPress\CryptoPay\Services;
use \BeycanPress\CryptoPay\Settings;
use \BeycanPress\CryptoPay\PluginHero\Hook;
use \BeycanPress\CryptoPay\PluginHero\Helpers;
use \BeycanPress\CryptoPay\Pages\TransactionPage;
use \BeycanPress\CryptoPay\Models\OrderTransaction;

class Register
{
    use Helpers;
    
    /**
     * @var Checkout
     */
    private $checkout;

    public function __construct()
    {   
        // Register WooCommerce
        if (function_exists('WC')) {
            Services::registerAddon('woocommerce');

            // Register gateways
            add_filter('woocommerce_payment_gateways', function($gateways) {
                $gateways[] = Gateway::class;
                return $gateways;
            });
            
            if (!is_admin()) {
                new Details();
                $this->checkout = new Checkout();
            } else {
                // Refund process
                add_action('woocommerce_order_fully_refunded', [$this, 'updateTransactionStatusToRefund'], 10, 2);
                add_action('woocommerce_order_partially_refunded', [$this, 'updateTransactionStatusToRefund'], 10, 2);
                new TransactionPage(
                    esc_html__('Order transactions', 'cryptopay'),
                    'order_transactions',
                    'woocommerce',
                    2,
                    [
                        'orderId' => function($tx) {
                            return '<a href="'.get_edit_post_link($tx->orderId).'" target="_blank">'.$tx->orderId.'</a>';
                        }
                    ]
                );
            }

            // WooCommerce hooks
            add_action('woocommerce_checkout_order_processed', [$this, 'orderProcessed'], 105, 3);
            add_action('woocommerce_admin_order_data_after_order_details', [$this, 'addDetails']);
            add_action('woocommerce_after_checkout_validation', [$this, 'checkoutValidation'], 10, 2);

            // CryptoPay hooks
            Hook::addFilter('check_order_woocommerce', [$this, 'checkOrder']);
            Hook::addFilter('before_payment_started_woocommerce', [$this, 'beforePaymentStarted']);
            Hook::addFilter('before_payment_finished_woocommerce', [$this, 'beforePaymentFinished']);
            Hook::addAction('payment_finished_woocommerce', [$this, 'paymentFinished']);
            Hook::addFilter('payment_redirect_urls_woocommerce', [$this, 'paymentRedirectUrls']);
        }
    }

    /**
     * @param integer $orderId
     * @param array $data
     * @param object $order
     * @return void
     */
    public function orderProcessed(int $orderId, array $data, object $order) : void
    {
        if ($order->get_payment_method() == 'cryptopay' && function_exists('wcs_get_subscriptions_for_order')) {
            foreach ($order->get_items() as $item) {
                $subs = wcs_get_subscriptions_for_order($item->get_order_id(), array('order_type' => 'any'));
                if (!empty($subs)) {
                    foreach ($subs as $sub) {
                        $sub->set_requires_manual_renewal(true);
                        $sub->save();
                    }
                }
            }
        }
    }

    /**
     * @param object $order
     * @return void
     */
    public function addDetails(object $order) : void
    {
        $blockchainNetwork = $order->get_meta('_blockchain_network');
        if ($order->get_payment_method() == 'cryptopay' && $blockchainNetwork) {
            $this->viewEcho('woocommerce/details', [
                'blockchainNetwork' => $blockchainNetwork,
                'transactionHash' => $order->get_meta('_transaction_hash'),
                'paymentCurrency' => $order->get_meta('_payment_currency'),
                'paymentAmount' => $order->get_meta('_payment_amount'),
            ]);
        }
    }

    /**
     * @param array $data
     * @param object $errors
     * @return void
     */
    public function checkoutValidation(array $data, object $errors) : void
    {
        $paymentMethod = WC()->session->get('chosen_payment_method'); 
        if (
            $paymentMethod == 'cryptopay' && 
            Settings::get('paymentReceivingArea') == 'checkout' && 
            wp_doing_ajax()
        ) {

            if (empty($errors->errors)) {
                WC()->session->set('cp_posted_data', $data);
                Response::success();
            }

            foreach ($errors->errors as $code => $messages) {
                $data = $errors->get_error_data($code);
                foreach ($messages as $message) {
                    wc_add_notice($message, 'error', $data);
                }
            }

            if (!isset(WC()->session->reload_checkout)) {
                $messages = wc_print_notices(true);
            }
    
            $data = [
                'refresh' => isset(WC()->session->refresh_totals),
                'reload'  => isset(WC()->session->reload_checkout),
            ];

            unset(WC()->session->refresh_totals, WC()->session->reload_checkout);

            Response::error((isset($messages) ? $messages : ''), null, $data);
        }
    }

    /**
     * @param object $order
     * @return object
     */
    public function checkOrder(object $order) : object
    {
        if (isset($order->id)) {
            $order->amount = wc_get_order($order->id)->get_total();
        } else {
            $order->amount = \WC()->cart->total;
        }
        
        return $order;
    }

    /**
     * @param object $data
     * @return object
     */
    public function beforePaymentStarted(object $data) : object
    {
        if (!isset($data->order->id)) {
            $postedData = WC()->session->get('cp_posted_data');
            $order = $this->checkout->createOrder($data->userId, $postedData);
            $data->order->id = $order->get_id();
        } elseif (isset($data->order->id)) {
            $order = wc_get_order($data->order->id);
            $order->update_status('wc-on-hold');
        }

        return $data;
    }

    /**
     * @param object $data
     * @return object
     */
    public function beforePaymentFinished(object $data) : object
    {
        if (!isset($data->order->id)) {
            $data->order->id = WC()->session->get('cp_order_id');
        }
        return $data;
    }

    /**
     * @param object $data
     * @return void
     */
    public function paymentFinished(object $data) : void
    {
        if ($order = wc_get_order($data->order->id)) {
            $order->update_meta_data(
                '_blockchain_network',
                $data->network->name
            );
    
            $order->update_meta_data(
                '_transaction_hash',
                $data->hash
            );
    
            $order->update_meta_data(
                '_payment_currency',
                $data->order->paymentCurrency->symbol
            );
    
            $order->update_meta_data(
                '_payment_amount', 
                Services::toString($data->order->paymentAmount, $data->order->paymentCurrency->decimals)
            );

            $order->save();
            
            if ($data->status) {
                if ($this->setting('paymentCompleteOrderStatus') == 'wc-completed') {
                    $note = esc_html__('Your order is complete.', 'cryptopay');
                } else {
                    $note = esc_html__('Your order is processing.', 'cryptopay');
                }
                
                $order->payment_complete();
                $order->update_status($this->setting('paymentCompleteOrderStatus'), $note);
            } else {
                $order->update_status('wc-failed', esc_html__('Payment not verified via Blockchain!', 'cryptopay'));
            }
        }
    }

    /**
     * @param object $data
     * @return array
     */
    public function paymentRedirectUrls(object $data) : array
    {
        $order = wc_get_order($data->order->id);
        return [
            'success' => $order->get_checkout_order_received_url(),
            'failed' => $order->get_view_order_url()
        ];
    }

    /**
     * @param integer $orderId
     * @return void
     */
    public function updateTransactionStatusToRefund(int $orderId) : void 
    {
		$order = wc_get_order($orderId);
        if ($hash = $order->get_meta('_transaction_hash')) {
            $model = Services::getModelByAddon('woocommerce');
            $model->updateStatusToRefundedByHash($hash);
        }
    }
}