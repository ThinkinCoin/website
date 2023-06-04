<?php
if (!defined('ABSPATH')) {
    exit;
}
$options = get_option('cpmw_settings');
$network_name = $this->cpmw_supported_networks();
$get_network = $options["Chain_network"];
$const_msg = $this->cpmw_const_messages();

wp_enqueue_style('ca-loader-css', CPMW_URL . 'assets/css/cpmw.css');

$crypto_currency = ($get_network == '0x1' || $get_network == '0x5') ? $options["eth_select_currency"] : $options["bnb_select_currency"];
$type = $options['currency_conversion_api'];
$total_price = $this->get_order_total();
$metamask = "";
$inc = 1;
do_action('woocommerce_cpmw_form_start', $this->id);
?>
            <div class="form-row form-row-wide">
                <p><?php
$cpmw_settings = admin_url() . 'admin.php?page=cpmw-metamask-settings';
$user_wallet = $options['user_wallet'];
$bnb_currency = $options['bnb_select_currency'];
$eth_currency = $options['eth_select_currency'];
$compare_key = $options['crypto_compare_key'];
$openex_key = $options['openexchangerates_key'];
$select_currecny = $options['currency_conversion_api'];
$link_html = (current_user_can('manage_options')) ? '<a href="' . esc_url($cpmw_settings) . '" target="_blank">' . __("Click here", "cpmw") . '</a>' . __('to open settings', 'cpmw') : "";

if (empty($user_wallet)) {
    echo '<strong>' . esc_html($const_msg['metamask_address']) . wp_kses_post($link_html) . '</strong>';
    return false;

}
if (!empty($user_wallet) && strlen($user_wallet) != "42") {
    echo '<strong>' . esc_html($const_msg['valid_wallet_address']) . wp_kses_post($link_html) . '</strong>';
    return false;

}
if ($select_currecny == "cryptocompare" && empty($compare_key)) {
    echo '<strong>' . esc_html($const_msg['required_fiat_key']) . wp_kses_post($link_html) . '</strong>';
    return false;

}
if ($select_currecny == "openexchangerates" && empty($openex_key)) {
    echo '<strong>' . esc_html($const_msg['required_fiat_key']) . wp_kses_post($link_html) . '</strong>';
    return false;

}
if (empty($bnb_currency) || empty($eth_currency)) {
    echo '<strong>' . esc_html($const_msg['required_currency']) . wp_kses_post($link_html) . '</strong>';
    return false;

}

echo ' <label class="cpmw_selected_network">' . esc_html($network_name[$get_network]) . '</label>';

if (is_array($crypto_currency)) {

    foreach ($crypto_currency as $key => $value) {

        $image_url = $this->cpmw_get_coin_logo($value);

        $in_busd = $this->cpmw_price_conversion($total_price, $value, $type);
        if (!empty($in_busd) && $in_busd != "error" && !is_array($in_busd)) {
            ?>
                    <div class="cpmw-pymentfield">
                    <input class="cpmw_payment_method" type="radio" class="input-radio" name="cpmw_crypto_coin" value="<?php echo !empty($in_busd) ? esc_attr($value) : ""; ?>" <?php echo ($key == '0') ? 'checked' : ""; ?> />
                        <img src="<?php echo esc_url($image_url); ?>"/>
                        <span><?php echo esc_html($value) ?></span>
                    <p class="cpmw_crypto_price"><?php echo esc_html($in_busd . $value) ?></p>
                    </div>
                    <?php

        } else {
            if ($inc == 1 && $in_busd == "error") {
                echo '<strong>' . esc_html($const_msg['valid_fiat_key']) . wp_kses_post($link_html) . '</strong>';
            } else if (is_array($in_busd)) {
                echo '<strong>' . wp_kses_post($in_busd['restricted']) . '</strong>';
            }
            $inc++;
            ?>
                    <input id="invalid_app_id" type="hidden"  name="invalid_app_id" value="<?php echo esc_attr($in_busd); ?>"/>
                    <?php
}

    }
}
?>
               </div>
                <?php
do_action('woocommerce_cpmw_form_end', $this->id);