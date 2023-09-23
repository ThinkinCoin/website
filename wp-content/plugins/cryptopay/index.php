<?php defined('ABSPATH') || exit;

/**
 * Plugin Name: CryptoPay
 * Version:     1.6.0
 * Plugin URI:  https://beycanpress.com/cryptopay
 * Description: All In One Cryptocurrency Payments for WordPress
 * Author:      BeycanPress
 * Author URI:  https://beycanpress.com
 * Text Domain: cryptopay
 * Domain Path: /languages
 * Tags: CryptoPay, Cryptocurrency, WooCommerce, WordPress, MetaMask, Trust, Binance, Wallet, Ethereum, Bitcoin, Binance smart chain, Payment, Plugin, Gateway
 * Requires at least: 5.0
 * Tested up to: 6.3
 * Requires PHP: 7.4
 * WC requires at least: 4.4
 * WC tested up to: 8.0
*/

if (extension_loaded('ionCube Loader')) {
    // Load plugin
    require __DIR__ . '/vendor/autoload.php';
    $GLOBALS['cryptopay_version'] = '1.6.0';
    new \BeycanPress\CryptoPay\Loader(__FILE__);
} else {
    add_action('admin_notices', function() {
        $class = 'notice notice-error';
        $message = "CryptoPay: the ".(php_sapi_name()=='cli'?'ionCube 12':'<a href="http://www.ioncube.com">ionCube 12</a>')." PHP Loader needs to be installed. This is a widely used PHP extension for running ionCube protected PHP code, website security and malware blocking. Please visit ".(php_sapi_name()=='cli'?'get-loader.ioncube.com':'<a href="http://get-loader.ioncube.com">get-loader.ioncube.com</a>')." for install assistance. You can ask your server service provider to install ionCube 12.";
        printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), $message);
    });
}
