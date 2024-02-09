<?php

declare(strict_types=1);

namespace BeycanPress\CryptoPay\WooCommerce\Services;

// Classes
use BeycanPress\CryptoPay\Helpers;
use BeycanPress\CryptoPay\PluginHero\Hook;
use BeycanPress\CryptoPay\Payment as CryptoPay;
use BeycanPress\CryptoPay\PluginHero\Http\Request;
use BeycanPress\CryptoPay\PluginHero\Http\Response;
// Types
use BeycanPress\CryptoPay\Types\Order\OrderType;
use BeycanPress\CryptoPay\Types\Network\NetworkType;
use BeycanPress\CryptoPay\Types\Network\CurrencyType;
use BeycanPress\CryptoPay\Types\Data\PaymentDataType;
use BeycanPress\CryptoPay\Types\Transaction\ParamsType;

class Payment
{
    /**
     * @var Checkout
     */
    private Checkout $checkout;

    /**
     * @return void
     */
    public function __construct()
    {
        $this->checkout = new Checkout();

        // Redefine the order in the init process to avoid manipulation
        Hook::addFilter('init_woocommerce', [$this, 'init']);

        // WooCommerce hooks
        add_filter('woocommerce_after_add_to_cart_form', [$this, 'instant'], 30);
        add_action('woocommerce_checkout_order_processed', [$this, 'orderProcessed'], 105, 3);
        add_action('woocommerce_after_checkout_validation', [$this, 'checkoutValidation'], 10, 2);

        // CryptoPay Payment Hooks
        Hook::addFilter('payment_redirect_urls_woocommerce', [$this, 'paymentRedirectUrls']);
        Hook::addFilter('before_payment_started_woocommerce', [$this, 'beforePaymentStarted']);
        Hook::addFilter('before_payment_finished_woocommerce', [$this, 'beforePaymentFinished']);
        Hook::addAction('payment_finished_woocommerce', [$this, 'paymentFinished']);
    }

    /**
     * @param PaymentDataType $data
     * @return PaymentDataType
     */
    public function init(PaymentDataType $data): PaymentDataType
    {
        $paymentCurrency = $data->getOrder()->getPaymentCurrency();

        if ($data->getParams()->get('instant')) {
            $quantity = $data->getParams()->get('quantity');
            $productId = $data->getParams()->get('productId');

            $product = wc_get_product($productId);

            $data->setOrder(OrderType::fromArray([
                'currency' => get_woocommerce_currency(),
                'amount' => $product->get_price() * $quantity,
                'paymentCurrency' => $paymentCurrency->toArray()
            ]));
        } elseif ($data->getOrder()->getId()) {
            $order = wc_get_order($data->getOrder()->getId());

            $data->setOrder(OrderType::fromArray([
                'id' => $order->get_id(),
                'amount' => $order->get_total(),
                'currency' => $order->get_currency(),
                'paymentCurrency' => $paymentCurrency?->toArray()
            ]));
        }

        return $data;
    }

    /**
     * @return void
     */
    public function instant(): void
    {
        if (!Helpers::getSetting('acceptInstantPayments')) {
            return;
        }

        global $product;

        if (!$product->is_in_stock()) {
            return;
        }

        if ($product->get_price() <= 0) {
            return;
        }

        if (!is_singular('product')) {
            return;
        }

        Hook::addFilter('js_variables', function (array $vars) use ($product) {
            return array_merge($vars, [
                'instant' => [
                    'productId' => $product->get_id(),
                    'amount' => $product->get_price(),
                    'currency' => get_woocommerce_currency(),
                    'decimals' => get_option('woocommerce_price_num_decimals'),
                ]
            ]);
        });

        $cryptopay = (new CryptoPay('woocommerce'))->modal();

        Helpers::addStyle('main.min.css');
        Helpers::viewEcho('instant', [
            'product' => $product,
            'cryptopay' => $cryptopay
        ]);
    }

    /**
     * @param integer $orderId
     * @param array<mixed> $data
     * @param object $order
     * @return void
     */
    public function orderProcessed(int $orderId, array $data, object $order): void
    {
        /** @var \WC_Order $order */
        if ($order->get_payment_method() == 'cryptopay' && function_exists('wcs_get_subscriptions_for_order')) {
            /** @var \WC_Order_Item $item */
            foreach ($order->get_items() as $item) {
                $subs = wcs_get_subscriptions_for_order($item->get_order_id(), array('order_type' => 'any'));
                if (!empty($subs)) {
                    /** @var \WC_Subscription $sub */
                    foreach ($subs as $sub) {
                        $sub->set_requires_manual_renewal(true);
                        $sub->save();
                    }
                }
            }
        }
    }

    /**
     * @param array<mixed> $data
     * @param object $errors
     * @return void
     */
    public function checkoutValidation(array $data, object $errors): void
    {
        $paymentMethod = WC()->session->get('chosen_payment_method');
        if (
            $paymentMethod == 'cryptopay' && wp_doing_ajax() &&
            Helpers::getSetting('paymentReceivingArea') == 'checkout'
        ) {
            if (empty($errors->errors)) {
                WC()->session->set('cp_posted_data', array_merge($_POST, $data));

                // get init data
                $request = new Request();
                $params = json_decode($request->getParam('cp_params'));
                $network = json_decode($request->getParam('cp_network'));
                $currency = json_decode($request->getParam('cp_currency'));

                $order = OrderType::fromArray([
                    'amount' => (float) \WC()->cart->total,
                    'currency' => get_woocommerce_currency()
                ])->setPaymentCurrency(CurrencyType::fromObject($currency));

                $init = (new CryptoPay('woocommerce'))->setOrder($order)
                ->setParams(ParamsType::fromObject($params))
                ->init(NetworkType::fromObject($network));

                Response::success(esc_html__('Success', 'cryptopay'), [
                    'init' => $init->prepareForJsSide()
                ]);
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
     * @param PaymentDataType $data
     * @return array<string>
     */
    public function paymentRedirectUrls(PaymentDataType $data): array
    {
        if ($data->getOrder()->getId()) {
            $order = wc_get_order($data->getOrder()->getId());
        } else {
            $order = wc_get_order($data->getDynamicData()->get('order.id'));
        }
        return [
            'success' => $order->get_checkout_order_received_url(),
            'failed' => $order->get_view_order_url()
        ];
    }

    /**
     * @param PaymentDataType $data
     * @return PaymentDataType
     */
    public function beforePaymentStarted(PaymentDataType $data): PaymentDataType
    {
        try {
            if ($data->getParams()->get('instant')) {
                $product = wc_get_product($data->getParams()->get('productId'));

                $order = wc_create_order();

                // set order customer data
                if ($data->getUserId()) {
                    $userData = get_userdata($data->getUserId());
                    $order->set_customer_id($userData->ID);
                    $order->set_billing_first_name($userData->first_name);
                    $order->set_billing_last_name($userData->last_name);
                    $order->set_billing_email($userData->user_email);
                    $order->set_billing_address_1($userData->billing_address_1);
                    $order->set_billing_city($userData->billing_city);
                    $order->set_billing_state($userData->billing_state);
                    $order->set_billing_postcode($userData->billing_postcode);
                    $order->set_billing_country($userData->billing_country);
                    $order->set_billing_phone($userData->billing_phone);

                    $order->update_meta_data(
                        '_customer_user',
                        $data->getUserId()
                    );
                }

                // set order items
                $order->add_product($product, $data->getParams()->get('quantity'), [
                    'total' => ($product->get_price() * $data->getParams()->get('quantity')),
                ]);

                // set order totals
                $order->calculate_totals();

                // set order currency
                $order->set_currency(get_woocommerce_currency());

                // payment method
                $order->set_payment_method('cryptopay');
                $order->set_payment_method_title('CryptoPay Instant');

                $order->update_status('wc-on-hold');

                // save order
                $data->getOrder()->setId($order->save());

                $data->getDynamicData()->set('order', [
                    'id' => $data->getOrder()->getId(),
                ]);
            } else {
                // Set posted data
                $_POST = (array) $data->getDynamicData()->get('wcForm');

                if (!$data->getOrder()->getId()) {
                    $postedData = WC()->session->get('cp_posted_data');
                    $order = $this->checkout->createOrder($data->getUserId(), $postedData);
                    $data->getOrder()->setId($order->get_id());
                    $data->getDynamicData()->set('order', [
                        'id' => $data->getOrder()->getId(),
                    ]);
                } else {
                    $order = wc_get_order($data->getOrder()->getId());
                    $order->update_status('wc-on-hold');
                }
            }
        } catch (\Exception $e) {
            Response::error($e->getMessage(), 'ORDER_CREATION_ERROR', $e->getTrace());
        }

        return $data;
    }

    /**
     * @param PaymentDataType $data
     * @return PaymentDataType
     */
    public function beforePaymentFinished(PaymentDataType $data): PaymentDataType
    {
        if (!$data->getOrder()->getId()) {
            $data->getOrder()->setId($data->getDynamicData()->get('order.id'));
        }

        return $data;
    }

    /**
     * @param PaymentDataType $data
     * @return void
     */
    public function paymentFinished(PaymentDataType $data): void
    {
        if ($order = wc_get_order($data->getOrder()->getId())) {
            $order->update_meta_data(
                '_transaction_hash',
                $data->getHash()
            );

            $order->save();

            if ($data->getStatus()) {
                if (Helpers::getSetting('paymentCompleteOrderStatus') == 'wc-completed') {
                    $note = esc_html__('Your order is complete.', 'cryptopay');
                } else {
                    $note = esc_html__('Your order is processing.', 'cryptopay');
                }

                $order->payment_complete();
                $order->update_status(Helpers::getSetting('paymentCompleteOrderStatus'), $note);
            } else {
                $order->update_status('wc-failed', esc_html__('Payment not verified via Blockchain!', 'cryptopay'));
            }
        }
    }
}
