<?php

namespace BeycanPress\CryptoPay\WooCommerce;

use \BeycanPress\CryptoPay\Verifier;
use \BeycanPress\CryptoPay\Services;
use \BeycanPress\CryptoPay\PluginHero\Helpers;
use \BeycanPress\CryptoPay\Models\OrderTransaction;

class Details
{
    use Helpers;

    /**
     * @var OrderTransaction
     */
    private $model;

    /**
     * @var Verifier
     */
    private $verifier;

    public function __construct()
    {
        $this->model = new OrderTransaction();
        $this->verifier = new Verifier($this->model);
        
        if ($this->setting('backendConfirmation')) {
            add_action('woocommerce_before_account_orders', function() {
                $this->verifier->verifyPendingTransactions(get_current_user_id());
            });
        }

        add_action('woocommerce_view_order', array($this, 'init'), 4);
        add_action('woocommerce_thankyou_cryptopay', array($this, 'init'), 1);
    }

    /**
     * @param int $orderId
     * @return void
     */
    public function init($orderId) : void
    {
        if ($this->setting('backendConfirmation') && !is_checkout()) {
            $this->verifier->verifyPendingTransactions(get_current_user_id());
        }

        $order = wc_get_order($orderId);

        if ('cryptopay' == $order->get_payment_method()) {
            $transaction = $this->model->findOneBy([
                'orderId' => $orderId
            ], ['id', 'DESC']);
    
            if ($order->get_status() == 'pending' && !$transaction) {
                $this->viewEcho('woocommerce/pending', ['payUrl' => $order->get_checkout_payment_url(true)]);
            } elseif (!is_null($transaction)) {
                echo Services::showPaymentDetails($transaction);
            }
        }
    }

}