<?php

namespace BeycanPress\CryptoPay\WooCommerce;

use \BeycanPress\CryptoPay\Settings;
use \BeycanPress\CryptoPay\Services;
use \BeycanPress\CryptoPay\PluginHero\Plugin;

class Gateway extends \WC_Payment_Gateway
{   
    /**
     * @return void
     */
    public function __construct()
    {
        $this->id = 'cryptopay';
        $this->method_title = esc_html__('CryptoPay', 'cryptopay');
        $this->method_description = esc_html__('With CryptoPay, your customers can easily pay with their cryptocurrencies.', 'cryptopay');

        // gateways can support subscriptions, refunds, saved payment methods,
        // but in this tutorial we begin with simple payments
        $this->supports = ['products'];

        if (Settings::get('acceptSubscriptionPayments')) {
            $this->supports[] = 'subscriptions';
        }

        // Method with all the options fields
        $this->init_form_fields();

        // Load the settings.
        $this->init_settings();
        $this->title = $this->get_option('title');
        $this->enabled = $this->get_option('enabled');
        $this->description = $this->get_option('description');
		$this->order_button_text = $this->get_option('order_button_text');

        // This action hook saves the settings
        add_action('woocommerce_update_options_payment_gateways_' . $this->id, array($this, 'process_admin_options'));

        if (Settings::get('paymentReceivingArea') == 'checkout' &&  ! is_wc_endpoint_url()) {
            // Checkout process
            add_filter('woocommerce_order_button_html', [$this, 'hidePlaceOrderButton']);
        }
    }

    /**
     * @param string $button
     * @return string
     */
    public function hidePlaceOrderButton(string $button) : string
    {
        $paymentMethod = WC()->session->get('chosen_payment_method'); 

        if ($paymentMethod == $this->id) {
            $button = ''; 
        }

        return $button;
    }

    /**
     * @return void
     */
    public function init_form_fields() : void
    {
        $this->form_fields = array(
            'enabled' => array(
                'title'       => esc_html__('Enable/Disable', 'cryptopay'),
                'label'       => esc_html__('Enable', 'cryptopay'),
                'type'        => 'checkbox',
                'default'     => 'no'
            ),
            'title' => array(
                'title'       => esc_html__('Title', 'cryptopay'),
                'type'        => 'text',
                'description' => esc_html__('This controls the title which the user sees during checkout.', 'cryptopay'),
                'default'     => esc_html__('CryptoPay', 'cryptopay')
            ),
            'description' => array(
                'title'       => esc_html__('Description', 'cryptopay'),
                'type'        => 'textarea',
                'description' => esc_html__('This controls the description which the user sees during checkout.', 'cryptopay'),
                'default'     => esc_html__('You can pay with supported networks and cryptocurrencies.', 'cryptopay'),
            ),
            'order_button_text' => array(
                'title'       => esc_html__('Order button text', 'cryptopay'),
                'type'        => 'text',
                'description' => esc_html__('Pay button on the checkout page', 'cryptopay'),
                'default'     => esc_html__('Proceed to CryptoPay', 'cryptopay'),
            ),
        );
    }

    /**
     * @return mixed
     */
    public function get_icon() : string
    {
        $iconHtml = '<img src="'.esc_url(Plugin::$instance->getImageUrl('icon.png')).'" width="25" height="25">';
        return apply_filters('woocommerce_gateway_icon', $iconHtml, $this->id);
    }

    /**
     * @return void
     */
    public function payment_fields() : void
    {
        if (Settings::get('paymentReceivingArea') == 'checkout' && !is_wc_endpoint_url()) {
            echo Services::preparePaymentProcess('woocommerce', true, [
                'order' => [
                    'amount' => (float) \WC()->cart->total,
                    'currency' => strtoupper(get_woocommerce_currency()),
                ],
                'autoLoad' => true,
                'checkoutPage' => true
            ]);
        } else {
            echo esc_html($this->description);
        }
    }

    /**
     * @param int $orderId
     * @return array
     */
    public function process_payment($orderId) : array
    {
        global $woocommerce;
        $order = new \WC_Order($orderId);

        if ($order->get_total() == 0) {
            if (Settings::get('paymentCompleteOrderStatus') == 'wc-completed') {
                $note = esc_html__('Your order is complete.', 'cryptopay');
            } else {
                $note = esc_html__('Your order is processing.', 'cryptopay');
            }

            $order->payment_complete();

            $order->update_status(Settings::get('paymentCompleteOrderStatus'), $note);

            $order->add_order_note(esc_html__('Was directly approved by CryptoPay as the order amount was zero!', 'cryptopay'));
            
            $url = $order->get_checkout_order_received_url();
        } else {
            $order->update_status('wc-pending', esc_html__( 'Payment is awaited.', 'cryptopay'));

            $order->add_order_note(esc_html__('Customer has chosen CryptoPay payment method, payment is pending.', 'cryptopay'));

            $url = $order->get_checkout_payment_url(true);
        }

        // Remove cart
        $woocommerce->cart->empty_cart();

        // Return thankyou redirect
        return array(
            'result' => 'success',
            'redirect' => $url
        );  
    }
}