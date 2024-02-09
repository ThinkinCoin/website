<?php

declare(strict_types=1);

namespace BeycanPress\CryptoPay;

// @phpcs:disable PSR1.Files.SideEffects
// @phpcs:disable PSR12.Files.FileHeader
// @phpcs:disable Generic.Files.LineLength

/**
 * Plugin Name: CryptoPay CoinGecko Converter API
 * Version:     1.2.0
 * Plugin URI:  https://beycanpress.com/cryptopay/
 * Update URI:  https://beycanpress.com/cryptopay/
 * Description: Extra currency converter API for CryptoPay
 * Author:      BeycanPress LLC
 * Author URI:  https://beycanpress.com
 * License:     GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: cryptopay
 * Tags:        Cryptopay, Cryptocurrency, WooCommerce, WordPress, MetaMask, Trust, Binance, Wallet, Ethereum, Bitcoin, Binance smart chain, Payment, Plugin, Gateway, Moralis, Converter, API, coin market cap
 * Requires at least: 5.0
 * Tested up to: 6.4.2
 * Requires PHP: 8.1
*/

use BeycanPress\Http\Client;
use BeycanPress\CryptoPay\PluginHero\Hook;
use BeycanPress\CryptoPay\Types\Data\PaymentDataType;

add_action('plugins_loaded', function (): void {

    if (class_exists(Loader::class)) {

        class CoinGecko extends PluginHero\Plugin
        {
            private Client $client;

            private string $key = 'CoinGecko';

            /**
             * @return void
             */
            public function __construct()
            {
                $this->client = new Client();
                Helpers::registerAddon('coingecko', __FILE__);

                $pluginData = Helpers::getAddon('coingecko')->getData();

                new PluginHero\Updater([
                    'plugin_file' => $pluginData->Slug,
                    'requires' => $pluginData->RequiresWP,
                    'requires_php' => $pluginData->RequiresPHP,
                    'plugin_version' => $pluginData->Version,
                    'icons' => [
                        '2x' => Helpers::getAddon('coingecko')->getImageUrl('icon-256x256.png'),
                        '1x' => Helpers::getAddon('coingecko')->getImageUrl('icon-128x128.png'),
                    ]
                ]);

                Hook::addFilter("converters", function ($converters) {
                    $converters[$this->key] = $this->key;
                    return $converters;
                });

                Hook::addFilter(
                    "currency_converter_" . $this->key,
                    function (?float $paymentPrice, PaymentDataType $data): ?float {
                        $order = $data->getOrder();
                        $amount = $order->getAmount();
                        $orderCurrency = $order->getCurrency();
                        $paymentCurrency = $order->getPaymentCurrency();

                        $from = $orderCurrency;
                        $to = $paymentCurrency->getSymbol();

                        $tokenListFile = __DIR__ . '/cache/token-list.json';

                        try {
                            $tokenList = json_decode($this->cgCache(function () {
                                $tokenList = $this->client->get('https://api.coingecko.com/api/v3/coins/list');

                                if (isset($tokenList?->status?->error_code)) {
                                    $tokenList = [];
                                }

                                $usdId = array_search('usd', array_column($tokenList, 'symbol'));
                                $usdId2 = array_search('usd+', array_column($tokenList, 'symbol'));

                                if (isset($tokenList[$usdId])) {
                                    unset($tokenList[$usdId]);
                                }

                                if (isset($tokenList[$usdId2])) {
                                    unset($tokenList[$usdId2]);
                                }

                                $tokenList[] = (object) [
                                    'id' => 'usd',
                                    'symbol' => 'usd',
                                    'name' => 'USD'
                                ];

                                return json_encode(array_values($tokenList));
                            }, $tokenListFile, (3600 * 24))->content);

                            $fromId = array_search(strtolower($from), array_column($tokenList, 'symbol'));
                            $toId = array_search(strtolower($to), array_column($tokenList, 'symbol'));

                            // if token not found
                            if (!$toId) {
                                $toId = array_search(strtolower("$" . $to), array_column($tokenList, 'symbol'));
                                if (!$toId) {
                                    return null;
                                }
                            }

                            if (!$fromId) {
                                $cgFrom = strtolower($from);
                            } else {
                                $cgFrom = $tokenList[$fromId]->id;
                            }

                            $cgTo = $tokenList[$toId]->id;
                            $key = $cgFrom . $cgTo;

                            $cgPriceFile = __DIR__ . '/cache/cg-price.json';
                            if (file_exists($cgPriceFile) && time() - 30 < filemtime($cgPriceFile)) {
                                $cgPrice = json_decode(file_get_contents($cgPriceFile));
                            } else {
                                $cgPrice = (object) [];
                            }

                            if (!isset($cgPrice->$key)) {
                                $parameters = [
                                    'ids' => urlencode(implode(',', [$cgTo])),
                                    'vs_currencies' => urlencode(implode(',', [$cgFrom]))
                                ];

                                $headers = [
                                    'Content-Type: application/json'
                                ];

                                $qs = http_build_query($parameters);
                                $request = "https://api.coingecko.com/api/v3/simple/price?{$qs}";

                                $curl = curl_init($request);

                                curl_setopt_array($curl, [
                                    CURLOPT_CUSTOMREQUEST => 'GET',
                                    CURLOPT_HTTPHEADER => $headers,
                                    CURLOPT_RETURNTRANSFER => 1
                                ]);

                                $response = json_decode(curl_exec($curl));

                                if (isset($response->{$cgTo})) {
                                    if (isset($response->{$cgTo}->{$cgFrom})) {
                                        $result = $response->{$cgTo}->{$cgFrom};
                                    } else {
                                        $result = null;
                                    }
                                } else {
                                    $result = null;
                                }

                                curl_close($curl);

                                $cgPrice->$key = $result;

                                file_put_contents($cgPriceFile, json_encode($cgPrice));
                            }

                            if (is_null($cgPrice->$key)) {
                                return null;
                            }

                            return ($amount / $cgPrice->$key);
                        } catch (\Exception $e) {
                            Helpers::debug($e->getMessage(), 'ERROR', $e);
                            return $paymentPrice;
                        }
                    },
                    10,
                    4
                );
            }

            /**
             * @param \Closure $function
             * @param string $file
             * @param integer $time
             * @return object
             */
            public function cgCache(\Closure $function, string $file, int $time = 600): object
            {
                if (!file_exists(__DIR__ . '/cache')) {
                    mkdir(__DIR__ . '/cache');
                }

                if (file_exists($file) && time() - $time < filemtime($file)) {
                    $content = file_get_contents($file);
                } else {
                    if (file_exists($file)) {
                        unlink($file);
                    }

                    $content = $function();

                    $fp = fopen($file, 'w+');
                    fwrite($fp, $content);
                    fclose($fp);
                }

                return (object) compact('file', 'content');
            }
        }

        new CoinGecko();
    }
});
