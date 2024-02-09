<?php

declare(strict_types=1);

defined('ABSPATH') || exit;

// @phpcs:disable PSR1.Files.SideEffects
// @phpcs:disable Generic.Files.LineLength 

/**
 * Plugin Name: CryptoPay
 * Version:     2.1.1
 * Plugin URI:  https://beycanpress.com/cryptopay/
 * Update URI:  https://beycanpress.com/cryptopay/
 * Description: All In One Cryptocurrency Payments for WordPress
 * Author:      BeycanPress LLC
 * Author URI:  https://beycanpress.com
 * Text Domain: cryptopay
 * Domain Path: /languages
 * Tags:        CryptoPay, Cryptocurrency, WooCommerce, WordPress, MetaMask, Trust, Binance, Wallet, Ethereum, Bitcoin, Binance smart chain, Payment, Plugin, Gateway
 * Requires at least: 5.0
 * Tested up to: 6.4.2
 * Requires PHP: 8.1
*/

/**
 * Define constants
 */
define('CP_NL', "\n");
define('CP_BR', '<br>');
define('CP_BR2', '<br><br>');

/**
 * @return float
 */
function cryptoPayGetPHPMajorVersion(): float
{
    $version = explode('.', PHP_VERSION);
    return floatval($version[0] . '.' . $version[1]);
}

/**
 * @return int|null
 */
function cryptoPayGetIonCubeLoaderVersion(): ?int
{
    if (function_exists('ioncube_loader_iversion')) {
        $version = ioncube_loader_iversion();
        $version = sprintf('%d', $version / 10000);
        return intval($version);
    }
    return null;
}

/**
 * @return bool
 */
function checkCryptoPayRequirements(): bool
{
    $status = true;

    // vars
    $requiredIonCubeVersion = 13;
    $supportedPhpVersions = [8.1, 8.2];

    if (!in_array(cryptoPayGetPHPMajorVersion(), $supportedPhpVersions)) {
        $status = false;
        add_action('admin_notices', function () use ($supportedPhpVersions): void {
            $class = 'notice notice-error';
            // @phpcs:ignore
            $message = 'CryptoPay: Your current PHP version does not support ' . cryptoPayGetPHPMajorVersion() . '. This means errors may occur due to incompatibility or other reasons. So CryptoPay is disabled please use one of the supported versions ' . implode(' or ', $supportedPhpVersions) . '. You can ask your server service provider to update your PHP version.';
            printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), $message);
        });
    }

    if (!extension_loaded('bcmath')) {
        $status = false;
        add_action('admin_notices', function (): void {
            $class = 'notice notice-error';
            $message = 'CryptoPay: BCMath PHP extension is not installed. So CryptoPay has been disabled BCMath is a mathematical library that CryptoPay needs and uses to verify blockchain transactions. Please visit "' . (php_sapi_name() == 'cli' ? 'https://www.php.net/manual/en/book.bc.php' : '<a href="https://www.php.net/manual/en/book.bc.php">https://www.php.net/manual/en/book.bc.php</a>') . '" for install assistance. You can ask your server service provider to install BCMath.';
            printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), $message);
        });
    }

    if (!extension_loaded('curl')) {
        $status = false;
        add_action('admin_notices', function (): void {
            $class = 'notice notice-error';
            $message = 'CryptoPay: cURL PHP extension is not installed. So CryptoPay has been disabled cURL is a HTTP request library that CryptoPay needs and uses to verify blockchain transactions. Please visit "' . (php_sapi_name() == 'cli' ? 'https://www.php.net/manual/en/book.curl.php' : '<a href="https://www.php.net/manual/en/book.curl.php">https://www.php.net/manual/en/book.curl.php</a>') . '" for install assistance. You can ask your server service provider to install cURL.';
            printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), $message);
        });
    }

    if (!function_exists('file_get_contents')) {
        $status = false;
        add_action('admin_notices', function (): void {
            $class = 'notice notice-error';
            $message = 'CryptoPay: file_get_contents PHP function is not available. So CryptoPay has been disabled file_get_contents is a PHP function that CryptoPay needs and uses for some process. Please visit "' . (php_sapi_name() == 'cli' ? 'https://www.php.net/manual/en/function.file-get-contents.php' : '<a href="https://www.php.net/manual/en/function.file-get-contents.php">https://www.php.net/manual/en/function.file-get-contents.php</a>') . '" for install assistance. You can ask your server service provider to enable file_get_contents.';
            printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), $message);
        });
    }

    $ionCubeVersion = cryptoPayGetIonCubeLoaderVersion();
    if (!$ionCubeVersion || $ionCubeVersion < $requiredIonCubeVersion) {
        $status = false;
        add_action('admin_notices', function () use ($requiredIonCubeVersion, $ionCubeVersion): void {
            $class = 'notice notice-error';
            $message = "CryptoPay: Is disabled because " . (php_sapi_name() == 'cli' ? 'ionCube ' . $requiredIonCubeVersion : '<a href="http://www.ioncube.com">ionCube ' . $requiredIonCubeVersion . '</a>') . " PHP Loader is not installed! In order for CryptoPay to work, you must have ionCube " . $requiredIonCubeVersion . " and above. This is a widely used PHP extension for running ionCube protected PHP code, website security and malware blocking. Please visit " . (php_sapi_name() == 'cli' ? 'ioncube.com/loaders.php' : '<a href="https://www.ioncube.com/loaders.php">ioncube.com/loaders.php</a>') . " for install assistance or you can ask your server service provider to install ionCube " . $requiredIonCubeVersion . " or above. Your current installed IonCube version is " . ($ionCubeVersion ? $ionCubeVersion : 'not installed') . ".";
            printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), $message);
        });
    }

    // if xdebug enabled and if Loader.php encoded so this mean production, then disable and show notice
    if (extension_loaded('xdebug') && $status) {
        $modes = xdebug_info('mode');
        $loaderFile = file_get_contents(__DIR__ . '/app/Loader.php', true);
        if (isset($modes[0]) && $modes[0] != 'off' && strpos($loaderFile, 'HR+') !== false) {
            $status = false;
            add_action('admin_notices', function (): void {
                $class = 'notice notice-error';
                $message = 'CryptoPay: xDebug installation was detected and CryptoPay was disabled because of it. This is because CryptoPay uses IonCube for license protection and the IonCube Loader is incompatible with xDebug, causing the site to crash. xDebug helps developers with debug and profile, but it doesn\'t need to be on the production site. So to turn off xDebug, please set mode to off or uninstall it. If you are not familiar with this process, you can get help from your server service provider.';
                printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), $message);
            });
        }
    }

    if (!$status) {
        add_action('admin_notices', function (): void {
            $class = 'notice notice-error';
            $message = sprintf('CryptoPay: Deficiencies in CryptoPay requirements have been detected. You can check the %s if you wish.', '<a href="https://beycanpress.gitbook.io/cryptopay-docs/installation" target="_blank">documentation</a>');
            printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), $message);
        });
    }

    return $status;
}

/**
 * @return void
 */
add_action('before_woocommerce_init', function (): void {
    if (class_exists(\Automattic\WooCommerce\Utilities\FeaturesUtil::class)) {
        \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility('custom_order_tables', __FILE__, true);
        \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility('cart_checkout_blocks', __FILE__, true);
    }
});

if (!function_exists('json_validate')) {
    /**
     * @param string $string
     * @return bool
     */
    function json_validate(string $string): bool
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
}

// Check requirements and load CryptoPay
if (checkCryptoPayRequirements()) {
    require __DIR__ . '/vendor/autoload.php';
    new \BeycanPress\CryptoPay\Loader(__FILE__);
}
