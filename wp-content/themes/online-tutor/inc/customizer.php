<?php
/**
 * Online Tutor Theme Customizer
 *
 * @link: https://developer.wordpress.org/themes/customize-api/customizer-objects/
 *
 * @package Online Tutor
 */

if ( ! defined( 'ONLINE_TUTOR_URL' ) ) {
    define( 'ONLINE_TUTOR_URL', esc_url( 'https://www.themagnifico.net/themes/online-tutor-wordpress-theme/', 'online-tutor') );
}
if ( ! defined( 'ONLINE_TUTOR_TEXT' ) ) {
    define( 'ONLINE_TUTOR_TEXT', __( 'Online Tutor Pro','online-tutor' ));
}
if ( ! defined( 'ONLINE_TUTOR_BUY_TEXT' ) ) {
    define( 'ONLINE_TUTOR_BUY_TEXT', __( 'Buy Online Tutor Pro','online-tutor' ));
}

use WPTRT\Customize\Section\Online_Tutor_Button;

add_action( 'customize_register', function( $manager ) {

    $manager->register_section_type( Online_Tutor_Button::class );

    $manager->add_section(
        new Online_Tutor_Button( $manager, 'online_tutor_pro', [
            'title'       => esc_html( ONLINE_TUTOR_TEXT, 'online-tutor' ),
            'priority'    => 0,
            'button_text' => __( 'GET PREMIUM', 'online-tutor' ),
            'button_url'  => esc_url( ONLINE_TUTOR_URL )
        ] )
    );

} );

// Load the JS and CSS.
add_action( 'customize_controls_enqueue_scripts', function() {

    $version = wp_get_theme()->get( 'Version' );

    wp_enqueue_script(
        'online-tutor-customize-section-button',
        get_theme_file_uri( 'vendor/wptrt/customize-section-button/public/js/customize-controls.js' ),
        [ 'customize-controls' ],
        $version,
        true
    );

    wp_enqueue_style(
        'online-tutor-customize-section-button',
        get_theme_file_uri( 'vendor/wptrt/customize-section-button/public/css/customize-controls.css' ),
        [ 'customize-controls' ],
        $version
    );

} );

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function online_tutor_customize_register($wp_customize){

    // Pro Version
    class Online_Tutor_Customize_Pro_Version extends WP_Customize_Control {
        public $type = 'pro_options';

        public function render_content() {
            echo '<span>For More <strong>'. esc_html( $this->label ) .'</strong>?</span>';
            echo '<a href="'. esc_url($this->description) .'" target="_blank">';
                echo '<span class="dashicons dashicons-info"></span>';
                echo '<strong> '. esc_html( ONLINE_TUTOR_BUY_TEXT,'online-tutor' ) .'<strong></a>';
            echo '</a>';
        }
    }

    // Custom Controls
    function Online_Tutor_sanitize_custom_control( $input ) {
        return $input;
    }

    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport = 'postMessage';

    $wp_customize->add_setting('online_tutor_logo_title', array(
        'default' => true,
        'sanitize_callback' => 'online_tutor_sanitize_checkbox'
    ));
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,'online_tutor_logo_title',array(
        'label'          => __( 'Enable Disable Title', 'online-tutor' ),
        'section'        => 'title_tagline',
        'settings'       => 'online_tutor_logo_title',
        'type'           => 'checkbox',
    )));

    $wp_customize->add_setting('online_tutor_theme_description', array(
        'default' => false,
        'sanitize_callback' => 'online_tutor_sanitize_checkbox'
    ));
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,'online_tutor_theme_description',array(
        'label'          => __( 'Enable Disable Tagline', 'online-tutor' ),
        'section'        => 'title_tagline',
        'settings'       => 'online_tutor_theme_description',
        'type'           => 'checkbox',
    )));


    $wp_customize->add_setting('online_tutor_logo_title', array(
        'default' => true,
        'sanitize_callback' => 'online_tutor_sanitize_checkbox'
    ));
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,'online_tutor_logo_title',array(
        'label'          => __( 'Enable Disable Title', 'online-tutor' ),
        'section'        => 'title_tagline',
        'settings'       => 'online_tutor_logo_title',
        'type'           => 'checkbox',
    )));

    // General Settings
     $wp_customize->add_section('online_tutor_general_settings',array(
        'title' => esc_html__('General Settings','online-tutor'),
        'priority'   => 1,
    ));

    $wp_customize->add_setting('online_tutor_preloader_hide', array(
        'default' => 0,
        'sanitize_callback' => 'online_tutor_sanitize_checkbox'
    ));
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,'online_tutor_preloader_hide',array(
        'label'          => __( 'Show Theme Preloader', 'online-tutor' ),
        'section'        => 'online_tutor_general_settings',
        'settings'       => 'online_tutor_preloader_hide',
        'type'           => 'checkbox',
    )));

    $wp_customize->add_setting( 'online_tutor_preloader_bg_color', array(
        'default' => '#000',
        'sanitize_callback' => 'sanitize_hex_color'
    ));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'online_tutor_preloader_bg_color', array(
        'label' => esc_html__('Preloader Background Color','online-tutor'),
        'section' => 'online_tutor_general_settings',
        'settings' => 'online_tutor_preloader_bg_color'
    )));

    $wp_customize->add_setting( 'online_tutor_preloader_dot_1_color', array(
        'default' => '#fff',
        'sanitize_callback' => 'sanitize_hex_color'
    ));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'online_tutor_preloader_dot_1_color', array(
        'label' => esc_html__('Preloader First Dot Color','online-tutor'),
        'section' => 'online_tutor_general_settings',
        'settings' => 'online_tutor_preloader_dot_1_color'
    )));

    $wp_customize->add_setting( 'online_tutor_preloader_dot_2_color', array(
        'default' => '#ffa155',
        'sanitize_callback' => 'sanitize_hex_color'
    ));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'online_tutor_preloader_dot_2_color', array(
        'label' => esc_html__('Preloader Second Dot Color','online-tutor'),
        'section' => 'online_tutor_general_settings',
        'settings' => 'online_tutor_preloader_dot_2_color'
    )));

    $wp_customize->add_setting('online_tutor_sticky_header', array(
        'default' => false,
        'sanitize_callback' => 'online_tutor_sanitize_checkbox'
    ));
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,'online_tutor_sticky_header',array(
        'label'          => __( 'Show Sticky Header', 'online-tutor' ),
        'section'        => 'online_tutor_general_settings',
        'settings'       => 'online_tutor_sticky_header',
        'type'           => 'checkbox',
    )));

    $wp_customize->add_setting('online_tutor_scroll_hide', array(
        'default' => false,
        'sanitize_callback' => 'online_tutor_sanitize_checkbox'
    ));
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,'online_tutor_scroll_hide',array(
        'label'          => __( 'Show Theme Scroll To Top', 'online-tutor' ),
        'section'        => 'online_tutor_general_settings',
        'settings'       => 'online_tutor_scroll_hide',
        'type'           => 'checkbox',
    )));

    // Pro Version
    $wp_customize->add_setting( 'pro_version_general_setting', array(
        'sanitize_callback' => 'Online_Tutor_sanitize_custom_control'
    ));
    $wp_customize->add_control( new Online_Tutor_Customize_Pro_Version ( $wp_customize,'pro_version_general_setting', array(
        'section'     => 'online_tutor_general_settings',
        'type'        => 'pro_options',
        'label'       => esc_html__( 'Customizer Options', 'online-tutor' ),
        'description' => esc_url( ONLINE_TUTOR_URL ),
        'priority'    => 100
    )));


    // Theme Color
    $wp_customize->add_section('online_tutor_color_option',array(
        'title' => esc_html__('Theme Color','online-tutor'),
        'priority' => 2,
    ));

    $wp_customize->add_setting( 'online_tutor_theme_color', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_hex_color'
    ));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'online_tutor_theme_color', array(
        'label' => esc_html__('First Color Option','online-tutor'),
        'section' => 'online_tutor_color_option',
        'settings' => 'online_tutor_theme_color'
    )));

    $wp_customize->add_setting( 'online_tutor_theme_color_2', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_hex_color'
    ));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'online_tutor_theme_color_2', array(
        'label' => esc_html__('Second Color Option','online-tutor'),
        'section' => 'online_tutor_color_option',
        'settings' => 'online_tutor_theme_color_2'
    )));

    // Pro Version
    $wp_customize->add_setting( 'pro_version_theme_color', array(
        'sanitize_callback' => 'Online_Tutor_sanitize_custom_control'
    ));
    $wp_customize->add_control( new Online_Tutor_Customize_Pro_Version ( $wp_customize,'pro_version_theme_color', array(
        'section'     => 'online_tutor_color_option',
        'type'        => 'pro_options',
        'label'       => esc_html__( 'Customizer Options', 'online-tutor' ),
        'description' => esc_url( ONLINE_TUTOR_URL ),
        'priority'    => 100
    )));

    // Top Header
    $wp_customize->add_section('online_tutor_top_header',array(
        'title' => esc_html__('Top Header','online-tutor'),
    ));

    $wp_customize->add_setting('online_tutor_top_header_setting', array(
        'default' => 0,
        'sanitize_callback' => 'online_tutor_sanitize_checkbox'
    ));
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,'online_tutor_top_header_setting',array(
        'label'          => __( 'Enable Disable Top Header', 'online-tutor' ),
        'section'        => 'online_tutor_top_header',
        'settings'       => 'online_tutor_top_header_setting',
        'type'           => 'checkbox',
        'priority' => 1,
    )));

    $wp_customize->add_setting('online_tutor_facebook_icon',array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('online_tutor_facebook_icon',array(
        'label' => esc_html__('Social Icon','online-tutor'),
        'section' => 'online_tutor_top_header',
        'setting' => 'online_tutor_facebook_icon',
        'type'  => 'text',
        'default' => 'fab fa-facebook-f',
        'description' =>  __('Select font awesome icons <a target="_blank" href="https://fontawesome.com/v5/search?m=free">Click Here</a> for select icon. for eg:-fab fa-facebook-f','online-tutor')
    ));

    $wp_customize->add_setting('online_tutor_facebook_url',array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));
    $wp_customize->add_control('online_tutor_facebook_url',array(
        'label' => esc_html__('Facebook Link','online-tutor'),
        'section' => 'online_tutor_top_header',
        'setting' => 'online_tutor_facebook_url',
        'type'  => 'url'
    ));

    $wp_customize->add_setting('online_tutor_twitter_icon',array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('online_tutor_twitter_icon',array(
        'label' => esc_html__('Social Icon','online-tutor'),
        'section' => 'online_tutor_top_header',
        'setting' => 'online_tutor_twitter_icon',
        'type'  => 'text',
        'default' => 'fab fa-twitter',
        'description' =>  __('Select font awesome icons <a target="_blank" href="https://fontawesome.com/v5/search?m=free">Click Here</a> for select icon. for eg:-fab fa-twitter','online-tutor')
    ));

    $wp_customize->add_setting('online_tutor_twitter_url',array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));
    $wp_customize->add_control('online_tutor_twitter_url',array(
        'label' => esc_html__('Twitter Link','online-tutor'),
        'section' => 'online_tutor_top_header',
        'setting' => 'online_tutor_twitter_url',
        'type'  => 'url'
    ));

     $wp_customize->add_setting('online_tutor_instagram_icon',array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('online_tutor_instagram_icon',array(
        'label' => esc_html__('Social Icon','online-tutor'),
        'section' => 'online_tutor_top_header',
        'setting' => 'online_tutor_instagram_icon',
        'type'  => 'text',
        'default' => 'fab fa-instagram',
        'description' =>  __('Select font awesome icons <a target="_blank" href="https://fontawesome.com/v5/search?m=free">Click Here</a> for select icon. for eg:-fab fa-instagram','online-tutor')
    ));

    $wp_customize->add_setting('online_tutor_intagram_url',array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));
    $wp_customize->add_control('online_tutor_intagram_url',array(
        'label' => esc_html__('Intagram Link','online-tutor'),
        'section' => 'online_tutor_top_header',
        'setting' => 'online_tutor_intagram_url',
        'type'  => 'url'
    ));

    $wp_customize->add_setting('online_tutor_linkedin_icon',array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('online_tutor_linkedin_icon',array(
        'label' => esc_html__('Social Icon','online-tutor'),
        'section' => 'online_tutor_top_header',
        'setting' => 'online_tutor_linkedin_icon',
        'type'  => 'text',
        'default' => 'fab fa-linkedin-in',
        'description' =>  __('Select font awesome icons <a target="_blank" href="https://fontawesome.com/v5/search?m=free">Click Here</a> for select icon. for eg:-fab fa-linkedin-in','online-tutor')
    ));

    $wp_customize->add_setting('online_tutor_linkedin_url',array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));
    $wp_customize->add_control('online_tutor_linkedin_url',array(
        'label' => esc_html__('Linkedin Link','online-tutor'),
        'section' => 'online_tutor_top_header',
        'setting' => 'online_tutor_linkedin_url',
        'type'  => 'url'
    ));

    $wp_customize->add_setting('online_tutor_pinterest_icon',array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('online_tutor_pinterest_icon',array(
        'label' => esc_html__('Social Icon','online-tutor'),
        'section' => 'online_tutor_top_header',
        'setting' => 'online_tutor_pinterest_icon',
        'type'  => 'text',
        'default' => 'fab fa-pinterest-p',
        'description' =>  __('Select font awesome icons <a target="_blank" href="https://fontawesome.com/v5/search?m=free">Click Here</a> for select icon. for eg:-fab fa-pinterest-p','online-tutor')
    ));

    $wp_customize->add_setting('online_tutor_pintrest_url',array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));
    $wp_customize->add_control('online_tutor_pintrest_url',array(
        'label' => esc_html__('Pinterest Link','online-tutor'),
        'section' => 'online_tutor_top_header',
        'setting' => 'online_tutor_pintrest_url',
        'type'  => 'url'
    ));

    $wp_customize->add_setting('online_tutor_ticket_text',array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('online_tutor_ticket_text',array(
        'label' => esc_html__('Ticket Text','online-tutor'),
        'section' => 'online_tutor_top_header',
        'setting' => 'online_tutor_ticket_text',
        'type'  => 'text'
    ));

    $wp_customize->add_setting('online_tutor_ticket_url',array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));
    $wp_customize->add_control('online_tutor_ticket_url',array(
        'label' => esc_html__('Ticket URL','online-tutor'),
        'section' => 'online_tutor_top_header',
        'setting' => 'online_tutor_ticket_url',
        'type'  => 'url'
    ));

    $wp_customize->add_setting('online_tutor_phone_number',array(
        'default' => '',
        'sanitize_callback' => 'online_tutor_sanitize_phone_number'
    ));
    $wp_customize->add_control('online_tutor_phone_number',array(
        'label' => esc_html__('Phone Number','online-tutor'),
        'section' => 'online_tutor_top_header',
        'setting' => 'online_tutor_phone_number',
        'type'  => 'text'
    ));

    $wp_customize->add_setting('online_tutor_email',array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('online_tutor_email',array(
        'label' => esc_html__('Email Address','online-tutor'),
        'section' => 'online_tutor_top_header',
        'setting' => 'online_tutor_email',
        'type'  => 'text'
    ));

    // Pro Version
    $wp_customize->add_setting( 'pro_version_top_header_setting', array(
        'sanitize_callback' => 'Online_Tutor_sanitize_custom_control'
    ));
    $wp_customize->add_control( new Online_Tutor_Customize_Pro_Version ( $wp_customize,'pro_version_top_header_setting', array(
        'section'     => 'online_tutor_top_header',
        'type'        => 'pro_options',
        'label'       => esc_html__( 'Customizer Options', 'online-tutor' ),
        'description' => esc_url( ONLINE_TUTOR_URL ),
        'priority'    => 100
    )));

    // Header
    $wp_customize->add_section('online_tutor_header',array(
        'title' => esc_html__('Header','online-tutor')
    ));

    $wp_customize->add_setting('online_tutor_search_on_off',array(
        'default' => 0,
        'sanitize_callback' => 'online_tutor_sanitize_checkbox'
    ));
    $wp_customize->add_control('online_tutor_search_on_off',array(
        'label' => esc_html__('On / Off Homepage Search','online-tutor'),
        'section' => 'online_tutor_header',
        'setting' => 'online_tutor_search_on_off',
        'type'  => 'checkbox'
    ));

    $wp_customize->add_setting('online_tutor_consultation_button1',array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('online_tutor_consultation_button1',array(
        'label' => esc_html__('Button 1 Text','online-tutor'),
        'section' => 'online_tutor_header',
        'setting' => 'online_tutor_consultation_button1',
        'type'  => 'text'
    ));

    $wp_customize->add_setting('online_tutor_button1_url',array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));
    $wp_customize->add_control('online_tutor_button1_url',array(
        'label' => esc_html__('Button 1 Link','online-tutor'),
        'section' => 'online_tutor_header',
        'setting' => 'online_tutor_button1_url',
        'type'  => 'url'
    ));

    $wp_customize->add_setting('online_tutor_consultation_button2',array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('online_tutor_consultation_button2',array(
        'label' => esc_html__('Button 2 Text','online-tutor'),
        'section' => 'online_tutor_header',
        'setting' => 'online_tutor_consultation_button2',
        'type'  => 'text'
    ));

    $wp_customize->add_setting('online_tutor_button2_url',array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));
    $wp_customize->add_control('online_tutor_button2_url',array(
        'label' => esc_html__('Button 2 Link','online-tutor'),
        'section' => 'online_tutor_header',
        'setting' => 'online_tutor_button2_url',
        'type'  => 'url'
    ));

    // Pro Version
    $wp_customize->add_setting( 'pro_version_header_setting', array(
        'sanitize_callback' => 'Online_Tutor_sanitize_custom_control'
    ));
    $wp_customize->add_control( new Online_Tutor_Customize_Pro_Version ( $wp_customize,'pro_version_header_setting', array(
        'section'     => 'online_tutor_header',
        'type'        => 'pro_options',
        'label'       => esc_html__( 'Customizer Options', 'online-tutor' ),
        'description' => esc_url( ONLINE_TUTOR_URL ),
        'priority'    => 100
    )));

    //Slider
    $wp_customize->add_section('online_tutor_top_slider',array(
        'title' => esc_html__('Slider Option','online-tutor')
    ));

    $wp_customize->add_setting('online_tutor_top_slider_setting', array(
        'default' => 0,
        'sanitize_callback' => 'online_tutor_sanitize_checkbox'
    ));
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,'online_tutor_top_slider_setting',array(
        'label'          => __( 'Enable Disable Slider', 'online-tutor' ),
        'section'        => 'online_tutor_top_slider',
        'settings'       => 'online_tutor_top_slider_setting',
        'type'           => 'checkbox',
    )));

    for ( $online_tutor_count = 1; $online_tutor_count <= 3; $online_tutor_count++ ) {
        $wp_customize->add_setting( 'online_tutor_top_slider_page' . $online_tutor_count, array(
            'default'           => '',
            'sanitize_callback' => 'online_tutor_sanitize_dropdown_pages'
        ) );
        $wp_customize->add_control( 'online_tutor_top_slider_page' . $online_tutor_count, array(
            'label'    => __( 'Select Slide Page', 'online-tutor' ),
            'section'  => 'online_tutor_top_slider',
            'type'     => 'dropdown-pages'
        ) );
    }

    // Pro Version
    $wp_customize->add_setting( 'pro_version_slider_setting', array(
        'sanitize_callback' => 'Online_Tutor_sanitize_custom_control'
    ));
    $wp_customize->add_control( new Online_Tutor_Customize_Pro_Version ( $wp_customize,'pro_version_slider_setting', array(
        'section'     => 'online_tutor_top_slider',
        'type'        => 'pro_options',
        'label'       => esc_html__( 'Customizer Options', 'online-tutor' ),
        'description' => esc_url( ONLINE_TUTOR_URL ),
        'priority'    => 100
    )));

    // Project Section
    $wp_customize->add_section('online_tutor_latest_project',array(
        'title' => esc_html__('Latest Online Lessons','online-tutor')
    ));

    $wp_customize->add_setting('online_tutor_other_project_setting', array(
        'default' => 0,
        'sanitize_callback' => 'online_tutor_sanitize_checkbox'
    ));
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,'online_tutor_other_project_setting',array(
        'label'          => __( 'Enable Disable Project', 'online-tutor' ),
        'section'        => 'online_tutor_latest_project',
        'settings'       => 'online_tutor_other_project_setting',
        'type'           => 'checkbox',
        'priority'       => 1,
    )));

    $wp_customize->add_setting('online_tutor_projects_title',array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('online_tutor_projects_title',array(
        'label' => esc_html__('Section Title','online-tutor'),
        'section' => 'online_tutor_latest_project',
        'setting' => 'online_tutor_projects_title',
        'type'  => 'text'
    ));

    $wp_customize->add_setting('online_tutor_project_loop',array(
        'default'   => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('online_tutor_project_loop',array(
        'label' => esc_html__('No of online lesson','online-tutor'),
        'section'   => 'online_tutor_latest_project',
        'type'      => 'number',
        'input_attrs' => array(
            'step'             => 1,
            'min'              => 0,
            'max'              => 9,
        ),
    ));

    $project_loop = get_theme_mod('online_tutor_project_loop');

    $online_tutor_args = array('numberposts' => -1);
    $post_list = get_posts($online_tutor_args);
    $i = 1;
    $pst_sls[]= __('Select','online-tutor');
    foreach ($post_list as $key => $p_post) {
        $pst_sls[$p_post->ID]=$p_post->post_title;
    }
    for ( $i = 1; $i <= $project_loop; $i++ ) {
        $wp_customize->add_setting('online_tutor_other_project_section'.$i,array(
            'sanitize_callback' => 'online_tutor_sanitize_choices',
        ));
        $wp_customize->add_control('online_tutor_other_project_section'.$i,array(
            'type'    => 'select',
            'choices' => $pst_sls,
            'label' => __('Select Post','online-tutor'),
            'section' => 'online_tutor_latest_project',
        ));

        $wp_customize->add_setting('online_tutor_projects_price'.$i, array(
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control('online_tutor_projects_price'.$i, array(
            'label' => __('Lessons Price', 'online-tutor'),
            'section' => 'online_tutor_latest_project',
            'type' => 'text',
        ));

    }
    wp_reset_postdata();
    // Pro Version
    $wp_customize->add_setting( 'pro_version_project_setting', array(
        'sanitize_callback' => 'Online_Tutor_sanitize_custom_control'
    ));
    $wp_customize->add_control( new Online_Tutor_Customize_Pro_Version ( $wp_customize,'pro_version_project_setting', array(
        'section'     => 'online_tutor_latest_project',
        'type'        => 'pro_options',
        'label'       => esc_html__( 'Customizer Options', 'online-tutor' ),
        'description' => esc_url( ONLINE_TUTOR_URL ),
        'priority'    => 100
    )));

    // Footer
    $wp_customize->add_section('online_tutor_site_footer_section', array(
        'title' => esc_html__('Footer', 'online-tutor'),
    ));

    $wp_customize->add_setting('online_tutor_footer_text_setting', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('online_tutor_footer_text_setting', array(
        'label' => __('Replace the footer text', 'online-tutor'),
        'section' => 'online_tutor_site_footer_section',
        'priority' => 1,
        'type' => 'text',
    ));

    // Pro Version
    $wp_customize->add_setting( 'pro_version_footer_setting', array(
        'sanitize_callback' => 'Online_Tutor_sanitize_custom_control'
    ));
    $wp_customize->add_control( new Online_Tutor_Customize_Pro_Version ( $wp_customize,'pro_version_footer_setting', array(
        'section'     => 'online_tutor_site_footer_section',
        'type'        => 'pro_options',
        'label'       => esc_html__( 'Customizer Options', 'online-tutor' ),
        'description' => esc_url( ONLINE_TUTOR_URL ),
        'priority'    => 100
    )));
}
add_action('customize_register', 'online_tutor_customize_register');

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function online_tutor_customize_partial_blogname(){
    bloginfo('name');
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function online_tutor_customize_partial_blogdescription(){
    bloginfo('description');
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function online_tutor_customize_preview_js(){
    wp_enqueue_script('online-tutor-customizer', esc_url(get_template_directory_uri()) . '/assets/js/customizer.js', array('customize-preview'), '20151215', true);
}
add_action('customize_preview_init', 'online_tutor_customize_preview_js');

/*
** Load dynamic logic for the customizer controls area.
*/
function online_tutor_panels_js() {
    wp_enqueue_style( 'online-tutor-customizer-layout-css', get_theme_file_uri( '/assets/css/customizer-layout.css' ) );
    wp_enqueue_script( 'online-tutor-customize-layout', get_theme_file_uri( '/assets/js/customize-layout.js' ), array(), '1.2', true );
}
add_action( 'customize_controls_enqueue_scripts', 'online_tutor_panels_js' );
