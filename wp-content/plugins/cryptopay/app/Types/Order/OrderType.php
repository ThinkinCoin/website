<?php

declare(strict_types=1);

namespace BeycanPress\CryptoPay\Types\Order;

use BeycanPress\CryptoPay\Types\AbstractType;
use BeycanPress\CryptoPay\Types\Network\CurrencyType;

/**
 * Order type
 * @since 2.1.0
 */
class OrderType extends AbstractType
{
    /**
     * @var int|null
     */
    private ?int $id = null;

    /**
     * @var float
     */
    private float $amount;

    /**
     * @var string
     */
    private string $currency;

    /**
     * @var float|null
     */
    private ?float $paymentAmount = null;

    /**
     * @var CurrencyType|null
     */
    private ?CurrencyType $paymentCurrency = null;

    /**
     * @var float|null
     */
    private ?float $discountRate = null;

    /**
     * @var RefundsType
     */
    private RefundsType $refunds;

    /**
     * @return void
     */
    public function __construct()
    {
        $this->amount = 0;
        $this->currency = '';
        $this->refunds = new RefundsType();
    }

    /**
     * @param int|null $id
     * @return self
     */
    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param float $amount
     * @return self
     */
    public function setAmount(float $amount): self
    {
        $this->amount = abs($amount);
        return $this;
    }

    /**
     * @param string $currency
     * @return self
     */
    public function setCurrency(string $currency): self
    {
        $this->currency = strtoupper($currency);
        return $this;
    }

    /**
     * @param float $paymentAmount
     * @return self
     */
    public function setPaymentAmount(float $paymentAmount): self
    {
        $this->paymentAmount = abs($paymentAmount);
        return $this;
    }

    /**
     * @param CurrencyType $paymentCurrency
     * @return self
     */
    public function setPaymentCurrency(CurrencyType $paymentCurrency): self
    {
        $this->paymentCurrency = $paymentCurrency;
        return $this;
    }

    /**
     * @param float|null $discountRate
     * @return self
     */
    public function setDiscountRate(?float $discountRate): self
    {
        $this->discountRate = $discountRate;
        return $this;
    }

    /**
     * @param RefundType $refund
     * @return self
     */
    public function addRefund(RefundType $refund): self
    {
        $this->refunds->addRefund($refund);
        return $this;
    }

    /**
     * @param RefundsType $refunds
     * @return self
     */
    public function setRefunds(RefundsType $refunds): self
    {
        $this->refunds = $refunds;
        return $this;
    }

    /**
     * @param int $refundId
     * @return self
     */
    public function deleteRefund(int $refundId): self
    {
        $this->refunds->deleteRefund($refundId);
        return $this;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @return float|null
     */
    public function getPaymentAmount(): ?float
    {
        return $this->paymentAmount;
    }

    /**
     * @return CurrencyType|null
     */
    public function getPaymentCurrency(): ?CurrencyType
    {
        return $this->paymentCurrency;
    }

    /**
     * @return float|null
     */
    public function getDiscountRate(): ?float
    {
        return $this->discountRate;
    }

    /**
     * @return RefundsType
     */
    public function getRefunds(): RefundsType
    {
        return $this->refunds;
    }

    /**
     * @return bool
     */
    public function exists(): bool
    {
        return $this->amount > 0 && !empty($this->currency);
    }

    /**
     * @return array<string,mixed>
     */
    public function prepareForJsSide(): array
    {
        return $this->toArray(exclude:[
            'refunds', 'discountRate'
        ]);
    }

    /**
     * @return array<string,mixed>
     */
    public function forDebug(): array
    {
        return array_filter([
            'id' => $this->getId(),
            'amount' => $this->getAmount(),
            'currency' => $this->getCurrency(),
            'discountRate' => $this->getDiscountRate(),
            'paymentAmount' => $this->getPaymentAmount(),
            'refunds' => $this->getRefunds()->toArray(),
            'paymentCurrency' => $this->paymentCurrency?->toArray(),
        ]);
    }
}
