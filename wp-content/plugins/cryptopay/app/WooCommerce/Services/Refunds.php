<?php

declare(strict_types=1);

namespace BeycanPress\CryptoPay\WooCommerce\Services;

// Classes
use BeycanPress\CryptoPay\Helpers;
use BeycanPress\CryptoPay\Payment;
use BeycanPress\CryptoPay\PluginHero\Hook;
// Types
use BeycanPress\CryptoPay\Types\Order\OrderType;
use BeycanPress\CryptoPay\Types\Order\RefundType;
use BeycanPress\CryptoPay\Types\Data\PaymentDataType;
use BeycanPress\CryptoPay\Types\Network\NetworksType;
use BeycanPress\CryptoPay\Types\Network\CurrenciesType;
use BeycanPress\CryptoPay\Types\Transaction\TransactionType;
use BeycanPress\CryptoPay\Types\Enums\TransactionStatus as Status;

class Refunds
{
    /**
     * @param \WC_Order $order
     * @param TransactionType $transaction
     * @return void
     */
    public function __construct()
    {
        Helpers::registerIntegration('woocommerce_refund');

        Hook::addFilter('sanctions_woocommerce_refund', '__return_false');

        add_action('woocommerce_order_refunded', [$this, 'refundCreated'], 10, 2);
        add_action('woocommerce_refund_deleted', [$this, 'refundDeleted'], 10, 2);

        Hook::addFilter('discount_rates_woocommerce_refund', function (array $discountRates, ?PaymentDataType $data) {
            if ($data && $data->getParams()->get('discountRates')) {
                return $data->getParams()->get('discountRates');
            }

            return $discountRates;
        }, 10, 2);

        Hook::addFilter('receiver_woocommerce_refund', function (string $receiver, PaymentDataType $data) {
            if ($data->getParams()->get('receiver')) {
                return $data->getParams()->get('receiver');
            }
            return $receiver;
        }, 10, 2);
    }

    /**
     * @param float $amount
     * @return float
     */
    private function round(float $amount): float
    {
        return round($amount, intval(get_option('woocommerce_price_num_decimals')));
    }

    /**
     * @param int $orderId
     * @param int $refundId
     * @return void
     */
    public function refundCreated(int $orderId, int $refundId): void
    {
        $order = wc_get_order($orderId);
        if ($hash = $order->get_meta('_transaction_hash')) {
            // get refund data
            $manual  = isset($_POST['api_refund']) && !('true' === $_POST['api_refund']);
            $refundAmount = isset($_POST['refundAmount']) ? floatval($_POST['refundAmount']) : 0;
            $refundPaymentAmount = isset($_POST['refundPaymentAmount']) ? floatval($_POST['refundPaymentAmount']) : 0;

            // prepare status
            $refundableAmount = $this->round(floatval($order->get_total() - $order->get_total_refunded()));
            $status = $refundableAmount > 0 ? Status::PARTIALLY_REFUNDED : Status::FULLY_REFUNDED;

            $refund = new RefundType($refundId, $refundAmount, $refundPaymentAmount, $manual);
            Helpers::getModelByAddon('woocommerce')->addOrderRefundData($hash, $refund, $status);
        }
    }

    /**
     * @param integer $refundId
     * @param integer $orderId
     * @return void
     */
    public function refundDeleted(int $refundId, int $orderId): void
    {
        $order = wc_get_order($orderId);
        if ($hash = $order->get_meta('_transaction_hash')) {
            $refundableAmount = $this->round(floatval($order->get_total() - $order->get_total_refunded()));
            $status = $refundableAmount > 0 ? Status::PARTIALLY_REFUNDED : Status::FULLY_REFUNDED;
            if ($refundableAmount == $order->get_total()) {
                $status = Status::VERIFIED;
            }
            Helpers::getModelByAddon('woocommerce')->deleteOrderRefundData($hash, $refundId, $status);
        }
    }

    /**
     * @param \WC_Order $order
     * @param TransactionType $transaction
     * @return void
     */
    public function init(\WC_Order $order, TransactionType $transaction): void
    {
        Helpers::addStyle('main.min.css');

        $tOrder = $transaction->getOrder();
        $network = $transaction->getNetwork();

        $paymentCurrency = $tOrder->getPaymentCurrency();
        $network->setCurrencies(new CurrenciesType([$paymentCurrency]));

        $refundableAmount = $this->round(floatval($order->get_total() - $order->get_total_refunded()));

        if ($refundableAmount > 0 && $order->get_status() != 'on-hold') {
            if ($transaction->getAddresses()->getSender()) {
                Hook::addFilter('mode_woocommerce_refund', function () {
                    return 'network';
                });

                Hook::addFilter('edit_networks_woocommerce_refund', function (NetworksType $networks) use ($network) {
                    return $networks->filter(function ($n) use ($network) {
                        if ($id = $network->getId()) {
                            return $n->getId() == $id;
                        } else {
                            return $n->getCode() == $network->getCode();
                        }
                    });
                });

                Hook::addFilter('discount_rates_woocommerce_refund', function () use ($transaction) {
                    $order = $transaction->getOrder();
                    return [
                        $order->getPaymentCurrency()->getSymbol() => $order->getDiscountRate()
                    ];
                });

                Hook::addFilter('receiver_woocommerce_refund', function () use ($transaction) {
                    return $transaction->getAddresses()->getSender();
                });

                $id = $order->get_id();
                $amount = (float) $refundableAmount;
                $currency = strtoupper($order->get_currency());

                echo (new Payment('woocommerce_refund'))
                ->setOrder(
                    OrderType::fromArray([
                        'id' => $id,
                        'amount' => $amount,
                        'currency' => $currency,
                    ])
                    ->setPaymentCurrency($paymentCurrency)
                )
                ->setAutoStart(false)
                ->setConfirmation(false)
                ->modal(['wc-admin-order-meta-boxes']);
            } else {
                add_filter('woocommerce_payment_gateway_supports', function ($result, $feature) {
                    if ($feature == 'refunds') {
                        return false;
                    }
                    return $result;
                }, 10, 2);
            }

            $key = Helpers::addScript('refund.min.js');

            wp_localize_script($key, 'CP_REFUND', [
                'refundableAmount' => $refundableAmount,
                'lang' => [
                    // @phpcs:disable Generic.Files.LineLength 
                    "orderNotRefundable" => esc_html__(
                        'This order cannot be refunded with CryptoPay! There may be several reasons for this. The sender address may not have been saved because the old version was created at the time. Or the blockchain network on which the payment was made may not be active at the moment.. Please try manual.',
                        'cryptopay'
                    ),
                    // @phpcs:enable
                    "refundAmountRequired" => esc_html__('Refund amount required!', 'cryptopay'),
                    "refundAmountExceedMsg" => esc_html__(
                        'Refund amount cannot exceed {amount} {currency}!',
                        'cryptopay'
                    ),
                    "refundSuccessMsg" => esc_html__('Refund request has been sent successfully!', 'cryptopay'),
                    "pleaseWait" => esc_html__('Please wait...', 'cryptopay'),
                ]
            ]);
        } else {
            add_filter('woocommerce_admin_order_should_render_refunds', '__return_false');
        }
    }
}
