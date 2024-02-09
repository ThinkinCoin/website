<?php

declare(strict_types=1);

namespace BeycanPress\CryptoPay\Services;

class Initialize
{
    /**
     * @return void
     */
    public function __construct()
    {
        new Cron();
        new Verifier();
        new Sanctions();
        new Discounts();
        new ReminderEmail();
    }
}
