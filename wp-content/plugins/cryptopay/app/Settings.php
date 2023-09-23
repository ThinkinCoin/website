<?php

namespace BeycanPress\CryptoPay;

use \BeycanPress\CryptoPay\PluginHero\Hook;
use \BeycanPress\CryptoPay\PluginHero\Setting;
use \BeycanPress\CryptoPay\PluginHero\Helpers;

class Settings extends Setting
{
    use Helpers;
    
    /**
     * @var array
     */
    public static $customPrices = [];

    /**
     * @var array
     */
    public static $tokenDiscounts = [];

    public function __construct()
    {
        $parent = $this->pages->HomePage->slug;
        $this->createFeedbackPage($parent);
        parent::__construct(esc_html__('Settings', 'cryptopay'), $parent);
        $this->licensed();

        $networkSorting = [];
        $networkCodes = Services::getNetworkCodes();
        
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
                    'id'      => 'backendConfirmation',
                    'title'   => esc_html__('Backend confirmation', 'cryptopay'),
                    'type'    => 'switcher',
                    'default' => true,
                    'help'    => esc_html__('If you open this break, let\'s assume that the user left the page during the payment, his internet was lost or his computer was shut down. When this setting is on, when the user comes back to the site and looks at their orders, the payment status of the order is checked while the order page is loaded, and if the transaction is successful, the order is confirmed. It also happens when an admin enters the Order transaction page.', 'cryptopay')
                ),
                array(
                    'id'      => 'theme',
                    'title'   => esc_html__('Theme', 'cryptopay'),
                    'type'    => 'select',
                    'help'    => esc_html__('Payment process theme', 'cryptopay'),
                    'options' => [
                        'default' => esc_html__('Default', 'cryptopay'),
                        'dark' => esc_html__('Dark', 'cryptopay')
                    ],
                    'default' => 'default',
                ),
                array_merge(
                    array(
                        'id'        => 'networkSorting',
                        'type'      => 'sortable',
                        'title'     => esc_html__('Network sorting', 'cryptopay'),
                        'no_fields_message' => esc_html__('No active networks found!', 'cryptopay'),
                    )
                , $networkSorting)
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
                    'id'      => 'paymentReceivingArea',
                    'title'   => esc_html__('Payment receiving area', 'cryptopay'),
                    'type'    => 'select',
                    'options' => [
                        'checkout' => esc_html__('Checkout', 'cryptopay'),
                        'orderPay' => esc_html__('Order pay', 'cryptopay')
                    ],
                    'help'    => esc_html__('With this setting, you can choose from where the user receives the payment. With the checkout option, payment will be taken directly from the checkout page before the order is created, and then the order will be created. After the order is created with the Order Pay option, payment will be received on the Order Pay page.', 'cryptopay'),
                    'default' => 'checkout',
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
            )
        ));

        EvmBased::initSettings();

        Hook::callAction("settings");

        // self::createSection(array(
        //     'id'     => 'tokenDiscountsRates', 
        //     'title'  => esc_html__('Token discounts', 'cryptopay'),
        //     'icon'   => 'fa fa-percent',
        //     'fields' => array(
        //         array(
        //             'id'           => 'tokenDiscounts',
        //             'type'         => 'group',
        //             'title'        => esc_html__('Token discounts', 'cryptopay'),
        //             'button_title' => esc_html__('Add new', 'cryptopay'),
        //             'help'         => esc_html__('You can define shopping-specific discounts for tokens with the symbols of the tokens.', 'cryptopay'),
        //             'sanitize' => function($val) {
        //                 if (is_array($val)) {
        //                     foreach ($val as $key => &$value) {
        //                         $value['symbol'] = strtoupper(sanitize_text_field($value['symbol']));
        //                         $value['discountRate'] = floatval($value['discountRate']);
        //                     }
        //                 }

        //                 return $val;
        //             },
        //             'validate' => function($val) {
        //                 if (is_array($val)) {
        //                     foreach ($val as $key => $value) {
        //                         if (empty($value['symbol'])) {
        //                             return esc_html__('Symbol cannot be empty.', 'cryptopay');
        //                         } elseif (empty($value['discountRate'])) {
        //                             return esc_html__('Discount rate cannot be empty.', 'cryptopay');
        //                         }
        //                     }
        //                 }
        //             },
        //             'fields'      => array(
        //                 array(
        //                     'title' => esc_html__('Symbol', 'cryptopay'),
        //                     'id'    => 'symbol',
        //                     'type'  => 'text'
        //                 ),
        //                 array(
        //                     'title' => esc_html__('Discount rate (in %)', 'cryptopay'),
        //                     'id'    => 'discountRate',
        //                     'type'  => 'number'
        //                 ),
        //             ),
        //         ),
        //     ) 
        // ));

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
            'icon'   => 'fas fa-project-diagram',
            'fields' => array_merge(array(
                array(
                    'id' => 'otherConverterLinks',
                    'type' => 'content',
                    'content' => 'Currently, in crypto payments, most people list prices in FIAT currencies, i.e. currencies such as USD, EUR. With the currency converter, we convert these currencies into the currency chosen by the user. By default the CryptoCompare API is available. If your token is listed on Coin Market Cap, Coin Gecko or DEXs. You can get suitable currency converter add-ons to get the price value of your token.
                    <br><br><a href="https://bit.ly/41lD6Wl" target="_blank">'.esc_html__('Buy custom converters', 'cryptopay').'</a>',
                    'title' => esc_html__('What is a currency converter?', 'cryptopay')
                ),
                array(
                    'id' => 'autoPriceUpdateMin',
                    'type' => 'number',
                    'title' => esc_html__('Auto price update (Min)', 'cryptopay'),
                    'help' => esc_html__('The setting where you specify how long the price will be updated after the network and cryptocurrency has been selected.', 'cryptopay'),
                    'default' => 0.5,
                    'sanitize' => function($val) {
                        return floatval($val);
                    }
                ),
                array(
                    'id'           => 'customPrices',
                    'type'         => 'group',
                    'title'        => esc_html__('Custom prices', 'cryptopay'),
                    'button_title' => esc_html__('Add new', 'cryptopay'),
                    'help'         => esc_html__('You can assign prices corresponding to fiat currencies to your own custom tokens.', 'cryptopay'),
                    'desc'         => esc_html__('If your currency is not available in the current API. You can define a special value for it.', 'cryptopay') . ' <a href="https://beycanpress.gitbook.io/cryptopay-docs/how-custom-prices-work" target="_blank">'.esc_html__('Get more info', 'cryptopay').'</a>',
                    'sanitize' => function($val) {
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
                    'validate' => function($val) {
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

        add_action('admin_footer', function() {
            ?>
            <style>
                div[data-slug="cryptopay_settings"] .csf-field-sortable .csf-field-text input {
                    display: none;
                }
            </style>
            <?php
        });
    }

    // public static function getTokenDiscounts() : array
    // {
    //     $tokenDiscounts = self::get('tokenDiscounts');

    //     if (!empty(self::$tokenDiscounts) || !is_array($tokenDiscounts)) {
    //         return self::$tokenDiscounts;
    //     }

    //     foreach ($tokenDiscounts as $key => $token) {
    //         if (!$token['symbol']) continue;
    //         $tokenSymbol = strtoupper($token['symbol']);
    //         self::$tokenDiscounts[$tokenSymbol] = floatval($token['discountRate']);
    //     }

    //     return self::$tokenDiscounts;
    // }

    public static function getCustomPrices() : array
    {
        $customPrices = self::get('customPrices');

        if (!empty(self::$customPrices) || !is_array($customPrices)) {
            return self::$customPrices;
        }

        foreach ($customPrices as $key => $token) {
            if (!$token['symbol']) continue;
            $tokenSymbol = strtoupper($token['symbol']);
            self::$customPrices[$tokenSymbol] = [];
            foreach ($token['prices'] as $key => $price) {
                $symbol = strtoupper($price['symbol']);
                self::$customPrices[$tokenSymbol][$symbol] = floatval($price['price']); 
            }
        }

        return self::$customPrices;
    }
    
    /**
     * @param string $parent
     * @return void
     */
    private function createFeedbackPage(string $parent) : void
    {
        add_action('admin_menu', function() use ($parent) {
            add_submenu_page(
                $parent,
                esc_html__('Feedback', 'cryptopay'),
                esc_html__('Feedback', 'cryptopay'),
                'manage_options',
                'cryptopay_feedback',
                function() {
                    $this->viewEcho('feedback');
                }
            );
        });
    }
}