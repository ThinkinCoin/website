<?php 

namespace BeycanPress\CryptoPay;

use \BeycanPress\CryptoPay\Lang;
use \BeycanPress\CurrencyConverter;
use \BeycanPress\CryptoPay\Settings;
use \MultipleChain\EvmChains\Provider;
use \BeycanPress\CryptoPay\PluginHero\Hook;
use \BeycanPress\CryptoPay\PluginHero\Plugin;
use \BeycanPress\CryptoPay\PluginHero\Helpers;

class Services 
{
    use Helpers;

    /**
     * @var array
     */
    private static $addons = [];

    public static function registerAddon(string $addon) : void
    {
        if (in_array($addon, self::$addons)) {
            throw new \Exception('This add-on is already registered, please choose another name!');
        }

        self::$addons[] = $addon;
    }

    /**
     * @param array $order
     * @param string $addon
     * @param boolean $confirmation
     * @param array $params
     * @return string
     */
    public static function startPaymentProcess(
        array $order, string $addon, bool $confirmation = true, array $params = []
    ) : string
    {
        if (!isset($order['amount'])) {
            throw new \Exception('Order amount parameter is required!');
        } elseif (!isset($order['currency'])) {
            throw new \Exception('Order currency parameter is required!');
        }

        return self::preparePaymentProcess($addon, $confirmation, [
            'order' => $order,
            'params' => $params,
            'autoLoad' => true
        ]);
    }

    /**
     * @param string $addon
     * @param boolean $confirmation
     * @param array $data
     * @return string
     */
    public static function preparePaymentProcess(
        string $addon, bool $confirmation = true, array $data = []
    ) : string
    {
        $autoLoad = isset($data['autoLoad']) ? $data['autoLoad'] : false;
        $pluginUrl = Plugin::$instance->pluginUrl;

        $walletImages = [
            'qr' => $pluginUrl . 'assets/images/wallets/qr.png',
        ];
        array_map(function($wallet) use ($pluginUrl, &$walletImages) {
            $walletImages[$wallet] = $pluginUrl . 'assets/images/wallets/' . $wallet . '.png';
        }, Services::getWalletsByCode('evmBased')); 
        
        $networks = Hook::callFilter('custom_networks', self::getNetworks());

        if (empty($networks)) {
            return esc_html__('No network is active, please activate at least one network!', 'cryptopay');
        }

        if (count($networks) == 1) {
            $init = self::autoInitalize($addon, $data, $networks[0]);
            if (is_string($init)) return $init;
            $data['init'] = $init;
        }

        $data = array_merge([
            'hooks' => [],
            'callbacks' => [],
            'addon' => $addon,
            'autoLoad'=> $autoLoad,
            'networks' => $networks,
            'transactionRecord' => true,
            'confirmation' => $confirmation,
            'apiUrl' => Plugin::$instance->apiUrl,
            'imagesUrl' => $pluginUrl . 'assets/images/',
            'version' => Plugin::$instance->pluginVersion,
            'debug' => boolval(Settings::get('debugging')),
            'lang' => Hook::callFilter('lang', Lang::get()),
            'logo' =>  $pluginUrl . 'assets/images/icon-256x256.png',
            'ensDomain' => Settings::get('ensDomainForEthereum'),
            'theme' => Hook::callFilter('theme', Settings::get('theme')),
            'providers' => array_keys(Hook::callFilter('js_providers', [])),
            'walletImages' => Hook::callFilter('wallet_images', $walletImages),
            'webSocketUrl' => "https://qr-verifier-7c7fab6cf733.herokuapp.com/",
            'autoPriceUpdateMin' => Settings::get('autoPriceUpdateMin') ?? 0.5,
            'providerConfig' => Hook::callFilter('provider_config', [
                'testnet' => boolval(Settings::get('testnet')),
                'wcProjectId' => "454e2fe5f5c378d9490742a44bbd1b5d",
            ])
        ], $data);

        Plugin::$instance->addScript('/cryptopay/js/chunk-vendors.js');
        Plugin::$instance->addScript('/cryptopay/js/app.js');
        Plugin::$instance->addStyle('/cryptopay/css/chunk-vendors.css');
        Plugin::$instance->addStyle('/cryptopay/css/app.css');
        
        $deps = array_values(Hook::callFilter('js_providers', []));
        $key = Plugin::$instance->addScript('main.min.js', array_merge(['jquery'], $deps));
        $key = !empty($deps) ? array_shift($deps) : $key;
        wp_localize_script($key, 'CryptoPay', $data);

        return Plugin::$instance->view('checkout', compact('autoLoad'));
    }

    /**
     * @param string $addon
     * @param array $data
     * @param array $network
     * @return array|string
     */
    private static function autoInitalize(string $addon, array $data, array $network)
    {
        $network = json_decode(json_encode($network));
        $paymentCurrency = $network->currencies[0];

        Plugin::$instance->debug('Initialize process (SERVICES)', 'INFO', [
            'addon' => $addon,
            'order' => $data['order'],
            'network' => self::removeNoNeededParamsForNetwork($network),
        ]);

        Plugin::$instance->debug('Calculating payment amount (SERVICES)');
        $paymentAmount = self::calculatePaymentAmont(
            $data['order']['currency'], 
            (object) $paymentCurrency, 
            $data['order']['amount'], 
            $network
        );

        if (is_null($paymentAmount)) {
            Plugin::$instance->debug('There was a problem converting currency! (SERVICES)', 'ERROR', [
                'addon' => $addon,
                'order' => $data['order'],
                'network' => self::removeNoNeededParamsForNetwork($network),
            ]);
            return esc_html__('There was a problem converting currency! Make sure your currency value is available in the relevant API or you define a custom value for your currency.', 'cryptopay');
        }

        $variables = self::getVariableParams([
            'addon' => $addon,
            'userId' => get_current_user_id(),
            'order' => $data['order'],
            'network' => $network,
        ]);
        
        if (!$variables['receiver']) {
            Plugin::$instance->debug('There was a problem getting wallet address! (SERVICES)', 'ERROR', [
                'addon' => $addon,
                'order' => $data['order'],
                'network' => self::removeNoNeededParamsForNetwork($network),
            ]);
            return esc_html__('There was a problem getting wallet address! Please make sure you enter a wallet (receiving) address!', 'cryptopay');
        }

        return array_merge([
            'paymentAmount' => $paymentAmount,
            'amount' => $data['order']['amount'],
        ], $variables);
    }

    /**
     * @param object $network
     * @return object
     */
    private static function removeNoNeededParamsForNetwork(object $network) : object
    {
        $network = clone $network;
        
        if (isset($network->wallets)) {
            unset($network->wallets);
        }

        if (isset($network->currencies)) {
            unset($network->currencies);
        }

        if (isset($network->image)) {
            unset($network->image);
        }

        if (isset($network->wsUrl)) {
            unset($network->wsUrl);
        }

        if (isset($network->mainnetId)) {
            unset($network->mainnetId);
        }

        return $network;
    }

    /**
     * @param object $transaction
     * @return string
     */
    public static function showPaymentDetails(object $transaction) : string 
    {
        Plugin::$instance->addStyle('main.min.css');
        $provider = self::getProviderByTx($transaction);
        $order = json_decode($transaction->order);
        $currency = $order->paymentCurrency;
        $amount = self::toString($order->paymentAmount ?? $order->paymentAmount, $currency->decimals);
        $transactionUrl = $provider->Transaction($transaction->hash)->getUrl();
        return Plugin::$instance->view('details', compact('transaction', 'transactionUrl', 'amount', 'currency'));
    }

    /**
     * @return array
     */
    public static function getNetworks() : array
    {
        $networkCodes = Services::getNetworkCodes();
        $networks = array_values(Hook::callFilter('networks', []));
        
        $orderedNetworks = [];
        foreach ($networkCodes as $value) {
            if ($value == 'evmBased') {
                $orderedNetworks = array_merge($orderedNetworks, EvmBased::getNetworks());
            } else {
                $index = array_search($value, array_column($networks, 'code'));
                if (isset($networks[$index])) $orderedNetworks[] = $networks[$index];
            }
        }

        return $orderedNetworks;
    }

    /**
     * @param object|array $data
     * @return array
     */
    public static function getVariableParams($data) : array
    {
        $data = is_object($data) ? $data : (object) $data;

        Plugin::$instance->debug('Getting wallet address');
        $receiver = self::getWalletAddress($data->network->code);
        $receiver = Hook::callFilter('receiver_' . $data->addon, $receiver, $data);

        return [
            'receiver' => $receiver,
            'qrCodeWaitingTime' => Services::getQrCodeWaitingTime($data->network->code),
            'blockConfirmationCount' => Services::getBlockConfirmationCount($data->network->code),
            'providerConfig' => Hook::callFilter('provider_config_' . $data->network->code, [
                'customWs' => Services::getCustomWsAddress($data->network->code),
                'customRpc' => Services::getCustomRpcAddress($data->network->code),
            ])
        ];
    }

    /**
     * @param string $code
     * @param boolean $keys
     * @return array
     */
    public static function getWalletsByCode(string $code, bool $keys = true) : array
    {
		$wallets = Settings::get($code . 'Wallets') ?? [];

        if (!$wallets) {
            return [];
        }

        $wallets = array_filter($wallets, function($val) {
            return boolval($val);
        });

        return $keys ? array_keys($wallets) : $wallets;
    }

    public static function getNetworkCodes() : array
    {
        $networks = Hook::callFilter('networks', []);
        if (Settings::get('evmBasedActivePassive')) {
            $networks['evmBased'] = 'evmBased';
        }

        $networksKeys = array_keys($networks);
        $networkSorting = Settings::get('networkSorting');
        $networkSorting = $networkSorting ? array_keys($networkSorting) : [];
        $networkSorting = array_unique(array_merge($networkSorting, $networksKeys));
        return array_filter($networkSorting, function($val) use ($networksKeys) {
            return in_array($val, $networksKeys);
        });
    }

    /**
     * @param array $mainnetCurrencies
     * @param array $testnetCurrencies
     * @return array
     */
    public static function prepareCurrencies(array $mainnetCurrencies, array $testnetCurrencies = []) : array 
    {
        $currencies = [];

        if (Settings::get('testnet')) {
            $currencies = array_merge($currencies, $testnetCurrencies);
        } else {
            foreach ($mainnetCurrencies as $currency) {
                if (isset($currency['active']) && $currency['active'] == '1') {
                    unset($currency['active']);
                    $currency['address'] = trim($currency['address']);
                    $currency['symbol'] = trim(strtoupper($currency['symbol']));
                    $currency['image'] = sanitize_text_field($currency['image']);
                    $currencies[] = $currency;
                }
            }
        }	

        return $currencies;
    }

    /**
     * @param string $code
     * @return string|null
     */
    public static function getWalletAddress(string $code) : ?string
    {
        return Settings::get($code . 'WalletAddress') ?? null;
    }

    /**
     * @param string $code
     * @return string|null
     */
    public static function getCustomWsAddress(string $code) : ?string
    {
        return Settings::get($code . 'CustomWsAddress') ?? null;
    }

    /**
     * @param string $code
     * @return string|null
     */
    public static function getCustomRpcAddress(string $code) : ?string
    {
        return Settings::get($code . 'CustomRpcAddress') ?? null;
    }

    /**
     * @param string $code
     * @return integer
     */
    public static function getBlockConfirmationCount(string $code) : int
    {
        $count = Settings::get($code . 'BlockConfirmationCount');
        return $count ? $count : 0;
    }

    /**
     * @param string $code
     * @return int
     */
    public static function getQrCodeWaitingTime(string $code) : int
    {
        $count = Settings::get($code . 'QrCodeWaitingTime');
        return $count ? $count : 30;
    }

    /**
     * @param string $code
     * @return string
     */    
    public static function getProviderByCode(string $code) : string
    {
        $providers = Hook::callFilter('php_providers', [
            'evmBased' => Provider::class
        ]);

        if (isset($providers[$code])) {
            return $providers[$code];
        } else {
            throw new \Exception('Provider not found!');
        }
    }

    /**
     * @param string $addon
     * @return object|null
     */    
    public static function getModelByAddon(string $addon) : ?object
    {
        $models = Hook::callFilter('models', [
            'woocommerce' => new Models\OrderTransaction()
        ]);

        return isset($models[$addon]) ? $models[$addon] : null;
    }

    /**
     * @param object $transaction
     * @return object
     */
    public static function getProviderByTx(object $transaction) : object
    {
        $provider = self::getProviderByCode($transaction->code);
        if (class_exists($provider)) {
            return new $provider([
                'testnet' => boolval($transaction->testnet),
                'network' => json_decode($transaction->network),
                'customRpc' => self::getCustomRpcAddress($transaction->code)
            ]);
        } else {
            throw new \Exception('Provider not found!');
        }
    }

    /**
     * @param string $orderCurrency
     * @param object $cryptoCurrency
     * @param float $amount
     * @param object $network
     * @return float|null
     */
    public static function calculatePaymentAmont(
        string $orderCurrency, object $paymentCurrency, float $amount, object $network
    ) : ?float
    {
        //Discount process

        $converter = new CurrencyConverter('CryptoCompare');
        if (
            $converter->isStableCoin($orderCurrency, $paymentCurrency->symbol) || 
            $converter->isSameCurrency($orderCurrency, $paymentCurrency->symbol)
        ) {
            return floatval($amount);
        }

        $customPrices = Settings::getCustomPrices();
        if (isset($customPrices[$paymentCurrency->symbol])) {
            $customPrices = $customPrices[$paymentCurrency->symbol];
            if (isset($customPrices[$orderCurrency])) {
                return ($amount / $customPrices[$orderCurrency]);
            }
        } elseif (isset($customPrices[$orderCurrency])) {
            $customPrices = $customPrices[$orderCurrency];
            if (isset($customPrices[$orderCurrency])) {
                return ($amount / $customPrices[$orderCurrency]);
            }
        } 

        $paymentAmount = Hook::callFilter(
            "currency_converter", 
            null, 
            $orderCurrency,
            $paymentCurrency,
            $amount,
            $network
        );
        
        if (is_null($paymentAmount)) {
            try {
                $paymentAmount = $converter->convert($orderCurrency, $paymentCurrency->symbol, $amount);
            } catch (\Exception $e) {
                $paymentAmount = null;
            }
        }

        return Plugin::$instance->toFixed($paymentAmount, 6);
    }

    /**
     * @param string $amount
     * @param integer $decimals
     * @return string
     */
    public static function toString(string $amount, int $decimals) : string
    {
        $pos1 = stripos((string) $amount, 'E-');
        $pos2 = stripos((string) $amount, 'E+');
    
        if ($pos1 !== false) {
            $amount = number_format($amount, $decimals, '.', ',');
        }

        if ($pos2 !== false) {
            $amount = number_format($amount, $decimals, '.', '');
        }
    
        return $amount > 1 ? $amount : rtrim($amount, '0');
    }

    /**
     * @param string $networkName
     * @return void
     */
    public static function networkWillNotWorkMessage(string $networkName) : void 
    {
        Plugin::$instance->adminNotice(str_replace('{networkName}', $networkName, esc_html__('You did not specify a wallet address in the "CryptoPay {networkName} settings", {networkName} network will not work. Please specify a wallet address first.', 'cryptopay')), 'error');
    }

    /**
     * @return array
     */
    public static function getCountryCurrencies() : array
    {
        return [
            'USD' => 'United States Dollar',
            'EUR' => 'Euro Member Countries',
            'GBP' => 'United Kingdom Pound',
            'ALL' => 'Albania Lek',
            'AFN' => 'Afghanistan Afghani',
            'ARS' => 'Argentina Peso',
            'AWG' => 'Aruba Guilder',
            'AUD' => 'Australia Dollar',
            'AZN' => 'Azerbaijan New Manat',
            'BSD' => 'Bahamas Dollar',
            'BBD' => 'Barbados Dollar',
            'BDT' => 'Bangladeshi taka',
            'BYR' => 'Belarus Ruble',
            'BZD' => 'Belize Dollar',
            'BMD' => 'Bermuda Dollar',
            'BOB' => 'Bolivia Boliviano',
            'BAM' => 'Bosnia and Herzegovina Convertible Marka',
            'BWP' => 'Botswana Pula',
            'BGN' => 'Bulgaria Lev',
            'BRL' => 'Brazil Real',
            'BND' => 'Brunei Darussalam Dollar',
            'KHR' => 'Cambodia Riel',
            'CAD' => 'Canada Dollar',
            'KYD' => 'Cayman Islands Dollar',
            'CLP' => 'Chile Peso',
            'CNY' => 'China Yuan Renminbi',
            'COP' => 'Colombia Peso',
            'CRC' => 'Costa Rica Colon',
            'HRK' => 'Croatia Kuna',
            'CUP' => 'Cuba Peso',
            'CZK' => 'Czech Republic Koruna',
            'DKK' => 'Denmark Krone',
            'DOP' => 'Dominican Republic Peso',
            'XCD' => 'East Caribbean Dollar',
            'EGP' => 'Egypt Pound',
            'SVC' => 'El Salvador Colon',
            'EEK' => 'Estonia Kroon',
            'FKP' => 'Falkland Islands (Malvinas) Pound',
            'FJD' => 'Fiji Dollar',
            'GHC' => 'Ghana Cedis',
            'GIP' => 'Gibraltar Pound',
            'GTQ' => 'Guatemala Quetzal',
            'GGP' => 'Guernsey Pound',
            'GYD' => 'Guyana Dollar',
            'HNL' => 'Honduras Lempira',
            'HKD' => 'Hong Kong Dollar',
            'HUF' => 'Hungary Forint',
            'ISK' => 'Iceland Krona',
            'INR' => 'India Rupee',
            'IDR' => 'Indonesia Rupiah',
            'IRR' => 'Iran Rial',
            'IMP' => 'Isle of Man Pound',
            'ILS' => 'Israel Shekel',
            'JMD' => 'Jamaica Dollar',
            'JPY' => 'Japan Yen',
            'JEP' => 'Jersey Pound',
            'KZT' => 'Kazakhstan Tenge',
            'KPW' => 'Korea (North) Won',
            'KRW' => 'Korea (South) Won',
            'KGS' => 'Kyrgyzstan Som',
            'LAK' => 'Laos Kip',
            'LVL' => 'Latvia Lat',
            'LBP' => 'Lebanon Pound',
            'LRD' => 'Liberia Dollar',
            'LTL' => 'Lithuania Litas',
            'MKD' => 'Macedonia Denar',
            'MYR' => 'Malaysia Ringgit',
            'MUR' => 'Mauritius Rupee',
            'MXN' => 'Mexico Peso',
            'MNT' => 'Mongolia Tughrik',
            'MZN' => 'Mozambique Metical',
            'NAD' => 'Namibia Dollar',
            'NPR' => 'Nepal Rupee',
            'ANG' => 'Netherlands Antilles Guilder',
            'NZD' => 'New Zealand Dollar',
            'NIO' => 'Nicaragua Cordoba',
            'NGN' => 'Nigeria Naira',
            'NOK' => 'Norway Krone',
            'OMR' => 'Oman Rial',
            'PKR' => 'Pakistan Rupee',
            'PAB' => 'Panama Balboa',
            'PYG' => 'Paraguay Guarani',
            'PEN' => 'Peru Nuevo Sol',
            'PHP' => 'Philippines Peso',
            'PLN' => 'Poland Zloty',
            'QAR' => 'Qatar Riyal',
            'RON' => 'Romania New Leu',
            'RUB' => 'Russia Ruble',
            'SHP' => 'Saint Helena Pound',
            'SAR' => 'Saudi Arabia Riyal',
            'RSD' => 'Serbia Dinar',
            'SCR' => 'Seychelles Rupee',
            'SGD' => 'Singapore Dollar',
            'SBD' => 'Solomon Islands Dollar',
            'SOS' => 'Somalia Shilling',
            'ZAR' => 'South Africa Rand',
            'LKR' => 'Sri Lanka Rupee',
            'SEK' => 'Sweden Krona',
            'CHF' => 'Switzerland Franc',
            'SRD' => 'Suriname Dollar',
            'SYP' => 'Syria Pound',
            'TWD' => 'Taiwan New Dollar',
            'THB' => 'Thailand Baht',
            'TTD' => 'Trinidad and Tobago Dollar',
            'TRY' => 'Turkey Lira',
            'TRL' => 'Turkey Lira',
            'TVD' => 'Tuvalu Dollar',
            'UAH' => 'Ukraine Hryvna',
            'UYU' => 'Uruguay Peso',
            'UZS' => 'Uzbekistan Som',
            'VEF' => 'Venezuela Bolivar',
            'VND' => 'Viet Nam Dong',
            'YER' => 'Yemen Rial',
            'ZWD' => 'Zimbabwe Dollar'
        ];
    }
}