<form>
    <?php 
        if (!empty($_GET)) {
            foreach ($_GET as $key => $value) { 
                ?> <input type="hidden" name="<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($value); ?>"/> <?php 
            }
        } 
    ?>

    <select name="code">
        <option value="all"><?php echo esc_html__('Filter by network', 'cryptopay'); ?></option>
        <?php foreach ($codes as $value) : ?>
            <option value="<?php echo esc_attr($value); ?>" <?php echo isset($_GET['code']) && $_GET['code'] == $value ? 'selected' : null ?>>
                <?php echo esc_html(ucfirst($value)); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button class="button" type="submit"><?php echo esc_html__('Filter', 'cryptopay'); ?></button>
    <a href="<?php echo esc_url($pageUrl) ?>" class="button"><?php echo esc_html__('Reset', 'cryptopay'); ?></a>

</form>