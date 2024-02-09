<div id="cryptopay" style="text-align:center" data-loading="<?php echo esc_attr($loading) ? esc_html__('Loading...', 'cryptopay') : '';?>">
    <?php if ($loading)  { 
        $viewEcho('svg-loading');
    } ?>
</div>