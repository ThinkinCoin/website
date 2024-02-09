<div style="text-align:left;"><?php $ksesEcho($transactionHtmlDetails); ?></div>

<?php 
    if (is_array($urls) && isset($urls['success']) && isset($urls['failed'])) {
        $url = $paymentData->getStatus() ? $urls['success'] : $urls['failed'];
        ?> 
            <br>
            <a href="<?php echo esc_url_raw($url); ?>">
                <?php echo __('Click to see your order', 'cryptopay'); ?>
            </a>
        <?php
    }
?>

<br><br> <?php echo __('From:', 'cryptopay'); ?> <?php echo get_bloginfo('name'); ?> <?php echo __('by CryptoPay', 'cryptopay'); ?>