<section class="cryptopay-payment-details">
    <h2 class="cryptopay-payment-details-title">
        <?php echo esc_html__('CryptoPay Payment Details', 'cryptopay'); ?>
    </h2>
    <table class="cryptopay-payment-details-table">
        <tr>
            <th scope="row">
                <?php echo esc_html__('Name: ', 'cryptopay'); ?>
            </th>
            <td>
                <?php echo esc_html($transaction->getNetwork()->getName()); ?>
            </td>
        </tr>    
        <?php 
        if ($order->getDiscountRate()) : ?>
            <tr>
                <th scope="row">
                    <?php echo esc_html__('Discounted Amount: ', 'cryptopay'); ?>
                </th>
                <td>
                    <?php echo esc_html($amount); ?> <?php echo esc_html($currency->getSymbol()); ?>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <?php echo esc_html__('Real Amount: ', 'cryptopay'); ?>
                </th>
                <td>
                    <?php echo esc_html($realAmount); ?> <?php echo esc_html($currency->getSymbol()); ?>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <?php echo esc_html__('Discount Rate: ', 'cryptopay'); ?>
                </th>
                <td>
                    <?php echo esc_html($order->getDiscountRate()); ?>%
                </td>
            </tr>
        <?php else: ?>
            <tr>
                <th scope="row">
                    <?php echo esc_html__('Amount: ', 'cryptopay'); ?>
                </th>
                <td>
                    <?php echo esc_html($amount); ?> <?php echo esc_html($currency->getSymbol()); ?>
                </td>
            </tr>
        <?php endif; ?>
        <?php if ($refundedPaymentAmount) : ?>
            <tr>
                <th scope="row">
                    <?php echo esc_html__('Refunded Amount: ', 'cryptopay'); ?>
                </th>
                <td>
                    <?php echo esc_html($refundedPaymentAmount); ?> <?php echo esc_html($currency->getSymbol()); ?>
                </td>
            </tr>
        <?php endif; ?>
        <?php if ($manualRefund) : ?>
            <tr>
                <th scope="row">
                    <?php echo esc_html__('Manuel Refund: ', 'cryptopay'); ?>
                </th>
                <td>
                    <?php echo esc_html__('A manual refund was detected, but unfortunately there is no data because it is manual.', 'cryptopay'); ?>
                </td>
            </tr>
        <?php endif; ?>
        <tr>
            <th scope="row">
                <?php echo esc_html__('Status: ', 'cryptopay'); ?>
            </th>
            <td>
                <?php
                    echo ucfirst(esc_html__(str_replace('-', ' ', ($transaction->getStatus()->getValue())), 'cryptopay'));
                ?>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <?php echo esc_html__('Transaction hash: ', 'cryptopay'); ?>
            </th>
            <td>
                <?php if ($transactionUrl) : ?>
                    <a href="<?php echo esc_url($transactionUrl); ?>" target="_blank" style="word-break: break-word">
                        <?php echo esc_html($transaction->getHash()); ?>
                    </a>
                <?php else: ?>
                    <?php echo esc_html($transaction->getHash()); ?>
                <?php endif; ?>
            </td>
        </tr>
    </table>
</section>