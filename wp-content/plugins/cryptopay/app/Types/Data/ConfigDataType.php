<?php

declare(strict_types=1);

namespace BeycanPress\CryptoPay\Types\Data;

// Classes
use BeycanPress\CryptoPay\Helpers;
use BeycanPress\CryptoPay\Constants;
use BeycanPress\CryptoPay\PluginHero\Hook;
// Types
use BeycanPress\CryptoPay\Types\InitType;
use BeycanPress\CryptoPay\Types\AbstractType;
use BeycanPress\CryptoPay\Types\Network\NetworksType;

/**
 * The class where the data to be sent to CryptoPay JS is set
 * @since 2.1.0
 */
class ConfigDataType extends AbstractType
{
    #String types

    /**
     * Indicates in which plugin the payment process is processed. For example woocommerce, memberpress, donation etc.
     * @var string
     */
    private string $addon;

    /**
     * CryptoPay JS payment listing mode (network, currency)
     * @var string
     */
    private string $mode;

    /**
     * CryptoPay JS theme
     * @var string
     */
    private string $theme;

    /**
     * URL of our Rest API that handles the payment process.
     * @var string
     */
    private string $apiUrl;

    /**
     * URL path with the images to be used on the CryptoPay JS side.
     * @var string
     */
    private string $imagesUrl;

    /**
     * CryptoPay version code
     * @var string
     */
    private string $version;

    /**
     * CryptoPay logo URL for using on the QR code.
     * @var string
     */
    private string $logo;

    /**
     * Our QR-Verifier service websocket url for qr payments
     * @var string
     */
    private string $webSocketUrl;

    /**
     * Reminder e-mail is the e-mail of the current user if the user is logged in during the e-mail.
     * This is used directly. If the user is not logged in,
     * this will be empty and the user will be prompted to enter an email.
     * @var ?string
     */
    private ?string $userEmail;

    #String types

    #Class types

    /**
     * Active networks to send to CryptoPay JS.
     * @var NetworksType[NetworkType]
     */
    private NetworksType $networks;

    #Class types

    #Object types

    /**
     * If this is defined, CryptoPay JS will not make a request to the API during the init process.
     * And will directly use the data here.
     * @var InitType|null
     */
    private ?InitType $init = null;

    /**
     * It has an imagesUrl, but this imagesUrl is generally used to access all cryptocurrency icons.
     * We have such a property and hook because we create separate packages (add-ons) for each network.
     * So the URLs of wallets that are specific to other packages can be added.
     * @var object<string>
     */
    private object $walletImages;

    /**
     * The dynamic texts to be sent to CryptoPay JS.
     * @see \BeycanPress\CryptoPay\Constants
     * @var object<string>
     */
    private object $lang;

    /**
     * The data received with the js_providers hook will be set
     * @var array<string>
     */
    private array $providers;

    /**
     * This property contains the data sent directly to the MultipleChain packages we use in CryptoPay.
     * This data can be variable. Because other packages may need other data
     * and can add other data with other hooks in their support plugin.
     * @var object<string>
     */
    private object $providerConfig;

    /**
     * This property contains the discount rates of the currencies.
     */
    private object $discountRates;

    #Object types

    #Boolean types

    /**
     * When debug mode is activated, it also activates debug mode in CryptoPay JS.
     * @var bool
     */
    private bool $debug;

    /**
     * CryptoPay JS also decides whether the payment goes to the confirmation step or not.
     * If False, the process is considered complete when the payment is detected.
     * This is usually set to false by us for payments made by the admin.
     * @var bool
     */
    private bool $confirmation;

    /**
     * After the payment is detected, it checks whether the relevant transaction record will be created.
     * This is automatically assigned if a model has been created for the related addon, if not it is false.
     * @var bool
     */
    private bool $createTransaction;

    /**
     * Users who do not want to wait for the verification process, which is a data from the settings,
     * can set up an email reminder using this.
     * @var bool
     */
    private bool $reminderEmail;

    #Boolean types

    #Integer types

    /**
     * In CryptoPay JS, the price is updated periodically, which indicates how often this transaction will occur.
     * @var float|int
     */
    private float $amountUpdateMin;

    #Integer types

    /**
     * @param string $addon
     */
    public function __construct(string $addon)
    {
        Helpers::checkIntegration($this->addon = $addon);

        // declare defaults
        $this->discountRates = (object) [];
        $this->logo = Constants::getLogoUrl();
        $this->apiUrl = Constants::getApiUrl();
        $this->lang = Constants::getLangParams();
        $this->imagesUrl = Constants::getImagesUrl();
        $this->userEmail = Helpers::getCurrentUserEmail();
        $this->webSocketUrl = Constants::getWebSocketUrl();
        $this->version = Helpers::getProp('pluginVersion');
        $this->createTransaction = boolval(Helpers::getModelByAddon($addon));

        // only for multiplechain providers
        $this->providerConfig = (object) [
            'testnet' => Helpers::getTestnetStatus(),
            'wcThemeMode' => $this->getTheme($addon),
            'wcProjectId' => Constants::getWcProjectId(),
        ];

        // declare settings
        $this->mode = Helpers::getMode($addon);
        $this->theme = $this->getTheme($addon);
        $this->walletImages = $this->getWalletImages();
        $this->amountUpdateMin = $this->getUpdateMin();
        $this->debug = boolval(Helpers::getSetting('debugging'));
        $this->reminderEmail = boolval(Helpers::getSetting('reminderEmail'));
    }

    /**
     * @return float
     */
    private function getUpdateMin(): float
    {
        $updateMin = Helpers::getSetting('amountUpdateMin');
        return $updateMin ? floatval($updateMin) : 0.5;
    }

    /**
     * @param string $addon
     * @return string
     */
    private function getTheme(string $addon): string
    {
        return Hook::callFilter('theme_' . $addon, Hook::callFilter('theme', Helpers::getSetting('theme')));
    }

    /**
     * @return object
     */
    private function getWalletImages(): object
    {
        $pluginUrl = Helpers::getProp('pluginUrl');

        $walletImages = [
            'qr' => $pluginUrl . 'assets/images/wallets/qr.jpg',
            'walletconnect' => $pluginUrl . 'assets/images/wallets/walletconnect.png',
        ];

        array_map(function ($wallet) use (&$walletImages, $pluginUrl): void {
            $walletImages[$wallet] = $pluginUrl . 'assets/images/wallets/' . $wallet . '.png';
        }, Helpers::getWalletsByCode('evmchains'));

        return (object) Hook::callFilter('wallet_images', $walletImages);
    }

    // Set methods for outcoming data

    /**
     * @param InitType $init
     * @return self
     */
    public function setInit(InitType $init): self
    {
        $this->init = $init;
        return $this;
    }

    /**
     * @param NetworksType $networks
     * @return self
     */
    public function setNetworks(NetworksType $networks): self
    {
        $this->networks = $networks;
        return $this;
    }

    /**
     * @param array<string> $providers
     * @return self
     */
    public function setProviders(array $providers): self
    {
        $this->providers = $providers;
        return $this;
    }

    /**
     * @param bool $confirmation
     * @return self
     */
    public function setConfirmation(bool $confirmation): self
    {
        $this->confirmation = $confirmation;
        return $this;
    }

    /**
     * @param object $discountRates
     * @return self
     */
    public function setDiscountRates(object $discountRates): self
    {
        $this->discountRates = $discountRates;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddon(): string
    {
        return $this->addon;
    }

    /**
     * @return array<string,mixed>
     */
    public function prepareForJsSide(): array
    {
        return $this->toArray(exclude: [
            'init' => [
                'order' => ['refunds', 'discountRate']
            ],
        ]);
    }
}
