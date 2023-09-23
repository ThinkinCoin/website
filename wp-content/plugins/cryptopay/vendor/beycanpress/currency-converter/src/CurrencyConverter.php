<?php

namespace BeycanPress;

final class CurrencyConverter
{
    /**
     * @var string
     */
    private $api;

    /**
     * @var string
     */
    private $apiUrl;

    /**
     * @var string|null
     */
    private $apiKey = null;

    /**
     * @var array
     */
    private $needsApiKey = [
        'CoinMarketCap'
    ];

    /**
     * @var array
     */
    private $apis = [
        'CryptoCompare' => 'https://min-api.cryptocompare.com/data/price',
        'CoinMarketCap' => 'https://pro-api.coinmarketcap.com/v1/tools/price-conversion',
        'CoinGecko' => 'https://api.coingecko.com/api/v3/simple/price'
    ];

    /**
     * @var array
     */
    private $stableCoins = [
        'USDT',
        'USDC',
        'DAI',
        'BUSD',
        'UST',
        'TUSD'
    ];

    /**
     * @param string $api
     * @param string|null $apiKey
     * @throws Exception
     */
    public function __construct(string $api, ?string $apiKey = null)
    {
        if (!isset($this->apis[$api])) {
            throw new \Exception('Unsupported api!');
        }

        $this->api = $api;
        $this->apiKey = $apiKey;
        $this->apiUrl = $this->apis[$api];
    }

    /**
     * @param string $from
     * @param string $to
     * @param float $amount
     * @return float|null
     * @throws Exception
     */
    public function convert(string $from, string $to, float $amount) : ?float
    {
        if (in_array($this->api, $this->needsApiKey) && $this->apiKey == null) {
            throw new \Exception("The key of the api selected to be used has not been entered.");
        }

        if ($this->isStableCoin($from, $to)) {
            return floatval($amount);
        }

        if ($this->isSameCurrency($from, $to)) {
            return floatval($amount);
        }

        return call_user_func_array([$this, 'convertWith' . $this->api], [$from, $to, $amount]);
    }

    /**
     * @param string $from
     * @param string $to
     * @param float $amount
     * @return float|null
     * @throws Exception
     */
    private function convertWithCoinGecko(string $from, string $to, float $amount) : ?float
    {   
        $tokenList = json_decode($this->cache(function() {
            $tokenList = json_decode(file_get_contents('https://api.coingecko.com/api/v3/coins/list'));
            
            $usdId = array_search('usd', array_column($tokenList, 'symbol'));
            $usdId2 = array_search('usd+', array_column($tokenList, 'symbol'));
            if (isset($tokenList[$usdId])) unset($tokenList[$usdId]);
            if (isset($tokenList[$usdId2])) unset($tokenList[$usdId2]);

            $tokenList[] = (object) [
                'id' => 'usd',
                'symbol' => 'usd',
                'name' => 'USD' 
            ];

            return json_encode(array_values($tokenList));
        }, 'token-list', (3600*24))->content);

        $fromId = array_search(strtolower($from), array_column($tokenList, 'symbol'));
        $toId = array_search(strtolower($to), array_column($tokenList, 'symbol'));
        $cgFrom = $tokenList[$fromId]->id;
        $cgTo = $tokenList[$toId]->id;

        $result = json_decode($this->cache(function() use ($amount, $cgFrom, $cgTo) {

            $parameters = [
                'ids' => urlencode(implode(',', [$cgTo])),
                'vs_currencies' => urlencode(implode(',', [$cgFrom]))
            ];
    
            $headers = [
                'Content-Type: application/json'
            ];

            $qs = http_build_query($parameters); 
            $request = "{$this->apiUrl}?{$qs}";

            $curl = curl_init($request);

            curl_setopt_array($curl, [
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_RETURNTRANSFER => 1 
            ]);

            $response = json_decode(curl_exec($curl));

            if (isset($response->{$cgTo})) {
                if (isset($response->{$cgTo}->{$cgFrom})) {
                    $result = ($amount / $response->{$cgTo}->{$cgFrom});
                } else {
                    $result = null;
                }
            } else {
                $result = null;
            }

            curl_close($curl); 

            return json_decode($result);
        }, 'cg-price', 30)->content);

        return $result;
    }

    /**
     * @param string $from
     * @param string $to
     * @param float $amount
     * @return float|null
     * @throws Exception
     */
    private function convertWithCoinMarketCap(string $from, string $to, float $amount) : ?float
    {
        $parameters = [
            'amount' => $amount,
            'symbol' => $from,
            'convert' => $to
        ];

        $headers = [
            'Accepts: application/json',
            'X-CMC_PRO_API_KEY: ' . $this->apiKey
        ];

        $qs = http_build_query($parameters); 
        $request = "{$this->apiUrl}?{$qs}";


        $curl = curl_init($request);

        curl_setopt_array($curl, [
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_RETURNTRANSFER => 1 
        ]);

        $response = json_decode(curl_exec($curl));

        if (isset($response->data)) {
            $result = $response->data->quote->{strtoupper($to)}->price;
        } else {
            $result = null;
        }

        curl_close($curl); 

        return $result;
    }

    /**
     * @param string $from
     * @param string $to
     * @param float $amount
     * @return float|null
     * @throws Exception
     */
    private function convertWithCryptoCompare(string $from, string $to, float $amount) : ?float
    {
        $apiUrl =  $this->apiUrl . '?fsym=' . $from . '&tsyms=' . $to;
        $convertData = json_decode(file_get_contents($apiUrl));
        if (isset($convertData->$to)) {
            return ($amount * $convertData->$to);
        } else {
            return null;
        }
    }

    /**
     * @param float $number
     * @param int $decimals
     * @return float
     */
    public function toFixed(float $number, int $decimals = 6) : float
    {
        return floatval(number_format($number, $decimals, '.', ""));
    }

    /**
     * @param $exp
     * @return void
     */
    public function expToStr($exp) : string
    {
        $parsedNumber = explode("e", strtolower($exp));

        if (count($parsedNumber) == 1) {
            return $exp;
        }

        list($mantissa, $exponent) = $parsedNumber;
        list($int, $dec) = explode(".", $mantissa);

        bcscale(abs($exponent-strlen($dec)));
        $result = bcmul($mantissa, bcpow("10", $exponent));

        if ($result > 1) {
            $result = rtrim($result, '.0');
        }

        return $result;
    }

    /**
     * @param string $from
     * @param string $to
     * @return boolean
     */
    public function isStableCoin(string $from, string $to) : bool
    {
        if (strtoupper($from) == 'USD' || strtoupper($to) == 'USD') {
            if (in_array(strtoupper($from), $this->stableCoins) || in_array(strtoupper($to), $this->stableCoins)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $from
     * @param string $to
     * @return boolean
     */
    public function isSameCurrency(string $from, string $to) : bool
    {
        return strtoupper($from) == strtoupper($to);
    }

    /**
     * @param array $symbols
     * @return void
     */
    public function addStableCoins(array $symbols) : void
    {
        $this->stableCoins = array_merge($this->stableCoins, $symbols);
    }

    /**
     * @param callable $function
     * @param string $name
     * @param int $time seconds
     * @return object
     */
    public function cache(callable $function, string $name, int $time = 600) : object
    {
        $path = dirname(__DIR__) . '/cache/';

        if (!file_exists($path)) {
            mkdir($path);       
        } 

        $file = $path . $name . '.json';

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
