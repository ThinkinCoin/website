<?php

declare(strict_types=1);

namespace BeycanPress\CryptoPay\Types\Order;

use BeycanPress\CryptoPay\Types\AbstractListType;

/**
 * Refunds type
 * @since 2.1.0
 */
class RefundsType extends AbstractListType
{
    /**
     * @var string
     */
    protected static string $type = RefundType::class;

    /**
     * @param array<RefundType> $refunds
     */
    public function __construct(array $refunds = [])
    {
        $this->addRefunds($refunds);
    }

    /**
     * @param RefundType $refund
     * @return self
     */
    public function addRefund(RefundType $refund): self
    {
        $this->list[$refund->getId()] = $refund;

        return $this;
    }

    /**
     * @param int $id
     * @return RefundType|null
     */
    public function getRefund(int $id): ?RefundType
    {
        foreach ($this->list as $refund) {
            if ($refund->getId() == $id) {
                return $refund;
            }
        }

        return null;
    }

    /**
     * @param int $id
     * @return self
     */
    public function deleteRefund(int $id): self
    {
        if (isset($this->list[$id])) {
            unset($this->list[$id]);
        }

        return $this;
    }

    /**
     * @param array<RefundType> $refunds
     * @return self
     */
    public function addRefunds(array $refunds): self
    {
        foreach ($refunds as $refund) {
            $this->addRefund($refund);
        }

        return $this;
    }

    /**
     * @return float
     */
    public function getTotalAmount(): float
    {
        $total = 0;
        foreach ($this->list as $refund) {
            $total += $refund->getAmount();
        }

        return $total;
    }

    /**
     * @return float
     */
    public function getTotalPaymentAmount(): float
    {
        $total = 0;
        foreach ($this->list as $refund) {
            $total += $refund->getPaymentAmount();
        }

        return $total;
    }

    /**
     * @return bool
     */
    public function hasManual(): bool
    {
        foreach ($this->list as $refund) {
            if ($refund->isManual()) {
                return true;
            }
        }

        return false;
    }
}
