<?php

declare(strict_types=1);

namespace BeycanPress\CryptoPay\Models;

/**
 * Order transaction table model
 */
final class OrderTransaction extends AbstractTransaction
{
    protected string $addon = 'woocommerce';

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct('order_transaction');
    }
}
