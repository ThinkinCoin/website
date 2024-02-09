<?php

/**
 * Has functions related to Ultimate Member plugin.
 *
 * @package ethpress
 */

namespace losnappas\Ethpress;

defined('ABSPATH') || die;

use losnappas\Ethpress\Plugin;

if (\losnappas\Ethpress\ethpress_fs()->can_use_premium_code__premium_only()) {
    class UM
    {

        /**
         * This contains hook and filter assignments, etc.
         *
         * @since 0.1.0
         */
        public static function attach_hooks()
        {
            // do_action('ethpress_attach_hooks');

            // \losnappas\Ethpress\UM::attach_hooks();

            // //***< */ Hooks for Ultimate Members

            add_filter('um_predefined_fields_hook', [__CLASS__, 'predefined_fields_hook'], 20);
            add_filter('um_core_fields_hook', [__CLASS__, 'custom_modify_text'], 10, 1);
            add_action('um_admin_field_edit_hook_show_ethpress_button', [__CLASS__, 'admin_field_edit'], 10, 1);
            add_action('um_admin_field_edit_hook_eth_button_text', [__CLASS__, 'admin_field_eth_button_text_edit'], 10, 1);
            //add_filter('um_view_field', [__CLASS__, 'custom_um_view_field_value_type'], 10, 3);
            //add_filter('um_get_field__eth_blockchain_address', [__CLASS__, 'my_get_field'], 10, 1);
            add_filter('um_edit_field_login_blockchain_address', [__CLASS__, 'edit_field_html_login'], 10, 2);
            add_filter('um_edit_field_profile_blockchain_address', [__CLASS__, 'edit_field_html_profile'], 10, 2);
            add_filter('um_edit_field_register_blockchain_address', [__CLASS__, 'edit_field_html_register'], 10, 2);
            add_filter('um_edit_eth_blockchain_address_field_value', [__CLASS__, 'edit_field_value'], 10, 2);
            add_filter('um_edit_eth_blockchain_address_default_value', [__CLASS__, 'edit_field_value'], 10, 2);
            //add_action('ethpress_linked', [__CLASS__, 'ethpress_linked_hook'], 10, 2);

            //***> */ Hooks for Ultimate Members
        }


        // public static function ethpress_linked_hook($current_user, $provider)
        // {
        // }

        public static function predefined_fields_hook($predefined_fields)
        {
            //add blockchain address field
            $predefined_fields['eth_blockchain_address'] = array(
                'title' => __('EthPress Button', 'ethpress'),
                'metakey' => 'eth_blockchain_address',
                'type' => 'blockchain_address',
                'label' => __('EthPress Button', 'ethpress'),
                'required' => 1,
                'public' => 1,
                'editable' => 1,
                'min_chars' => 8,
                'max_chars' => 80,
                'show_ethpress_button' => 1
            );
            return $predefined_fields;
        }

        public static function edit_field_value($value, $key)
        { // default value for blockchain address field
            $user_id = get_current_user_id();
            // if (!$user_id) {
            // 	return $return_values['not_logged_in'];
            // }
            $address_data = Address::find_by_user($user_id);
            if (method_exists($address_data, 'get_address')) {
                $address = $address_data->get_address();
            }
            // if (empty($address)) {
            // }
            $value = $address;
            return $value;
        }


        public static function edit_field_html_login($output, $data)
        {
            return self::my_edit_field_html($output, $data, 'login');
        }

        public static function edit_field_html_profile($output, $data)
        {
            return self::my_edit_field_html($output, $data, 'profile');
        }

        public static function edit_field_html_register($output, $data)
        {
            return self::my_edit_field_html($output, $data, 'register');
        }

        public static function my_edit_field_html($output, $data, $mode)
        {
            //editing html field blockchain address
            if (is_array($data)) {
                /**
			//  * @var string      $in_row
			//  * @var boolean     $in_sub_row
			//  * @var boolean     $in_column
                 * @var string      $type
                 * @var string      $metakey
                 * @var int         $position
                 * @var string      $title
                 * @var string      $help
                 * @var array       $options
                 * @var string      $visibility
                 * @var string      $label
                 * @var string      $placeholder
                 * @var boolean     $public
                 * @var boolean     $editable
                 * @var string      $icon
                 * @var boolean     $in_group
                 * @var boolean     $required
                 * @var string      $validate
                 * @var string      $default
                 * @var string      $conditional
                 * @var string      $input
			//  * @var string      $js_format
			//  * @var string      $date_max
			//  * @var string      $date_min
			//  * @var string      $disabled_weekdays
			//  * @var string      $years_x
			//  * @var string      $years
			//  * @var string      $range
			//  * @var string      $intervals
			//  * @var string      $height
			//  * @var string      $spacing
			//  * @var string      $borderwidth
			//  * @var string      $borderstyle
			//  * @var string      $bordercolor
			//  * @var string      $divider_text
			//  * @var string      $crop_class
			//  * @var string      $crop_data
			//  * @var string      $modal_size
			//  * @var string      $ratio
			//  * @var string      $min_width
			//  * @var string      $min_height
			//  * @var string      $button_text
			//  * @var string      $max_size
			//  * @var string      $max_size_error
			//  * @var string      $extension_error
			//  * @var string      $allowed_types
			//  * @var string      $upload_text
			//  * @var string      $max_files_error
			//  * @var string      $upload_help_text
			//  * @var string      $min_size_error
			//  * @var string      $filter
			//  * @var string      $content
			//  * @var string      $max_entries
                 * @var string      $show_ethpress_button
                 * @var string      $eth_button_text
                 */
                extract($data);
            }

            // Stop return empty values build field attributes:
            $disabled = '';
            if ($visibility == 'view' && UM()->fields()->set_mode == 'register') {
                um_fetch_user(get_current_user_id());
                if (!um_user('can_edit_everyone')) {
                    $disabled = ' disabled="disabled" ';
                }
                um_fetch_user($_um_profile_id);
                if (isset($data['public']) && $data['public'] == '-2' && $data['roles']) {
                    $current_user_roles = um_user('roles');
                    if (!empty($current_user_roles) && count(array_intersect($current_user_roles, $data['roles'])) > 0) {
                        $disabled = '';
                    }
                }
            }
            if (!empty(UM()->fields()->editing) && UM()->fields()->set_mode == 'profile') {
                if (!UM()->roles()->um_user_can('can_edit_everyone')) {
                    if (isset($data['editable']) && $data['editable'] == 0) {
                        $disabled = ' disabled="disabled" ';
                    }
                }
            }
            if (!isset($data['autocomplete'])) {
                $autocomplete = 'off';
            }
            if (isset($data['classes'])) {
                $classes = explode(" ", $data['classes']);
            }
            if (isset($data['classes'])) {
                $classes = explode(" ", $data['classes']);
            }
            $output .= '<div ' . UM()->fields()->get_atts('eth_blockchain_address', $classes, $data['conditional'], $data) . '>';
            if ($mode == 'profile') {
                $output .= '<div class="um-field-area">';
                if (isset($data['label'])) {
                    $output .= UM()->fields()->field_label($data['label'], 'eth_blockchain_address', $data);
                }
                $output .= '</div>';
                wp_enqueue_style('um-form-field valid not-required');
                $output .= '<div class="um-field-area">';
                if (!empty($icon) && isset(UM()->fields()->field_icons) && UM()->fields()->field_icons == 'field') {
                    $output .= '<div class="um-field-icon"><i class="' . esc_attr($icon) . '"></i></div>';
                }
                $field_name = $metakey . UM()->form()->form_suffix;
                $field_value = htmlspecialchars(UM()->fields()->field_value($metakey, $default, $data));
                $output .= '<input ' . $disabled . 'readonly="readonly"' . ' autocomplete="' . esc_attr($autocomplete) . '" class="' . UM()->fields()->get_class($metakey, $data) . " eth-address-field" . '" type="text" name="' . esc_attr($field_name) . '" id="' . esc_attr($field_name) . '" value="' . esc_attr($field_value) . '" placeholder="' . esc_attr($placeholder) . '" data-validate="' . esc_attr($validate) . '" data-key="' . esc_attr($metakey) . '" />
			</div>';
                if (!empty($disabled)) {
                    $output .= UM()->fields()->disabled_hidden_field($field_name, $field_value);
                }
                if (UM()->fields()->is_error($metakey)) {
                    $output .= UM()->fields()->field_error(UM()->fields()->show_error($metakey));
                } else if (UM()->fields()->is_notice($metakey)) {
                    $output .= UM()->fields()->field_notice(UM()->fields()->show_notice($metakey));
                }
                $output .= '</div>';
            }

            if (isset($show_ethpress_button)) {
                $output .= '<div ' . UM()->fields()->get_atts('eth_blockchain_address', $classes, $data['conditional'], $data) . '>';
                switch ($mode) {
                    case 'login':
                        Plugin::login_enqueue_scripts_and_styles();
                        wp_enqueue_style('um-button um-alt');
                        if (isset($eth_button_text)) {
                            $output .= self::get_button_html("ethpress-metamask-login-button um-button um-alt", $eth_button_text);
                        } else {
                            $output .= self::get_button_html("ethpress-metamask-login-button um-button um-alt", "Login With a Crypto Wallet");
                        }
                        break;
                    case 'profile':
                        Plugin::login_enqueue_scripts_and_styles();
                        wp_enqueue_style('um-button um-alt');
                        if (isset($eth_button_text)) {
                            $output .= self::get_button_html("ethpress-metamask-login-button ethpress-button ethpress-button-secondary ethpress-button-large ethpress-account-linker-button woocommerce-Button button um-button um-alt", $eth_button_text);
                        } else {
                            $output .= self::get_button_html("ethpress-metamask-login-button ethpress-button ethpress-button-secondary ethpress-button-large ethpress-account-linker-button woocommerce-Button button um-button um-alt", "Link With a Crypto Wallet");
                        }
                        break;
                    case 'register':
                        Plugin::login_enqueue_scripts_and_styles();
                        wp_enqueue_style('um-button um-alt');
                        if (isset($eth_button_text)) {
                            $output .= self::get_button_html("ethpress-metamask-login-button um-button um-alt", $eth_button_text);
                        } else {
                            $output .= self::get_button_html("ethpress-metamask-login-button um-button um-alt", "Register With a Crypto Wallet");
                        }
                        break;
                }
                $output .= '</div>';
            }
            return $output;
        }

        public static function get_button_html($classes, $button_text)
        {
            return '<button class="' . $classes . '" type="button" name="metamask">' . $button_text . '</button>';
        }

        // public static function my_get_field($data)
        // {
        // 	return $data;
        // }

        // public static function custom_um_view_field_value_type($res, $data, $type)
        // {
        // 	return $res;
        // }

        public static function admin_field_edit($edit_mode_value)
        {
            // add checkbox to display ethpress button	
?>
            <p><label for="_show_ethpress_button"><?php _e('Show EthPress button?', 'ethpress') ?> <?php UM()->tooltip(__('Check to show the EthPress button', 'ethpress')); ?></label>
                <input type="checkbox" name="_show_ethpress_button" id="_show_ethpress_button" value="1" <?php checked(isset($edit_mode_value) ? $edit_mode_value : 0) ?> class="um-adm-conditional" data-cond1="1" data-cond1-show="_label_confirm_pass" data-cond1-hide="xxx" />
            </p>
        <?php

        }

        public static function admin_field_eth_button_text_edit($edit_mode_value)
        {
            // add input field to change ethpress button name
        ?>

            <p><label for="_eth_button_text"><?php _e('The EthPess button label', 'ethpress') ?> <?php UM()->tooltip(__('The button label text', 'ethpress')); ?></label>
                <input type="text" name="_eth_button_text" id="_eth_button_text" value="<?php echo ($edit_mode_value) ? $edit_mode_value : ''; ?>" />
            </p>

<?php
        }

        public static function custom_modify_text($core_fields)
        {
            //Forming the field editor screen for the Blockchain Address field
            $core_fields['blockchain_address'] = array(
                'name' => __('Blockchain Address', 'ethpress'),
                //'col1' => array('_title', '_metakey', '_help', '_default', '_min_chars', '_visibility'),
                'col1' => array('_title', '_metakey', '_help', '_visibility'),
                'col2' => array('_label', '_placeholder', '_public', '_roles', '_validate', '_custom_validate', '_show_ethpress_button', '_eth_button_text'),
                'col3' => array('_required', '_icon'),
                'validate' => array(
                    '_title' => array(
                        'mode' => 'required',
                        'error' => __('Title is required', 'ethpress')
                    ),
                    '_metakey' => array(
                        'mode' => 'unique',
                    ),
                )
            );
            return $core_fields;
        }
    }
} else {
    class UM
    {

        /**
         * This contains hook and filter assignments, etc.
         *
         * @since 0.1.0
         */
        public static function attach_hooks()
        {
        }
    }
}
