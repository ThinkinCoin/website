<?php

declare(strict_types=1);

namespace BeycanPress\CryptoPay;

// Classes
use BeycanPress\CryptoPay\PluginHero\Hook;
use BeycanPress\CryptoPay\Services\Converter;
// Types
use BeycanPress\CryptoPay\Types\InitType;
use BeycanPress\CryptoPay\Types\Order\OrderType;
use BeycanPress\CryptoPay\Types\Data\ConfigDataType;
use BeycanPress\CryptoPay\Types\Data\PaymentDataType;
use BeycanPress\CryptoPay\Types\Network\NetworkType;
use BeycanPress\CryptoPay\Types\Network\NetworksType;
use BeycanPress\CryptoPay\Types\Transaction\ParamsType;
// Exceptions
use BeycanPress\CryptoPay\Exceptions\InitializeException;
use BeycanPress\CryptoPay\Exceptions\NoActiveNetworkException;
use BeycanPress\CryptoPay\Exceptions\NoActiveCurrencyException;

class Payment
{
    /**
     * @var string
     */
    private string $addon;

    /**
     * @var string
     */
    private bool $autoStart = true;

    /**
     * @var ConfigDataType
     */
    private ConfigDataType $config;

    /**
     * @var PaymentDataType
     */
    private PaymentDataType $data;

    /**
     * @param string $addon
     */
    public function __construct(string $addon)
    {
        $this->addon = $addon;
        $this->config = new ConfigDataType($addon);
        $this->data = new PaymentDataType($this->addon);
        $this->data->setUserId(Helpers::getCurrentUserId());

        // set default data for handle errors
        $this->data->setOrder(new OrderType());
        $this->data->setParams(new ParamsType());
        $this->config->setConfirmation(true);
    }

    /**
     * @param bool $autoStart
     * @return self
     */
    public function setAutoStart(bool $autoStart): self
    {
        $this->autoStart = $autoStart;
        return $this;
    }

    /**
     * @param OrderType $order
     * @return self
     */
    public function setOrder(OrderType $order): self
    {
        $this->data->setOrder($order);
        return $this;
    }

    /**
     * @param ParamsType $params
     * @return self
     */
    public function setParams(ParamsType $params): self
    {
        $this->data->setParams($params);
        return $this;
    }

    /**
     * @param boolean $confirmation
     * @return self
     */
    public function setConfirmation(bool $confirmation): self
    {
        $this->config->setConfirmation($confirmation);
        return $this;
    }

    /**
     * @param array<string> $deps
     * @return string
     */
    public function modal(array $deps = []): string
    {
        return Helpers::view('modal', [
            'cryptopay' => $this->html($deps)
        ]);
    }

    /**
     * @param array<string> $deps
     * @param bool $loading
     * @return string
     */
    public function html(array $deps = [], bool $loading = false): string
    {
        try {
            $networks = Hook::callFilter('edit_networks', Helpers::getNetworks());
            $networks = Hook::callFilter('edit_networks_' . $this->addon, $networks);

            // if no have network more than one, throw exception
            if (is_null($network = $networks->first())) {
                throw new NoActiveNetworkException(
                    esc_html__(
                        'No network is active, please activate at least one network!',
                        'cryptopay'
                    )
                );
            }

            // get js providers
            $jsProviders = $this->getJsProviders($networks);

            $this->config->setNetworks($networks);
            $this->config->setProviders($jsProviders->names);

            // if auto init
            if ($this->checkAutoInit($networks)) {
                try {
                    $this->config->setInit($this->init($network));
                } catch (InitializeException $e) {
                    throw $e;
                }
            }

            $appKey = Helpers::addScript('app.min.js');

            // add dependencies for main js
            $deps = array_merge(
                $deps,
                $jsProviders->keys,
                ['jquery', $appKey],
            );

            Helpers::setProp('mainJsKey', $mainJsKey = Helpers::addScript('main.min.js', $deps));

            // config for cryptopay js app
            $this->config = Hook::callFilter('edit_config_data', $this->config);
            $this->config = Hook::callFilter('edit_config_data_' . $this->addon, $this->config);

            // vars for the here js files
            $vars = Hook::callFilter('js_variables', [
                'addon' => $this->addon,
                'autoStart' => $this->autoStart,
                'apiUrl' => Constants::getApiUrl()
            ]);

            // if order exists, add order to vars
            if ($this->data->getOrder()->exists()) {
                $vars['order'] = $this->data->getOrder()->prepareForJsSide();
            }

            // if params exists, add params to vars
            if ($params = $this->data->getParams()->toArray()) {
                $vars['params'] = $params;
            }

            // JS Variables
            $config = $this->config->prepareForJsSide();
            wp_localize_script($mainJsKey, 'CryptoPayVars', $vars);
            wp_localize_script($mainJsKey, 'CryptoPayConfig', $config);

            $html = Hook::callFilter('before_html', '', $this->config);

            $html .= Helpers::view('cryptopay', ['loading' => $loading]);

            $html = Hook::callFilter('after_html', $html, $this->config);

            return $html;
        } catch (\Exception $e) {
            Helpers::debug($e->getMessage(), 'ERROR', $e);
            return $e->getMessage();
        }
    }

    /**
     * @param NetworksType|null $filterByNetworks
     * @return object
     */
    private function getJsProviders(?NetworksType $filterByNetworks = null): object
    {
        $providers = Hook::callFilter('js_providers', [
            'EvmChains' => Helpers::addScript('evm-chains-provider.js'),
        ]);

        if ($filterByNetworks) {
            $networkCodes = array_unique($filterByNetworks->column('code'));
            $providers = array_filter($providers, function ($provider) use ($providers, $networkCodes) {
                $scKey = $providers[$provider];

                if (!$res = in_array(strtolower($provider), $networkCodes)) {
                    wp_dequeue_script($scKey);
                }

                return $res;
            }, ARRAY_FILTER_USE_KEY);
        }

        return (object) [
            'names' => array_keys($providers),
            'keys' => array_values($providers)
        ];
    }

    /**
     * @param NetworksType $networks
     * @return bool
     */
    private function checkAutoInit(NetworksType $networks): bool
    {
        // if have more than one network
        if ($networks->count() > 1) {
            return false;
        }

        // if order not set
        if (!$this->data->getOrder()->exists()) {
            return true;
        }

        // if mode is currency and have more than one currency
        $firstNetwork = $networks->first();
        $currenciesCount = $firstNetwork->getCurrencies()->count();
        if (Helpers::getMode($this->addon) == 'currency' && $currenciesCount > 1) {
            return false;
        }

        return true;
    }

    /**
     * @param NetworkType $network
     * @return InitType
     */
    public function init(NetworkType $network): InitType
    {
        try {
            Helpers::debug('Init', 'INFO', $network->forDebug());

            // set network
            $this->data->setNetwork($network);

            Helpers::debug('Payment filters before', 'INFO', $this->data->forDebug());

            // data customizer
            $this->data = Hook::callFilter('edit_payment_data', $this->data);
            $this->data = Hook::callFilter('init_' . $this->addon, $this->data);

            Helpers::debug('Payment filters after', 'INFO', $this->data->forDebug());

            // get payment currency from order
            // because in api payment currency setting,f
            // that's why we need to get payment currency from order
            // but if payment currency not set, get first currency from network
            if (!$paymentCurrency = $this->data->getOrder()->getPaymentCurrency()) {
                Helpers::debug('Get first currency from network', 'INFO');
                $paymentCurrency = $network->getCurrencies()->first();
            }

            // if payment currency not set, throw exception
            if (is_null($paymentCurrency)) {
                throw new NoActiveCurrencyException(
                    esc_html__(
                        'No active currencies were found on this network. Please report this to the administrator.',
                        'cryptopay'
                    )
                );
            } else {
                $this->data->getOrder()->setPaymentCurrency($paymentCurrency);
            }

            // if payment amount not set, convert amount and set
            if (!$this->data->getOrder()->getPaymentAmount()) {
                Helpers::debug('Calculate payment amount', 'INFO');
                $this->data->getOrder()->setPaymentAmount(Converter::convert($this->data));
            }

            // init data
            $receiver = Helpers::getReceiver($this->data);
            $qrCodeWaitingTime = Helpers::getQrCodeWaitingTime($network->getCode());
            $blockConfirmationCount = Helpers::getBlockConfirmationCount($network->getCode());
            $providerConfig = (object) Hook::callFilter('provider_config_' . $network->getCode(), []);

            // just for pretty
            $order = $this->data->getOrder();

            return new InitType(
                $order,
                $receiver,
                $providerConfig,
                $qrCodeWaitingTime,
                $blockConfirmationCount
            );
        } catch (\Exception $e) {
            Helpers::debug($e->getMessage(), 'ERROR', $e);
            throw new InitializeException($e->getMessage(), $e->getCode());
        }
    }
}
