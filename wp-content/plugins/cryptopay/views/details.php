<section class="cryptopay-payment-details">
    <h2 class="cryptopay-payment-details-title">
        <?php echo esc_html__('CryptoPay payment details', 'cryptopay'); ?>
    </h2>
    <table class="cryptopay-payment-details-table">
        <tr>
            <th scope="row">
                <?php echo esc_html__('Name: ', 'cryptopay'); ?>
            </th>
            <td>
                <?php echo esc_html(json_decode($transaction->network)->name); ?>
            </td>
        </tr>    
        <tr>
            <th scope="row">
                <?php echo esc_html__('Price: ', 'cryptopay'); ?>
            </th>
            <td>
                <?php echo esc_html($amount); ?> <?php echo esc_html($currency->symbol); ?>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <?php echo esc_html__('Status: ', 'cryptopay'); ?>
            </th>
            <td>
                <?php
                    echo esc_html__(ucfirst($transaction->status), 'cryptopay');
                ?>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <?php echo esc_html__('Transaction hash: ', 'cryptopay'); ?>
            </th>
            <td>
                <a href="<?php echo esc_url($transactionUrl); ?>" target="_blank" style="word-break: break-word">
                    <?php echo esc_html($transaction->hash); ?>
                </a>
            </td>
        </tr>
    </table>
</section>