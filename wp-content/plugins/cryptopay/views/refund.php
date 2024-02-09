
<?php if ($refundedPaymentAmount) : 
    echo '<br><br>' . esc_html(__('Refunded amount: ', 'cryptopay') . $refundedPaymentAmount . " " . $currency->symbol);
endif; ?>
<?php if ($manualRefund) : 
    echo '<br><br>' . __('Manuel refund: ', 'cryptopay') . esc_html__('A manual refund was detected, but unfortunately there is no data because it is manual.', 'cryptopay');
endif; ?>