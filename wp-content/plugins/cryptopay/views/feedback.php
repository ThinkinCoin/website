<?php
    use BeycanPress\CryptoPay\Helpers;
?>
<div class="wrap">
    <h1 class="wp-heading-inline">
        <?php echo esc_html__('Feedback', 'cryptopay'); ?>
    </h1>
    <hr class="wp-header-end">
    <br>
    <?php 
        if (isset($_POST['message'])) {
            if (Helpers::sendFeedbackMessage(sanitize_text_field($_POST['message']))) {
                echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__('Your feedback has been sent successfully.', 'cryptopay') . '</p></div>';
            } else {
                echo '<div class="notice notice-error is-dismissible"><p>' . esc_html__('An error occurred while sending your feedback.', 'cryptopay') . '</p></div>';
            }
        }
    ?>
    <div style="font-size: 34px; line-height: 38px; text-align:left"><?php echo esc_html__('Here you can let us know about the features that would be beneficial to everyone if added to the plugin.', 'cryptopay') ?></div><br><br>
    <form method="post">
        <textarea name="message" cols="30" rows="10" placeholder="<?php echo esc_html__('Please write your feedback here.', 'cryptopay'); ?>" style="max-width:100%; width:100%;height:300px;max-height:300px;min-height:300px;" required></textarea>
        <input type="submit" class="button button-primary" value="<?php echo esc_html__('Send feedback', 'cryptopay'); ?>">
    </form>
</div>