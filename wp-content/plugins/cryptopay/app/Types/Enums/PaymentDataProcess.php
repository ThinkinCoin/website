<?php

declare(strict_types=1);

namespace BeycanPress\CryptoPay\Types\Enums;

enum PaymentDataProcess: string
{
    use EnumHelperMethods;

    case INIT = 'init';
    case PAYMENT_FINISHED = 'payment-finished';
    case CREATE_TRANSACTION = 'create-transaction';
}
