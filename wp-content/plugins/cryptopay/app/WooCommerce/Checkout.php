<?php

namespace BeycanPress\CryptoPay\WooCommerce;

use \BeycanPress\CryptoPay\Services;

class Checkout extends \WC_Checkout
{
    /**
     * @return void
     */
    public function __construct()
    { 
        add_action('woocommerce_receipt_cryptopay', array($this, 'init'), 1);
    }

    /**
     * @param int $orderId
     * @return void
     */
    public function init($orderId) : void
    {   
        $order = wc_get_order($orderId);

        if ($order->get_status() != 'pending') {
            wp_redirect($order->get_checkout_order_received_url());
        } else {
            echo Services::startPaymentProcess([
                'id' => (int) $order->get_id(),
                'amount' => (float) $order->get_total(),
                'currency' => strtoupper($order->get_currency()),
            ], 'woocommerce');
        }
    }

    /**
     * @param int $userId
     * @param array $data
     * @return \WC_Order
     */
    public function createOrder(int $userId, array $data) : \WC_Order
    {
        $cart = WC()->cart;
		$this->update_session($data);
        $this->process_customer($data);
        $orderId = $this->create_order($data);
        $order = wc_get_order($orderId);
        
		do_action('woocommerce_checkout_order_processed', $orderId, $data, $order);

        $order->update_status('wc-on-hold');
        $order->calculate_totals();
        update_post_meta(
            $orderId, 
            '_customer_user', 
            $userId
        );
        $order->add_order_note(
            esc_html__(
                'Customer has chosen CryptoPay payment method, payment is pending.', 
                'cryptopay'
            )
        );
        WC()->session->set(
            'cp_order_id', 
            $orderId
        );
		WC()->session->set(
            'order_awaiting_payment', 
            $orderId
        );
		wc_empty_cart();
        return $order;
    }
}