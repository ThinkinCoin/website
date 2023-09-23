<div class="clear"></div>
<p>
    <h3>
        <?php echo __('CryptoPay Payment details', 'cryptopay'); ?>
    </h3>
    <div>
        <p>
            <strong><?php echo __('Blockchain Network', 'cryptopay'); ?>:</strong>
            <?php echo $blockchainNetwork; ?>
        </p>
        <p>
            <strong><?php echo __('Payment Price', 'cryptopay'); ?>:</strong>
            <?php echo $paymentAmount; ?> <?php echo $paymentCurrency; ?>
        </p>
        <p>
            <strong><?php echo __('Transaction Hash', 'cryptopay'); ?>:</strong>
            <a href="<?php echo admin_url('admin.php?page=cryptopay_order_transactions&s=' . $transactionHash); ?>">
                <?php echo $transactionHash; ?>
            </a>
        </p>
    </div>
</p>