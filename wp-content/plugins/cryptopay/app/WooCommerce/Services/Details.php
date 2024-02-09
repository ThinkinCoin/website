<?php

declare(strict_types=1);

namespace BeycanPress\CryptoPay\WooCommerce\Services;

use BeycanPress\CryptoPay\Helpers;
use BeycanPress\CryptoPay\Models\OrderTransaction;
use BeycanPress\CryptoPay\Types\Enums\TransactionStatus as Status;

class Details
{
    /**
     * @var Refunds
     */
    private Refunds $refunds;

    /**
     * @return void
     */
    public function __construct()
    {
        $this->refunds = new Refunds();
        add_action('woocommerce_view_order', array($this, 'frontend'), 4);
        add_action('woocommerce_thankyou_cryptopay', array($this, 'frontend'), 1);
        add_action('woocommerce_admin_order_data_after_order_details', [$this, 'backend'], 10);
    }

    /**
     * @param int $orderId
     * @return void
     */
    public function frontend(int $orderId): void
    {
        $order = wc_get_order($orderId);

        if ('cryptopay' == $order->get_payment_method()) {
            $transaction = (new OrderTransaction())->getTransactionByOrderId($orderId);

            if ($order->get_status() == Status::PENDING->getValue() && !$transaction) {
                Helpers::viewEcho('woocommerce/pending', ['payUrl' => $order->get_checkout_payment_url(true)]);
            } elseif (!is_null($transaction)) {
                echo Helpers::getPaymentHtmlDetails($transaction);
            }
        }
    }

    /**
     * @param \WC_Order $order
     * @return void
     */
    public function backend(\WC_Order $order): void
    {
        if ($order->get_payment_method() == 'cryptopay') {
            $tx = (new OrderTransaction())->getTransactionByOrderId($order->get_id());
            if (!$tx) {
                return;
            }

            $this->refunds->init($order, $tx);

            $txOrder = $tx->getOrder();
            $amount = $txOrder->getPaymentAmount();
            $currency = $txOrder->getPaymentCurrency();

            if ($txOrder->getDiscountRate()) {
                $realAmount = Helpers::fromPercent($amount, $txOrder->getDiscountRate(), $currency->getDecimals());
            } else {
                $realAmount = null;
            }

            $refunds = $txOrder->getRefunds();
            $manualRefund = $refunds->hasManual();
            $refundedAmount = $refunds->getTotalAmount();
            $refundedPaymentAmount = Helpers::toString($refunds->getTotalPaymentAmount(), $currency->getDecimals());

            Helpers::viewEcho('woocommerce/details', [
                'order' => $txOrder,
                'realAmount' => $realAmount,
                'manualRefund' => $manualRefund,
                'refundedAmount' => $refundedAmount,
                'refundedPaymentAmount' => $refundedPaymentAmount,
                'transactionHash' => $tx->getHash(),
                'paymentAmount' => $txOrder->getPaymentAmount(),
                'blockchainNetwork' => $tx->getNetwork()->getName(),
                'paymentCurrency' => $txOrder->getPaymentCurrency()->getSymbol(),
            ]);
        }
    }
}
