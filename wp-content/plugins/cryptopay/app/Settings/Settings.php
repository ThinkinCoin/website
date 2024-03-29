<?php

declare(strict_types=1);

namespace BeycanPress\CryptoPay\Settings;

// @phpcs:disable Generic.Files.LineLength 

use BeycanPress\CryptoPay\Helpers;
use BeycanPress\CryptoPay\PluginHero\Hook;
use BeycanPress\CryptoPay\PluginHero\Setting;

class Settings extends Setting
{
    /**
     * @return void
     */
    public function __construct()
    {
        $this->createFeedbackPage($parent = Helpers::getPage('HomePage')->getSlug());
        parent::__construct(esc_html__('Settings', 'cryptopay'), $parent, [
            'protect' => true
        ]);

        $networkSorting = [];
        $networkCodes = Helpers::getNetworkCodes();

        foreach ($networkCodes as $value) {
            $networkSorting['fields'][] = [
                'id'    => $value,
                'type'  => 'text',
                'title' => $value,
            ];
            $networkSorting['default'][$value] = $value;
        }

        self::createSection(array(
            'id'     => 'generalSettings',
            'title'  => esc_html__('General settings', 'cryptopay'),
            'icon'   => 'fa fa-cog',
            'fields' => array(
                array(
                    'id'      => 'dds',
                    'title'   => esc_html__('Data deletion status', 'cryptopay'),
                    'type'    => 'switcher',
                    'default' => false,
                    'help'    => esc_html__('This setting is passive come by default. You enable this setting. All data created by the plug-in will be deleted while removing the plug-in.', 'cryptopay')
                ),
                array(
                    'id'      => 'debugging',
                    'title'   => esc_html__('Debugging', 'cryptopay'),
                    'type'    => 'switcher',
                    'default' => false,
                    'desc'    => esc_html__('The Debug menu will appear when this setting is turned on and the log file is created.', 'cryptopay'),
                    'help'    => esc_html__('This setting has been added for the developer team rather than the users. If you open a support ticket to us due to a bug, we will use this setting to check the plugin progress.', 'cryptopay')
                ),
                array(
                    'id'      => 'testnet',
                    'title'   => esc_html__('Testnet', 'cryptopay'),
                    'type'    => 'switcher',
                    'default' => false,
                    'help'    => esc_html__('When you activate this setting, CryptoPay starts working on testnets.', 'cryptopay')
                ),
                array(
                    'id'      => 'theme',
                    'title'   => esc_html__('Theme', 'cryptopay'),
                    'type'    => 'select',
                    'help'    => esc_html__('Payment process theme', 'cryptopay'),
                    'options' => [
                        'light' => esc_html__('Light', 'cryptopay'),
                        'dark' => esc_html__('Dark', 'cryptopay')
                    ],
                    'default' => 'light',
                ),
                array(
                    'id'      => 'mode',
                    'title'   => esc_html__('Mode', 'cryptopay'),
                    'type'    => 'select',
                    'options' => [
                        'network' => esc_html__('Network', 'cryptopay'),
                        'currency' => esc_html__('Currency', 'cryptopay'),
                    ],
                    'default' => 'network',
                    'desc'    => esc_html__('You can choose the mode you want to use in the payment process. If you choose the network mode, the user will first choose the network and then the currency and then the wallet. If you choose the currency mode, the user will first choose the currency and then the wallet.', 'cryptopay')
                ),
                array(
                    'id'      => 'wcProjectId',
                    'title'   => esc_html__('WalletConnect Project ID', 'cryptopay'),
                    'type'    => 'text',
                    'desc'    => esc_html__('WalletConnect Project ID is required for WalletConnect and Web3Modal, which are used to connect to mobile wallets on many networks. If you do not have a WalletConnect Project ID, WalletConnect and Web3Modal will not work. You can get your project ID by registering for WalletConnect Cloud at the link below.', 'cryptopay')
                    . CP_BR2 .
                    Helpers::view('components/link', [
                        'text' => esc_html__('WalletConnect Cloud', 'cryptopay'),
                        'url' => 'https://cloud.walletconnect.com/sign-in'
                    ])
                    ,
                ),
                array_merge(
                    array(
                        'id'        => 'networkSorting',
                        'type'      => 'sortable',
                        'title'     => esc_html__('Network sorting', 'cryptopay'),
                        'no_fields_message' => esc_html__('No active networks found!', 'cryptopay'),
                    ),
                    $networkSorting
                )
            )
        ));

        self::createSection(array(
            'id'     => 'wooCommerceSettings',
            'title'  => esc_html__('WooCommerce settings', 'cryptopay'),
            'icon'   => 'fa fa-cog',
            'fields' => array(
                array(
                    'id'      => 'acceptSubscriptionPayments',
                    'title'   => esc_html__('Accept subscription payments (Via manual renewal)', 'cryptopay'),
                    'type'    => 'switcher',
                    'desc'    => esc_html__('It is possible to receive automatic payments in cryptocurrencies in various ways, but automatic payments will not be introduced because malicious customers can use this situation to steal the customer\'s funds.', 'cryptopay'),
                    'help'    => esc_html__('CryptoPay will work directly if manual payments are enabled in the subscription setting. You can enable this setting for CryptoPay to work when this setting is off.', 'cryptopay'),
                    'default' => false,
                ),
                array(
                    'id'      => 'acceptInstantPayments',
                    'title'   => esc_html__('Accept instant payments', 'cryptopay'),
                    'type'    => 'switcher',
                    'desc'    => esc_html__('As with PayPal, a Buy with Crypto Pay button appears directly on the product page, and users can instantly create an order by paying directly with CryptoPay. ', 'cryptopay') . sprintf(esc_html__('If the %s setting is active in WooCommerce settings, non-registered users can use instant payments.', 'cryptopay'), '<a href="' . admin_url('admin.php?page=wc-settings&tab=account') . '" target="_blank">' . esc_html__('"Allow customers to place orders without an account"', 'cryptopay') . '</a>'),
                    'default' => false,
                ),
                array(
                    'id'      => 'paymentReceivingArea',
                    'title'   => esc_html__('Payment receiving area', 'cryptopay'),
                    'type'    => 'select',
                    'options' => [
                        'checkout' => esc_html__('Checkout', 'cryptopay'),
                        'orderPay' => esc_html__('Order pay', 'cryptopay')
                    ],
                    'help'    => esc_html__('With this setting, you can choose from where the user receives the payment. With the checkout option, payment will be taken directly from the checkout page before the order is created, and then the order will be created. After the order is created with the Order Pay option, payment will be received on the Order Pay page.', 'cryptopay'),
                    'default' => 'orderPay'
                ),
                array(
                    'id'      => 'paymentCompleteOrderStatus',
                    'title'   => esc_html__('Payment complete order status', 'cryptopay'),
                    'type'    => 'select',
                    'help'    => esc_html__('The status to apply for WooCommerce order after payment is complete.', 'cryptopay'),
                    'options' => [
                        'wc-completed' => esc_html__('Completed', 'cryptopay'),
                        'wc-processing' => esc_html__('Processing', 'cryptopay')
                    ],
                    'default' => 'wc-completed',
                ),
                array(
                    'id'      => 'activateWooCommercePaymentGateway',
                    'title'   => esc_html__('Activate WooCommerce payment gateway', 'cryptopay'),
                    'type'    => 'content',
                    'content' => Helpers::view('components/link', [
                        'text' => esc_html__('Click to activate', 'cryptopay'),
                        'url' => admin_url('admin.php?page=wc-settings&tab=checkout&section=cryptopay')
                    ])
                )
            )
        ));

        EvmChains::initSettings();

        Hook::callAction("settings");

        if (!Helpers::getProp('anyNetworkSupportAddonLoaded', false)) {
            Settings::createSection(array(
                'id'     => 'bitcoin',
                'title'  => esc_html__('Bitcoin settings', 'cryptopay'),
                'icon'   => 'fab fa-bitcoin',
                'fields' => array(
                    array(
                        'id'      => 'bitcoinPayments',
                        'title'   => esc_html__('Bitcoin payments', 'cryptopay'),
                        'type'    => 'content',
                        'content' => esc_html__('CryptoPay supports all EVM-based networks by default, but you can start accepting payments from other blockchain networks by purchasing extra network support.', 'cryptopay') . CP_BR2 . '<a href="https://beycanpress.com/our-plugins/?categoryId=88&utm_source=plugin_settings&utm_medium=bitcoin_payments&utm_campaign=buy_custom_networks" target="_blank">' . esc_html__('Buy custom network supports', 'cryptopay') . '</a>'
                    ),
                )
            ));
        }

        self::createSection(array(
            'id'     => 'currencyDiscountsRates',
            'title'  => esc_html__('Currency discounts', 'cryptopay'),
            'icon'   => 'fa fa-percent',
            'fields' => array(
                array(
                    'id' => 'currencyDiscountsRatesInfo',
                    'type' => 'content',
                    'content' => 'Currency discounts is a feature where you can define special discounts for certain currencies. For example, you have a token specific to your project or you are sponsored by any token project. In this case, you can give percentage discounts to your paying users to encourage them to pay with this token.
                    ' . CP_BR2 . '
                    <a href="https://beycanpress.gitbook.io/cryptopay-docs/currency-discounts" target="_blank">' . esc_html__('Click for more information', 'cryptopay') . '</a>',
                    'title' => esc_html__('What is a currency discounts?', 'cryptopay')
                ),
                array(
                    'id'           => 'discountRates',
                    'type'         => 'group',
                    'title'        => esc_html__('Currency discounts', 'cryptopay'),
                    'button_title' => esc_html__('Add new', 'cryptopay'),
                    'help'         => esc_html__('You can define shopping-specific discounts for tokens with the symbols of the currency.', 'cryptopay'),
                    'sanitize' => function ($val) {
                        if (is_array($val)) {
                            foreach ($val as $key => &$value) {
                                $value['rate'] = floatval($value['rate']);
                                $value['symbol'] = strtoupper(sanitize_text_field($value['symbol']));
                            }
                        }

                        return $val;
                    },
                    'validate' => function ($val) {
                        if (is_array($val)) {
                            foreach ($val as $key => $value) {
                                if (empty($value['symbol'])) {
                                    return esc_html__('Symbol cannot be empty.', 'cryptopay');
                                } elseif (empty($value['rate'])) {
                                    return esc_html__('Discount rate cannot be empty.', 'cryptopay');
                                }
                            }
                        }
                    },
                    'fields'      => array(
                        array(
                            'title' => esc_html__('Symbol', 'cryptopay'),
                            'id'    => 'symbol',
                            'type'  => 'text'
                        ),
                        array(
                            'title' => esc_html__('Discount rate (in %)', 'cryptopay'),
                            'id'    => 'rate',
                            'type'  => 'number'
                        ),
                    ),
                ),
            )
        ));

        $converters = Hook::callFilter(
            "converters",
            [
                'CryptoCompare' => 'Default (CryptoCompare)',
            ]
        );

        $apiOptions = Hook::callFilter(
            "api_options",
            []
        );

        self::createSection(array(
            'id'     => 'currencyConverter',
            'title'  => esc_html__('Currency converter', 'cryptopay'),
            'icon'   => 'fas fa-dollar-sign',
            'fields' => array_merge(array(
                array(
                    'id' => 'otherConverterLinks',
                    'type' => 'content',
                    'content' => 'Currently, in crypto payments, most people list prices in FIAT currencies, i.e. currencies such as USD, EUR. With the currency converter, we convert these currencies into the currency chosen by the user. By default the CryptoCompare API is available. If your token is listed on Coin Market Cap, Coin Gecko or DEXs. You can get suitable currency converter add-ons to get the price value of your token.
                    ' . CP_BR2 . '
                    <a href="https://beycanpress.gitbook.io/cryptopay-docs/currency-converter" target="_blank">' . esc_html__('Click for more information', 'cryptopay') . '</a>
                    ' . CP_BR2 . '<a href="https://beycanpress.com/our-plugins/?categoryId=167&utm_source=plugin_settings&utm_medium=currency_converter&utm_campaign=buy_custom_converters" target="_blank">' . esc_html__('Buy custom converters', 'cryptopay') . '</a>',
                    'title' => esc_html__('What is a currency converter?', 'cryptopay')
                ),
                array(
                    'id' => 'autoPriceUpdateMin',
                    'type' => 'number',
                    'title' => esc_html__('Auto price update (Min)', 'cryptopay'),
                    'help' => esc_html__('The setting where you specify how long the price will be updated after the network and cryptocurrency has been selected.', 'cryptopay'),
                    'default' => 0.5,
                    'sanitize' => function ($val) {
                        return floatval($val);
                    }
                ),
                array(
                    'id'           => 'customPrices',
                    'type'         => 'group',
                    'title'        => esc_html__('Custom prices', 'cryptopay'),
                    'button_title' => esc_html__('Add new', 'cryptopay'),
                    'help'         => esc_html__('You can assign prices corresponding to fiat currencies to your own custom tokens.', 'cryptopay'),
                    'desc'         => esc_html__('If your currency is not available in the current API. You can define a special value for it.', 'cryptopay') . ' <a href="https://beycanpress.gitbook.io/cryptopay-docs/how-custom-prices-work" target="_blank">' . esc_html__('Get more info', 'cryptopay') . '</a>',
                    'sanitize' => function ($val) {
                        if (is_array($val)) {
                            foreach ($val as $key => &$value) {
                                $value['symbol'] = strtoupper(sanitize_text_field($value['symbol']));
                                if (isset($value['prices'])) {
                                    foreach ($value['prices'] as $key => &$money) {
                                        $money['symbol'] = strtoupper(sanitize_text_field($money['symbol']));
                                        $money['price'] = floatval($money['price']);
                                    }
                                }
                            }
                        }
                        return $val;
                    },
                    'validate' => function ($val) {
                        if (is_array($val)) {
                            foreach ($val as $key => $value) {
                                if (empty($value['symbol'])) {
                                    return esc_html__('Symbol cannot be empty.', 'cryptopay');
                                } elseif (!isset($value['prices'])) {
                                    return esc_html__('You must add at least one currency price', 'cryptopay');
                                } elseif (isset($value['prices'])) {
                                    foreach ($value['prices'] as $key => $money) {
                                        if (empty($money['symbol'])) {
                                            return esc_html__('Currency symbol cannot be empty.', 'cryptopay');
                                        } elseif (empty($money['price'])) {
                                            return esc_html__('Currency price cannot be empty.', 'cryptopay');
                                        }
                                    }
                                }
                            }
                        }
                    },
                    'fields' => array(
                        array(
                            'title' => esc_html__('Symbol', 'cryptopay'),
                            'id'    => 'symbol',
                            'type'  => 'text',
                            'help'  => esc_html__('Cryptocurrency symbol or fiat money symbol (ISO Code)', 'cryptopay')
                        ),
                        array(
                            'id'           => 'prices',
                            'type'         => 'group',
                            'title'        => esc_html__('Prices', 'cryptopay'),
                            'button_title' => esc_html__('Add new', 'cryptopay'),
                            'fields'      => array(
                                array(
                                    'title' => esc_html__('Symbol', 'cryptopay'),
                                    'id'    => 'symbol',
                                    'type'  => 'text',
                                    'help'  => esc_html__('Cryptocurrency symbol or fiat money symbol (ISO Code)', 'cryptopay')
                                ),
                                array(
                                    'title' => esc_html__('Price', 'cryptopay'),
                                    'id'    => 'price',
                                    'type'  => 'number',
                                ),
                            ),
                        ),
                    ),
                ),
                array(
                    'id' => 'converter',
                    'type'  => 'select',
                    'title' => esc_html__('Converter API', 'cryptopay'),
                    'options' => $converters,
                    'default' => 'CryptoCompare'
                ),
            ), $apiOptions)
        ));

        self::createSection(array(
            'id'     => 'addressSanctions',
            'title'  => esc_html__('Address sanctions', 'cryptopay'),
            'icon'   => 'fas fa-fingerprint',
            'fields' => array(
                array(
                    'id'      => 'sanctions',
                    'title'   => esc_html__('Active/Passive', 'cryptopay'),
                    'type'    => 'switcher',
                    'default' => false,
                ),
                array(
                    'id'      => 'sanctionsApi',
                    'title'   => esc_html__('Provider', 'cryptopay'),
                    'type'    => 'select',
                    'options' => [
                        'coinfirm' => esc_html__('Coinfirm', 'cryptopay'),
                    ],
                ),
                array(
                    'id'      => 'sanctionsMode',
                    'title'   => esc_html__('Mode', 'cryptopay'),
                    'type'    => 'select',
                    'options' => [
                        "restrict" => esc_html__('Restrict', 'cryptopay'),
                        "take-note" => esc_html__('Take note', 'cryptopay'),
                    ],
                    'default' => 'restrict',
                    'desc'    => esc_html__('If you choose the restrict mode, the user will not be able to proceed with the payment if the address is in the sanctions list. If you choose the take note mode, the user will be able to proceed with the payment, but a warning will be recored. Restirct mode not working with "Pay by transfer to address (QR Code)" payments', 'cryptopay')
                ),
                array(
                    'id'      => 'sanctionsApiKey',
                    'title'   => esc_html__('API key', 'cryptopay'),
                    'type'    => 'text',
                    'dependency' => array('sanctionsApi', '==', 'coinfirm'),
                ),
                array(
                    'id'      => 'sanctionsApiInfoConfirm',
                    'type'    => 'content',
                    'content' => esc_html__('Coinfirm only supports EVM Chains', 'cryptopay') . CP_BR2 . esc_html__('Get Coinfirm api key (token): ', 'cryptopay') . '<a href="https://platform.coinfirm.com/settings/account" target="_blank">https://platform.coinfirm.com/settings/account</a>' . CP_BR2 . esc_html__('You can get an more information from the following link: ', 'cryptopay') . '<a href="https://platform.coinfirm.com/" target="_blank">https://platform.coinfirm.com/</a>',
                    'dependency' => array('sanctionsApi', '==', 'coinfirm'),
                )
            )
        ));

        self::createSection(array(
            'id'     => 'cron',
            'title'  => esc_html__('Cron settings', 'cryptopay'),
            'icon'   => 'fa fa-clock',
            'fields' => array(
                array(
                    'id'      => 'reminderEmail',
                    'title'   => esc_html__('Reminder email', 'cryptopay'),
                    'type'    => 'switcher',
                    'default' => false,
                    'help'    => esc_html__('Users see a button called set reminder email during payment, and when they confirm this, the payment process is interrupted there and tells the user that they will receive a notification when the payment is completed. For this, please make sure you have adjusted the cron settings.', 'cryptopay')
                ),
                array(
                    'id'      => 'backendConfirmation',
                    'title'   => esc_html__('Backend confirmation', 'cryptopay'),
                    'type'    => 'switcher',
                    'default' => true,
                    'help'    => esc_html__('If you open this break, let\'s assume that the user left the page during the payment, his internet was lost or his computer was shut down. When this setting is on, when the user comes back to the site and looks at their orders, the payment status of the order is checked while the order page is loaded, and if the transaction is successful, the order is confirmed. It also happens when an admin enters the Order transaction page.', 'cryptopay')
                ),
                array(
                    'id'      => 'cronType',
                    'title'   => esc_html__('Cron type', 'cryptopay'),
                    'type'    => 'select',
                    'desc'    => esc_html__('CryptoPay uses cron jobs to check the status of transactions and to send reminder emails. If you have not set up cron jobs on your server, you can use the following settings.', 'cryptopay'),
                    'options' => [
                        'wp' => esc_html__('WordPress Cron', 'cryptopay'),
                        'server' => esc_html__('Server Cron (recommended)', 'cryptopay')
                    ],
                    'default' => 'server',
                    'help'    => esc_html__('The difference between WordPress and Server cron is this. WordPress cron is triggered when someone enters the site. If the process is long, the user will have to wait for a certain amount of time while entering the site. Also, it will not work instantly because it is activated when a person enters the site. In contrast, Server cron is triggered by the server and will run just in time, and since it\'s not a user, it won\'t change anything no matter how long it takes. Users will be able to access your site quickly.', 'cryptopay')
                ),
                array(
                    'id'      => 'cronTime',
                    'title'   => esc_html__('Cron time (in minutes)', 'cryptopay'),
                    'type'    => 'number',
                    'default' => 5,
                    'dependency' => array('cronType', '==', 'wp'),
                    'desc'    => esc_html__('You can decide how many minutes apart it should run. However, we recommend 5 minutes.', 'cryptopay')
                ),
                array(
                    'type'  => 'content',
                    'dependency' => array('cronType', '==', 'server'),
                    'content' => '
                    <strong>API 1</strong>: ' . home_url('?rest_route=/cryptopay/verify-pending-transactions') . ' (GET, POST)
                    
                    ' . CP_BR2 . '

                    This API checks pending transactions and confirms them based on status. If a user has set a reminder email, if a cron setting has not been added for this API but the backend confirmation setting is turned on, he will receive a reminder email when he comes to the site again or when you enter the transactions menu. 

                    ' . CP_BR2 . '
                    
                    You can decide how many minutes apart it should run. However, we recommend 5 minutes.

                    ' . CP_BR2 . '

                    If you have added a cron setting for this API, you can turn off backend confirmation. Because pending transactions will be checked regularly.

                    ' . CP_BR2 . '

                    To find out whether the cron you added is working or not, you can turn on debugging and wait for the cron running time, then search for "Verify pending transactions process (API)" under the debug logs menu. If you see this message, cron is running.

                    ' . CP_BR2 . '
                    <a href="https://www.hivelocity.net/kb/what-is-cron-job/" target="_blank">' . esc_html__('Click for more information', 'cryptopay') . '</a>
                    '
                ),
            )
        ));

        self::createSection(array(
            'id'     => 'backup',
            'title'  => esc_html__('Backup', 'cryptopay'),
            'icon'   => 'fas fa-shield-alt',
            'fields' => array(
                array(
                    'type'  => 'backup',
                    'title' => esc_html__('Backup', 'cryptopay')
                ),
            )
        ));

        add_action('admin_footer', function (): void {
            Helpers::viewEcho('css/settings-css');
        });
    }

    /**
     * @param string $parent
     * @return void
     */
    private function createFeedbackPage(string $parent): void
    {
        add_action('admin_menu', function () use ($parent): void {
            add_submenu_page(
                $parent,
                esc_html__('Feedback', 'cryptopay'),
                esc_html__('Feedback', 'cryptopay'),
                'manage_options',
                'cryptopay_feedback',
                function (): void {
                    Helpers::viewEcho('feedback');
                }
            );
        });
    }
}
