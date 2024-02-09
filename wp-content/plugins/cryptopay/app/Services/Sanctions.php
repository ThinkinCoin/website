<?php

declare(strict_types=1);

namespace BeycanPress\CryptoPay\Services;

// Classes
use BeycanPress\CryptoPay\Helpers;
use BeycanPress\CryptoPay\PluginHero\Hook;
use BeycanPress\CryptoPay\PluginHero\Http\Client;
// Types
use BeycanPress\CryptoPay\Types\Data\PaymentDataType;
use BeycanPress\CryptoPay\Types\Enums\PaymentDataProcess as Process;

class Sanctions
{
    /**
     * @var Client
     */
    private static Client $client;

    /**
     * @var string
     */
    private static string $coinfirm = 'https://api.coinfirm.com/v3/blacklist/addresses/ETH/{address}';

    /**
     * @return void
     */
    public function __construct()
    {
        self::$client = new Client();
        Hook::addFilter('js_variables', [$this, 'jsVariables'], 10);
        Hook::addFilter('edit_payment_data', [$this, 'editPaymentData'], 10);
    }

    /**
     * @param array<string,mixed> $vars
     * @return array<string,mixed>
     */
    public function jsVariables(array $vars): array
    {
        return array_merge($vars, [
            'sanctions' => Sanctions::getActiveSactionsApi($vars['addon'])
        ]);
    }

    /**
     * @param PaymentDataType $data
     * @return PaymentDataType
     */
    public function editPaymentData(PaymentDataType $data): PaymentDataType
    {
        if ($data->getProcess() == Process::PAYMENT_FINISHED) {
            $sanctions = self::getActiveSactionsApi($data->getAddon());
            if ($sanctions->status && $sanctions->mode == 'take-note') {
                if (in_array($data->getNetwork()->getCode(), $sanctions->supports)) {
                    $tx = $data->getModel()->getTransactionByHash($data->getHash());
                    $tx = Helpers::getProvider($tx)->Transaction($data->getHash());
                    if (($result = $this->check($tx->getFrom()))->status) {
                        $data->getParams()->set('sanction', $result);
                    }
                }
            }
        }

        return $data;
    }

    /**
     * @param string|null $api
     * @return array<array<string>>
     */
    private static function getNetworkSupports(?string $api = null): array
    {
        $apis = [
            'coinfirm' => ['evmchains'],
        ];

        return $apis[$api] ?? [];
    }

    /**
     * @param string $addon
     * @return object
     */
    public static function getActiveSactionsApi(string $addon): object
    {
        $api = Helpers::getSetting('sanctionsApi');
        $mode = Helpers::getSetting('sanctionsMode');
        $supports = self::getNetworkSupports($api);
        $status = $api ? boolval(Helpers::getSetting('sanctions')) : false;
        $status = Hook::callFilter('sanctions_' . $addon, $status, $api, $mode, $supports);
        return (object) compact('api', 'mode', 'supports', 'status');
    }

    /**
     * @param string $address
     * @return object
     */
    public static function check(string $address): object
    {
        $api = Helpers::getSetting('sanctionsApi');
        return call_user_func_array([self::class, $api], [$address]);
    }

    /**
     * @param string $address
     * @return object
     */
    private static function coinfirm(string $address): object
    {
        $apiKey = Helpers::getSetting('sanctionsApiKey');
        $url = str_replace('{address}', $address, self::$coinfirm);

        $res = self::$client->addHeader('Authorization', 'Bearer ' . $apiKey)->get($url);

        return (object) [
            'api' => 'Coinfirm',
            'source' => $res->source ?? null,
            'status' => $res->blacklisted ?? false,
        ];
    }
}
