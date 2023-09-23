<?php

namespace BeycanPress\CryptoPay;

use \MultipleChain\EvmBasedChains;
use \BeycanPress\CryptoPay\PluginHero\Plugin;

class EvmBased
{
    /**
     * @var array
     */
    private static $networks = [];

    public static array $testnets = [
        "ethereum" => [
            "id" => 5,
            "mainnetId" => 1,
            "name" => "Ethereum Goerli Testnet (QR)",
            "rpcUrl" => "https://goerli.infura.io/v3/9aa3d95b3bc440fa88ea12eaa4456161",
            "wsUrl" => "wss://goerli.infura.io/ws/v3/9aa3d95b3bc440fa88ea12eaa4456161",
            "explorerUrl" => "https://goerli.etherscan.io/",
            "nativeCurrency" => [
                "symbol" => "ETH",
                "decimals" => 18
            ]
        ],
        'arbitrum' => [
            "id" => 421613,
            "mainnetId" => 42161,
            "name" => "Arbitrum Goerli Testnet",
            "rpcUrl" => "https://goerli-rollup.arbitrum.io/rpc",
            "explorerUrl" => "https://goerli.arbiscan.io/",
            "image" => "https://docs.arbitrum.io/img/logo.svg",
            "nativeCurrency" => [
                "symbol" => "ETH",
                "decimals" => 18
            ],
        ],
        'optimism' => [
            "id" => 420,
            "mainnetId" => 10,
            "name" => "Optimism Goerli Testnet",
            "rpcUrl" => "https://goerli.optimism.io",
            "explorerUrl" => "https://goerli-optimism.etherscan.io/",
            "image" => "https://cryptologos.cc/logos/optimism-ethereum-op-logo.svg",
            "nativeCurrency" => [
                "symbol" => "ETH",
                "decimals" => 18
            ],
        ],
        "bsc" => [
            "id" => 97,
            "mainnetId" => 56,
            "name" => "BNB Smart Chain Testnet",
            "rpcUrl" => "https://bsc-testnet.publicnode.com",
            "explorerUrl" => "https://testnet.bscscan.com/",
            "nativeCurrency" => [
                "symbol" => "BNB",
                "decimals" => 18
            ]
        ],
        "opbnb" => [
            "id" => 5611,
            "mainnetId" => 204,
            "name" => "opBNB Smart Chain Testnet",
            "rpcUrl" => "https://opbnb-testnet-rpc.bnbchain.org",
            "explorerUrl" => "https://testnet.opbnbscan.com/",
            "nativeCurrency" => [
                "symbol" => "BNB",
                "decimals" => 18
            ]
        ],
        "avalanche" => [
            "id" => 43113,
            "mainnetId" => 43114,
            "name" => "Avalanche FUJI C-Chain Testnet",
            "rpcUrl" => "https://api.avax-test.network/ext/bc/C/rpc",
            "explorerUrl" => "https://cchain.explorer.avax-test.network",
            "nativeCurrency" => [
                "symbol" => "AVAX",
                "decimals" => 18
            ]
        ],
        "polygon" => [
            "id" => 80001,
            "mainnetId" => 137,
            "name" => "Polygon Mumbai Testnet",
            "rpcUrl" => "https://rpc-mumbai.maticvigil.com/",
            "explorerUrl" => "https://mumbai.polygonscan.com/",
            "nativeCurrency" => [
                "symbol" => "MATIC",
                "decimals" => 18
            ]
        ],
        "fantom" => [
            "id" => 4002,
            "mainnetId" => 250,
            "name" => "Fantom Testnet",
            "rpcUrl" => "https://rpc.testnet.fantom.network/",
            "explorerUrl" => "https://testnet.ftmscan.com/",
            "nativeCurrency" => [
                "symbol" => "FTM",
                "decimals" => 18
            ]
        ]
    ];

    // polygon is coming: 137, 80001
    // Phantom goerli: 5
    private static $filteredWallets = [
        'binancewallet' => [56, 97, 1],
        'phantom' => [1],
    ];

    /**
     * @return array
     */
    public static function getNetworks() : array 
    {
        $mainnets = self::getMainnetNetworks();
        if (
            Settings::get('evmBasedActivePassive') &&
            Settings::get('evmBasedWalletAddress')
        ) {
            if (Settings::get('testnet')) {
                $chainIds = array_column($mainnets, 'id');
                
                $testnets = array_filter(self::getTestnetNetworks(), function($network) use ($chainIds) {
                    return in_array($network['mainnetId'], $chainIds);
                });

                usort($testnets, function($a, $b) use ($mainnets) {
                    $ids = array_column($mainnets, 'id');
                    $idA = array_search($a['mainnetId'], $ids);
                    $idB = array_search($b['mainnetId'], $ids);
                    return $idA - $idB;
                });

                return $testnets;
            } else {
                return $mainnets;
            }
        }

        return [];
    }

    /**
     * @return array
     */
    private static function getMainnetNetworks() : array
    {
		$networks = Settings::get('evmBasedNetworks');

        if (!empty(self::$networks) || !$networks) {
            return self::$networks;
        }

        foreach ($networks as $network) {

            // Active/Passive control
            if (isset($network['active']) && $network['active'] != '1') continue;
            
            $id = intval($network['id']);
            $hexId = '0x' . dechex($id);

            $currencies = [];

            if (isset($network['nativeCurrency']['active']) && $network['nativeCurrency']['active'] == '1') {
                unset($network['nativeCurrency']['active']);
                $network['nativeCurrency']['symbol'] = trim(strtoupper($network['nativeCurrency']['symbol']));
                $currencies[] = $network['nativeCurrency'];
            }

            if (isset($network['currencies'])) {
                foreach ($network['currencies'] as $currency) {
                    if (isset($currency['active']) && $currency['active'] == '1') {
                        unset($currency['active']);
                        $currency['address'] = trim($currency['address']);
                        $currency['symbol'] = trim(strtoupper($currency['symbol']));
                        $currency['image'] = sanitize_text_field($currency['image']);
                        $currencies[] = $currency;
                    }
                }
            }

            if (count($currencies) > 0) {
                self::$networks[] = [
                    'id' => $id,
                    'hexId' => $hexId,
                    'name' => $network['name'],
                    'wsUrl' => $network['wsUrl'],
                    'image' => $network['image'] ?? null,
                    'rpcUrl' => $network['rpcUrl'],
                    'explorerUrl' => $network['explorerUrl'],
                    'nativeCurrency' => $network['nativeCurrency'],
                    'wallets' => self::filterSomeWallets($id),
                    'paymentType' => 'wallet',
                    'currencies' => $currencies,
                    'code' => 'evmBased',
                ];
            }
        }
        
        return self::$networks;
    }

    /**
     * @return array
     */
    private static function getTestnetNetworks() : array
    {

        return array_map(function($network) {
            $id = intval($network['id']);
            $hexId = '0x' . dechex($id);
            $network['hexId'] = $hexId;
            $network['code'] = 'evmBased';
            $network['paymentType'] = 'wallet';
            $network['mainnetId'] = $network['mainnetId'];
            $network['wallets'] = self::filterSomeWallets($id);
            $network['currencies'] = self::getTestnetsCurrencies($id);
            
            return $network;
        }, array_values(self::$testnets));
    }

    /**
     * @param int $networkId
     * @return array
     */
    private static function filterSomeWallets(int $networkId) : array
    {
        $wallets = Services::getWalletsByCode('evmBased');

        return array_values(array_filter($wallets, function($wallet) use ($networkId) {
            if (isset(self::$filteredWallets[$wallet])) {
                return in_array($networkId, self::$filteredWallets[$wallet]);
            }

            return true;
        }));
    }
    /**
     * @param string $code
     * @param integer|null $id
     * @return array
     */
    public static function getTestnetsCurrencies(int $id = null) : array 
    {
        if ($id == 5) {
            return [
                [
                    'symbol' => "ETH",
                ],
                [
                    'symbol' => "USDT",
                    'address' => "0x5ab6f31b29fc2021436b3be57de83ead3286fdc7"
                ],
                [
                    'symbol' => "USDC",
                    'address' => "0x466595626333c55fa7d7ad6265d46ba5fdbbdd99"
                ]
            ];
        } elseif ($id == 97) {
            return [
                [
                    'symbol' => "BNB",
                ],
                [
                    'symbol' => "BUSD",
                    'address' => "0xeD24FC36d5Ee211Ea25A80239Fb8C4Cfd80f12Ee"
                ],
                [
                    'symbol' => "USDT",
                    'address' => "0xba6670261a05b8504e8ab9c45d97a8ed42573822"
                ],
            ];
        } elseif ($id == 43113) {
            return [
                [
                    'symbol' => "AVAX",
                ],
                [
                    'symbol' =>  "USDT",
                    'address' =>  "0xFe143522938e253e5Feef14DB0732e9d96221D72"
                ]
            ];
        } elseif ($id == 80001) {
            return [
                [
                    'symbol' => "MATIC",
                ],
                [
                    'symbol' => "USDT",
                    'address' => "0xa02f6adc7926efebbd59fd43a84f4e0c0c91e832"
                ]
            ];
        } elseif ($id == 4002) {
            return [
                [
                    'symbol' => 'FTM',
                ]
            ];
        } elseif ($id == 421613) {
            return [
                [
                    'symbol' => 'ETH',
                ],
                [
                    'symbol' => "ARB",
                    'address' => "0xF861378B543525ae0C47d33C90C954Dc774Ac1F9"
                ]
            ];
        } elseif ($id == 420) {
            return [
                [
                    'symbol' => 'ETH',
                ],
                [
                    'symbol' => "OP",
                    'address' => "0x4200000000000000000000000000000000000042"
                ]
            ];
        } elseif ($id == 5611) {
            return [
                [
                    'symbol' => 'BNB',
                ],
            ];
        }
    }

    /**
     * @return void
     */
    public static function initSettings() : void
    {
        if (Settings::get('evmBasedActivePassive') && Settings::get('evmBasedWalletAddress') == '') {
            Services::networkWillNotWorkMessage('EVM Based');
        } 

        Settings::createSection(array(
            'id'     => 'evmBased', 
            'title'  => esc_html__('EVM Based settings', 'cryptopay'),
            'icon'   => 'fab fa-ethereum',
            'fields' => array(
                array(
                    'id'      => 'evmBasedActivePassive',
                    'title'   => esc_html__('Active/Passive', 'cryptopay'),
                    'type'    => 'switcher',
                    'default' => true,
                ),
                array(
                    'id'      => 'ensDomainForEthereum',
                    'title'   => esc_html__('ENS Domain', 'cryptopay'),
                    'type'    => 'text',
                    'help'    => esc_html__('ENS Domain just can working on the Ethereum', 'cryptopay'),
                    'desc'    => esc_html__('If you have an ENS domain, you can enter it here. It will only be shown for QR payments on the Ethereum network.', 'cryptopay') . ' ' . sprintf('<b>%s</b>', esc_html__('Your ENS Domain must match the address you enter below.', 'cryptopay')),
                    'sanitize' => function($val) {
						return sanitize_text_field($val);
					}
                ),
                array(
                    'id'      => 'evmBasedWalletAddress',
                    'title'   => esc_html__('Wallet address', 'cryptopay'),
                    'type'    => 'text',
                    'help'    => esc_html__('The account address to which the payments will be transferred. (BEP20, ERC20, MetaMask, Trust Wallet, Binance Wallet )', 'cryptopay'),
                    'sanitize' => function($val) {
						return sanitize_text_field($val);
					},
                    'validate' => function($val) {
                        $val = sanitize_text_field($val);
                        if (empty($val)) {
                            return esc_html__('Wallet address cannot be empty.', 'cryptopay');
                        } elseif (strlen($val) < 42 || strlen($val) > 42) {
                            return esc_html__('Wallet address must consist of 42 characters.', 'cryptopay');
                        }
                    }
                ),
                array(
                    'id'      => 'evmBasedBlockConfirmationCount',
                    'title'   => esc_html__('Block confirmation count', 'cryptopay'),
                    'type'    => 'number',
                    'default' => 10,
                    'sanitize' => function($val) {
						return absint($val);
					}
                ),
                array(
                    'id'     => 'evmBasedWallets',
                    'type'   => 'fieldset',
                    'title'  => esc_html__('Wallets', 'cryptopay'),
                    'help'   => esc_html__('Specify the wallets you want to accept payments from.', 'cryptopay'),
                    'fields' => array(
                        array(
                            'id'      => 'metamask',
                            'title'   => esc_html('MetaMask'),
                            'type'    => 'switcher',
                            'default' => true,
                        ),
                        array(
                            'id'      => 'trustwallet',
                            'title'   => esc_html('Trust Wallet'),
                            'type'    => 'switcher',
                            'default' => true,
                            'desc'    => esc_html__('Trust Wallet is only available on mainnets.', 'cryptopay'),
                        ),
                        array(
                            'id'      => 'binancewallet',
                            'title'   => esc_html('Binance Wallet'),
                            'type'    => 'switcher',
                            'default' => true,
                            'desc'    => esc_html__('Binance Wallet is only available on (BNB Smart Chain and Ethereum Mainnet).', 'cryptopay'),
                        ),
                        array(
                            'id'      => 'phantom',
                            'title'   => esc_html('Phantom'),
                            'type'    => 'switcher',
                            'default' => true,
                            'desc'    => esc_html__('Phantom is only available on Ethereum (Currently only supports mainnet).', 'cryptopay'),
                        ),
                        array(
                            'id'      => 'walletconnect',
                            'title'   => esc_html('WalletConnect'),
                            'type'    => 'switcher',
                            'default' => true
                        ),
                    )
                ),
                array(
                    'id'     => 'evmBasedMainnetInfo',
                    'title'  => esc_html__('Mainnet info', 'cryptopay'),
                    'type'   => 'content',
                    'content' => esc_html__('To activate QR payments on EVM Based networks you need to provide a Websocket address.'),
                ),
                array(
                    'id'      => 'evmBasedNetworks',
                    'title'   => esc_html__('Networks', 'cryptopay'),
                    'type'    => 'group',
                    'help'    => esc_html__('Add the blockchain networks you accept to receive payments.', 'cryptopay'),
                    'button_title' => esc_html__('Add new', 'cryptopay'),
                    'default' => [
                        [
                            'name' =>  'Ethereum',
                            'rpcUrl' =>  'https://mainnet.infura.io/v3/9aa3d95b3bc440fa88ea12eaa4456161',
                            'wsUrl' => 'wss://mainnet.infura.io/ws/v3/9aa3d95b3bc440fa88ea12eaa4456161',
                            'id' =>  1,
                            'explorerUrl' =>  'https://etherscan.io/',
                            'active' => true,
                            'image' =>  Plugin::$instance->getImageUrl('icons/eth.svg'),
                            'nativeCurrency' => [
                                'active' =>  true,
                                'symbol' =>  'ETH',
                                'decimals' =>  18,
                            ],
                            'currencies' => [
                                [ 
                                    'symbol' =>  'USDT',
                                    'address' =>  '0xdac17f958d2ee523a2206206994597c13d831ec7',
                                    'image' =>  Plugin::$instance->getImageUrl('icons/usdt.svg'),
                                    'active' => true
                                ],
                                [ 
                                    'symbol' =>  'USDC',
                                    'address' =>  '0xa0b86991c6218b36c1d19d4a2e9eb0ce3606eb48',
                                    'image' =>  Plugin::$instance->getImageUrl('icons/usdc.svg'),
                                    'active' => true
                                ],
                                [ 
                                    'symbol' =>  'BUSD',
                                    'address' =>  '0x4Fabb145d64652a948d72533023f6E7A623C7C53',
                                    'image' =>  Plugin::$instance->getImageUrl('icons/busd.svg'),
                                    'active' => true
                                ],
                                [ 
                                    'symbol' =>  'DAI',
                                    'address' =>  '0x6b175474e89094c44da98b954eedeac495271d0f',
                                    'image' =>  Plugin::$instance->getImageUrl('icons/dai.svg'),
                                    'active' => true
                                ],
                                [ 
                                    'symbol' =>  'BNB',
                                    'address' =>  '0xB8c77482e45F1F44dE1745F52C74426C631bDD52',
                                    'image' =>  Plugin::$instance->getImageUrl('icons/bnb.svg'),
                                    'active' => false
                                ],
                            ]
                        ],
                        [
                            'name' =>  'Arbitrum One',
                            'rpcUrl' =>  'https://arb1.arbitrum.io/rpc',
                            'id' =>  42161,
                            'explorerUrl' =>  'https://arbiscan.io/',
                            'active' => true,
                            'image' =>  Plugin::$instance->getImageUrl('icons/arb.svg'),
                            'nativeCurrency' => [
                                'active' =>  true,
                                'symbol' =>  'ETH',
                                'decimals' =>  18,
                            ],
                            'currencies' => [
                                [ 
                                    'symbol' =>  'ARB',
                                    'address' =>  '0x912CE59144191C1204E64559FE8253a0e49E6548',
                                    'image' =>  Plugin::$instance->getImageUrl('icons/arb.svg'),
                                    'active' => true
                                ],
                            ]
                        ],
                        [
                            'name' =>  'Optimism',
                            'rpcUrl' =>  'https://mainnet.optimism.io',
                            'id' =>  10,
                            'explorerUrl' =>  'https://explorer.optimism.io/',
                            'active' => true,
                            'image' =>  Plugin::$instance->getImageUrl('icons/op.svg'),
                            'nativeCurrency' => [
                                'active' =>  true,
                                'symbol' =>  'ETH',
                                'decimals' =>  18,
                            ],
                            'currencies' => [
                                [ 
                                    'symbol' =>  'OP',
                                    'address' =>  '0x4200000000000000000000000000000000000042',
                                    'image' =>  Plugin::$instance->getImageUrl('icons/op.svg'),
                                    'active' => true
                                ],
                            ]
                        ],
                        [
                            'name' =>  'BNB Smart Chain',
                            'rpcUrl' =>  'https://bsc-dataseed.binance.org/',
                            'id' =>  56,
                            'explorerUrl' =>  'https://bscscan.com/',
                            'active' => true,
                            'image' =>  Plugin::$instance->getImageUrl('icons/bnb.svg'),
                            'nativeCurrency' => [
                                'active' =>  true,
                                'symbol' =>  'BNB',
                                'decimals' =>  18,
                            ],
                            'currencies' => [
                                [ 
                                    'symbol' =>  'BUSD',
                                    'address' =>  '0xe9e7cea3dedca5984780bafc599bd69add087d56',
                                    'image' =>  Plugin::$instance->getImageUrl('icons/busd.svg'),
                                    'active' => true
                                ],
                                [
                                    'symbol' =>  'USDT',
                                    'address' =>  '0x55d398326f99059ff775485246999027b3197955',
                                    'image' =>  Plugin::$instance->getImageUrl('icons/usdt.svg'),
                                    'active' => true
                                ],
                                [
                                    'symbol' =>  'USDC',
                                    'address' =>  '0x8ac76a51cc950d9822d68b83fe1ad97b32cd580d',
                                    'image' =>  Plugin::$instance->getImageUrl('icons/usdc.svg'),
                                    'active' => true
                                ],
                                [
                                    'symbol' =>  'DAI',
                                    'address' =>  '0x1af3f329e8be154074d8769d1ffa4ee058b1dbc3',
                                    'image' =>  Plugin::$instance->getImageUrl('icons/dai.svg'),
                                    'active' => true
                                ],
                                [
                                    'symbol' =>  'ETH',
                                    'address' =>  '0x2170ed0880ac9a755fd29b2688956bd959f933f8',
                                    'image' =>  Plugin::$instance->getImageUrl('icons/eth.svg'),
                                    'active' => false
                                ],
                                [
                                    'symbol' =>  'LTC',
                                    'address' =>  '0x4338665cbb7b2485a8855a139b75d5e34ab0db94',
                                    'image' =>  Plugin::$instance->getImageUrl('icons/ltc.svg'),
                                    'active' => false
                                ],
                                [
                                    'symbol' =>  'DOGE',
                                    'address' =>  '0xba2ae424d960c26247dd6c32edc70b295c744c43',
                                    'image' =>  Plugin::$instance->getImageUrl('icons/doge.svg'),
                                    'active' => false
                                ]
                            ]
                        ],
                        [
                            'name' =>  'opBNB Smart Chain',
                            'rpcUrl' =>  'https://opbnb-mainnet-rpc.bnbchain.org',
                            'id' =>  204,
                            'explorerUrl' =>  'https://opbnbscan.com/',
                            'active' => true,
                            'image' =>  Plugin::$instance->getImageUrl('icons/bnb.svg'),
                            'nativeCurrency' => [
                                'active' =>  true,
                                'symbol' =>  'BNB',
                                'decimals' =>  18,
                            ],
                            'currencies' => []
                        ],
                        [
                            'name' =>  'Avalanche',
                            'rpcUrl' =>  'https://api.avax.network/ext/bc/C/rpc',
                            'id' =>  43114,
                            'explorerUrl' =>  'https://cchain.explorer.avax.network/',
                            'active' => true,
                            'image' =>  Plugin::$instance->getImageUrl('icons/avax.svg'),
                            'nativeCurrency' => [
                                'active' =>  true,
                                'symbol' =>  'AVAX',
                                'decimals' =>  18,
                            ],
                            'currencies' => [
                                [ 
                                    'symbol' =>  'USDT',
                                    'address' =>  '0xde3a24028580884448a5397872046a019649b084',
                                    'image' =>  Plugin::$instance->getImageUrl('icons/usdt.svg'),
                                    'active' => true
                                ],
                                [ 
                                    'symbol' =>  'DAI',
                                    'address' =>  '0xba7deebbfc5fa1100fb055a87773e1e99cd3507a',
                                    'image' =>  Plugin::$instance->getImageUrl('icons/dai.svg'),
                                    'active' => true
                                ],
                                [ 
                                    'symbol' =>  'ETH',
                                    'address' =>  '0xf20d962a6c8f70c731bd838a3a388D7d48fA6e15',
                                    'image' =>  Plugin::$instance->getImageUrl('icons/eth.svg'),
                                    'active' => true
                                ],
                            ]
                        ],
                        [
                            'name' =>  'Polygon',
                            'rpcUrl' =>  'https://polygon-rpc.com/',
                            'id' =>  137,
                            'explorerUrl' =>  'https://polygonscan.com/',
                            'active' => true,
                            'image' =>  Plugin::$instance->getImageUrl('icons/matic.svg'),
                            'nativeCurrency' => [
                                'active' =>  true,
                                'symbol' =>  'MATIC',
                                'decimals' =>  18,
                            ],
                            'currencies' => [
                                [ 
                                    'symbol' =>  'USDT',
                                    'address' =>  '0xc2132d05d31c914a87c6611c10748aeb04b58e8f',
                                    'image' =>  Plugin::$instance->getImageUrl('icons/usdt.svg'),
                                    'active' => true
                                ],
                                [ 
                                    'symbol' =>  'USDC',
                                    'address' =>  '0x2791bca1f2de4661ed88a30c99a7a9449aa84174',
                                    'image' =>  Plugin::$instance->getImageUrl('icons/usdc.svg'),
                                    'active' => true
                                ],
                                [ 
                                    'symbol' =>  'DAI',
                                    'address' =>  '0x8f3Cf7ad23Cd3CaDbD9735AFf958023239c6A063',
                                    'image' =>  Plugin::$instance->getImageUrl('icons/dai.svg'),
                                    'active' => true
                                ],
                            ]
                            ],
                        [
                            'name' =>  'Polygon',
                            'rpcUrl' =>  'https://polygon-rpc.com/',
                            'id' =>  137,
                            'explorerUrl' =>  'https://polygonscan.com/',
                            'active' => true,
                            'image' =>  Plugin::$instance->getImageUrl('icons/matic.svg'),
                            'nativeCurrency' => [
                                'active' =>  true,
                                'symbol' =>  'MATIC',
                                'decimals' =>  18,
                            ],
                            'currencies' => [
                                [ 
                                    'symbol' =>  'USDT',
                                    'address' =>  '0xc2132d05d31c914a87c6611c10748aeb04b58e8f',
                                    'image' =>  Plugin::$instance->getImageUrl('icons/usdt.svg'),
                                    'active' => true
                                ],
                                [ 
                                    'symbol' =>  'USDC',
                                    'address' =>  '0x2791bca1f2de4661ed88a30c99a7a9449aa84174',
                                    'image' =>  Plugin::$instance->getImageUrl('icons/usdc.svg'),
                                    'active' => true
                                ],
                                [ 
                                    'symbol' =>  'DAI',
                                    'address' =>  '0x8f3Cf7ad23Cd3CaDbD9735AFf958023239c6A063',
                                    'image' =>  Plugin::$instance->getImageUrl('icons/dai.svg'),
                                    'active' => true
                                ],
                            ]
                        ],
                        [
                            'name' =>  'Fantom',
                            'rpcUrl' =>  'https://rpc.fantom.network',
                            'id' =>  250,
                            'explorerUrl' =>  'https://ftmscan.com/',
                            'active' => true,
                            'image' =>  Plugin::$instance->getImageUrl('icons/ftm.svg'),
                            'nativeCurrency' => [
                                'active' =>  true,
                                'symbol' =>  'FTM',
                                'decimals' =>  18,
                            ],
                            'currencies' => []
                        ]
                    ],
                    'sanitize' => function($val) {
                        if (is_array($val)) {
                            foreach ($val as &$value) {
                                $value['id'] = absint($value['id']);
                                $value['name'] = sanitize_text_field($value['name']);
                                $value['rpcUrl'] = sanitize_text_field($value['rpcUrl']);
                                $value['wsUrl'] = sanitize_text_field($value['wsUrl']);
                                $value['explorerUrl'] = sanitize_text_field($value['explorerUrl']);
                                $value['nativeCurrency']['symbol'] = strtoupper(sanitize_text_field($value['nativeCurrency']['symbol']));
                                $value['nativeCurrency']['decimals'] = absint($value['nativeCurrency']['decimals']);
                                if ($value['image']) {
                                    $value['image'] = sanitize_text_field($value['image']);
                                }
                                if (isset($value['currencies'])) {
                                    foreach ($value['currencies'] as &$currency) {
                                        $currency['symbol'] = strtoupper(sanitize_text_field($currency['symbol']));
                                        $currency['address'] = sanitize_text_field($currency['address']);
                                        if ($currency['image']) {
                                            $currency['image'] = sanitize_text_field($currency['image']); 
                                        }
                                    }
                                }
                            }
                        }

                        return $val;
                    },
                    'validate' => function($val) {
                        if (is_array($val)) {
                            foreach ($val as $key => $value) {
                                if (empty($value['name'])) {
                                    return esc_html__('Network name cannot be empty.', 'cryptopay');
                                } elseif (empty($value['rpcUrl'])) {
                                    return esc_html__('Network RPC URL cannot be empty.', 'cryptopay');
                                } elseif (empty($value['id'])) {
                                    return esc_html__('Chain ID cannot be empty.', 'cryptopay');
                                } elseif (empty($value['explorerUrl'])) {
                                    return esc_html__('Explorer URL cannot be empty.', 'cryptopay');
                                } elseif (empty($value['nativeCurrency']['symbol'])) {
                                    return esc_html__('Native currency symbol cannot be empty.', 'cryptopay');
                                } elseif (empty($value['nativeCurrency']['decimals'])) {
                                    return esc_html__('Native currency Decimals cannot be empty.', 'cryptopay');
                                } elseif (isset($value['currencies'])) {
                                    foreach ($value['currencies'] as $currency) {
                                        if (empty($currency['symbol'])) {
                                            return esc_html__('Currency symbol cannot be empty.', 'cryptopay');
                                        } elseif (empty($currency['address'])) {
                                            return esc_html__('Currency contract address cannot be empty.', 'cryptopay');
                                        } elseif (strlen($currency['address']) < 42 || strlen($currency['address']) > 42) {
                                            return esc_html__('Currency contract address must consist of 42 characters.', 'cryptopay');
                                        }
                                    }
                                }
                            }
                        } else {
                            return esc_html__('You must add at least one blockchain network!', 'cryptopay');
                        }
                    },
                    'fields'    => array(
                        array(
                            'title' => esc_html__('Network name', 'cryptopay'),
                            'id'    => 'name',
                            'type'  => 'text'
                        ),
                        array(
                            'title' => esc_html__('Network RPC URL', 'cryptopay'),
                            'id'    => 'rpcUrl',
                            'type'  => 'text',
                            'desc'    => esc_html__('Because the default RPC addresses of blockchain networks are public and used by everyone. Sometimes they can restrict you so some times you need a special RPC address.', 'cryptopay'),
                        ),
                        array(
                            'title' => esc_html__('Websocket URL', 'cryptopay'),
                            'id'    => 'wsUrl',
                            'type'  => 'text',
                            'help'    => esc_html__('If you want to enable QR payments on this network, please provide a Websocket URL.', 'cryptopay'),
                            'desc' => '<a href="https://beycanpress.gitbook.io/cryptopay-docs/network-support-add-ons/what-are-websocket-url" target="_blank">What are Websocket URL?</a>',
                        ),
                        array(
                            'title' => esc_html__('Chain ID', 'cryptopay'),
                            'id'    => 'id',
                            'type'  => 'number'
                        ),
                        array(
                            'title' => esc_html__('Explorer URL', 'cryptopay'),
                            'id'    => 'explorerUrl',
                            'type'  => 'text'
                        ),
                        array(
                            'id'      => 'active',
                            'title'   => esc_html__('Active/Passive', 'cryptopay'),
                            'type'    => 'switcher',
                            'help'    => esc_html__('Get paid in this network?', 'cryptopay'),
                            'default' => true,
                        ),
                        array(
                            'title' => esc_html__('Image', 'cryptopay'),
                            'id'    => 'image',
                            'type'  => 'upload',
                            'help'    => esc_html__('You can upload an custom image for this network. If you\'r not choose any image app will use default image.', 'cryptopay'),
                        ),
                        array(
                            'id'     => 'nativeCurrency',
                            'type'   => 'fieldset',
                            'title'  => esc_html__('Native currency', 'cryptopay'),
                            'fields' => array(
                                array(
                                    'id'      => 'active',
                                    'title'   => esc_html__('Active/Passive', 'cryptopay'),
                                    'type'    => 'switcher',
                                    'help'    => esc_html__('Get paid in native currency?', 'cryptopay'),
                                    'default' => true,
                                ),
                                array(
                                    'id'    => 'symbol',
                                    'type'  => 'text',
                                    'title' => esc_html__('Symbol', 'cryptopay')
                                ),
                                array(
                                    'id'    => 'decimals',
                                    'type'  => 'number',
                                    'title' => esc_html__('Decimals', 'cryptopay')
                                )
                            ),
                        ),
                        array(
                            'id'        => 'currencies',
                            'type'      => 'group',
                            'title'     => esc_html__('Currencies', 'cryptopay'),
                            'button_title' => esc_html__('Add new', 'cryptopay'),
                            'fields'    => array(
                                array(
                                    'title' => esc_html__('Symbol', 'cryptopay'),
                                    'id'    => 'symbol',
                                    'type'  => 'text'
                                ),
                                array(
                                    'title' => esc_html__('Contract address', 'cryptopay'),
                                    'id'    => 'address',
                                    'type'  => 'text'
                                ),
                                array(
                                    'title' => esc_html__('Image', 'cryptopay'),
                                    'id'    => 'image',
                                    'type'  => 'upload'
                                ),
                                array(
                                    'id'      => 'active',
                                    'title'   => esc_html__('Active/Passive', 'cryptopay'),
                                    'type'    => 'switcher',
                                    'help'    => esc_html__('You can easily activate or deactivate Token without deleting it.', 'cryptopay'),
                                    'default' => true,
                                ),
                            ),
                        ),
                    ),
                )
            ) 
        ));
    }
}