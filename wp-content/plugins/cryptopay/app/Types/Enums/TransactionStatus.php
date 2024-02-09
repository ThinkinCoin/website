<?php

declare(strict_types=1);

namespace BeycanPress\CryptoPay\Types\Enums;

enum TransactionStatus: string
{
    use EnumHelperMethods;

    case PENDING = 'pending';
    case VERIFIED = 'verified';
    case FAILED = 'failed';
    case FULLY_REFUNDED = 'fully-refunded';
    case PARTIALLY_REFUNDED = 'partially-refunded';

    // olds
    /**
     * @deprecated
     */
    case REFUNDED = 'refunded';
    /**
     * @deprecated
     */
    case PARTIALLY_REFUND = 'partially-refund';

    /**
     * @return string
     */
    public function getValue(): string
    {
        switch ($this->value) {
            case 'refunded':
                return self::FULLY_REFUNDED->getValue();
            case 'partially-refund':
                return self::PARTIALLY_REFUNDED->getValue();
            default:
                return $this->value;
        }
    }
}
