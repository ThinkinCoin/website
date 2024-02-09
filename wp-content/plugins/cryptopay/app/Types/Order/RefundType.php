<?php

declare(strict_types=1);

namespace BeycanPress\CryptoPay\Types\Order;

use BeycanPress\CryptoPay\Types\AbstractType;

/**
 * Refund type
 * @since 2.1.0
 */
class RefundType extends AbstractType
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var float
     */
    private float $amount;

    /**
     * @var float
     */
    private float $paymentAmount;

    /**
     * @var bool
     */
    private bool $manual = false;

    /**
     * @param int $id
     * @param float $amount
     * @param float $paymentAmount
     * @param bool $manual
     */
    public function __construct(int $id = 0, float $amount = 0, float $paymentAmount = 0, bool $manual = false)
    {
        $this->setId($id);
        $this->setAmount($amount);
        $this->setPaymentAmount($paymentAmount);
        $this->setManual($manual);
    }

    /**
     * @param int $id
     * @return self
     */
    public function setId(int $id): self
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
        $this->amount = $amount;
        return $this;
    }

    /**
     * @param float $paymentAmount
     * @return self
     */
    public function setPaymentAmount(float $paymentAmount): self
    {
        $this->paymentAmount = $paymentAmount;
        return $this;
    }

    /**
     * @param bool $manual
     * @return self
     */
    public function setManual(bool $manual): self
    {
        $this->manual = $manual;
        return $this;
    }

    /**
     * @return int
     */
    public function getId(): int
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
     * @return float
     */
    public function getPaymentAmount(): float
    {
        return $this->paymentAmount;
    }

    /**
     * @return bool
     */
    public function isManual(): bool
    {
        return $this->manual;
    }
}
