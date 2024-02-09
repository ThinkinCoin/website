<?php

declare(strict_types=1);

namespace BeycanPress\CryptoPay\WooCommerce;

// Classes
use BeycanPress\CryptoPay\Helpers;
use BeycanPress\CryptoPay\Pages\TransactionPage;

class Initialize
{
    /**
     * @return void
     */
    public function __construct()
    {
        // Register WooCommerce
        if (function_exists('WC')) {
            Helpers::registerIntegration('woocommerce');

            new Gateway\Register();
            new Services\Payment();
            new Services\Details();

            if (is_admin()) {
                new TransactionPage(
                    esc_html__('Order transactions', 'cryptopay'),
                    'woocommerce',
                    2,
                    [
                        'orderId' => function ($tx) {
                            return Helpers::view('components/link', [
                                'url' => get_edit_post_link($tx->orderId),
                                'text' => $tx->orderId
                            ]);
                        }
                    ]
                );
            }
        }
    }
}
