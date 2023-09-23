<?php

namespace BeycanPress\CryptoPay\Models;

/**
 * Order transaction table model
 */
class OrderTransaction extends AbstractTransaction 
{
    public $addon = 'woocommerce';
    
    public function __construct()
    {
        parent::__construct('order_transaction');
    }
}