<?php
/**
 * Tutor Academy functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Tutor Academy
 */

if ( ! defined( 'ONLINE_TUTOR_URL' ) ) {
    define( 'ONLINE_TUTOR_URL', esc_url( 'https://www.themagnifico.net/themes/tutor-university-wordpress-theme/', 'tutor-academy') );
}
if ( ! defined( 'ONLINE_TUTOR_TEXT' ) ) {
    define( 'ONLINE_TUTOR_TEXT', __( 'Tutor Academy Pro','tutor-academy' ));
}

function tutor_academy_admin_scripts() {
    // demo CSS
    wp_enqueue_style( 'tutor-academy-demo-css', get_theme_file_uri( 'assets/css/demo.css' ) );
    }
add_action( 'admin_enqueue_scripts', 'tutor_academy_admin_scripts' );

function tutor_academy_enqueue_styles() {
    wp_enqueue_style( 'flatly-css', esc_url(get_template_directory_uri()) . '/assets/css/flatly.css');
    $tutor_academy_parentcss = 'online-tutor-style';
    $tutor_academy_theme = wp_get_theme(); wp_enqueue_style( $tutor_academy_parentcss, get_template_directory_uri() . '/style.css', array(), $tutor_academy_theme->parent()->get('Version'));
    wp_enqueue_style( 'tutor-academy-style', get_stylesheet_uri(), array( $tutor_academy_parentcss ), $tutor_academy_theme->get('Version'));

    wp_enqueue_script( 'comment-reply', '/wp-includes/js/comment-reply.min.js', array(), false, true );
}

add_action( 'wp_enqueue_scripts', 'tutor_academy_enqueue_styles' );

function tutor_academy_customize_register($wp_customize){

    $wp_customize->add_setting('tutor_academy_admission',array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('tutor_academy_admission',array(
        'label' => esc_html__('Addmission Text','tutor-academy'),
        'section' => 'online_tutor_top_header',
        'setting' => 'tutor_academy_admission',
        'type'  => 'text'
    ));

    $wp_customize->add_setting('tutor_academy_admission_link',array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));
    $wp_customize->add_control('tutor_academy_admission_link',array(
        'label' => esc_html__('Addmission Link','tutor-academy'),
        'section' => 'online_tutor_top_header',
        'setting' => 'tutor_academy_admission_link',
        'type'  => 'url'
    ));

    $wp_customize->add_setting('tutor_academy_research',array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('tutor_academy_research',array(
        'label' => esc_html__('Research Text','tutor-academy'),
        'section' => 'online_tutor_top_header',
        'setting' => 'tutor_academy_research',
        'type'  => 'text'
    ));

    $wp_customize->add_setting('tutor_academy_research_link',array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));
    $wp_customize->add_control('tutor_academy_research_link',array(
        'label' => esc_html__('Research Link','tutor-academy'),
        'section' => 'online_tutor_top_header',
        'setting' => 'tutor_academy_research_link',
        'type'  => 'url'
    ));


    $wp_customize->add_setting('tutor_academy_faq',array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('tutor_academy_faq',array(
        'label' => esc_html__('FAQs Text','tutor-academy'),
        'section' => 'online_tutor_top_header',
        'setting' => 'tutor_academy_faq',
        'type'  => 'text'
    ));

    $wp_customize->add_setting('tutor_academy_faq_link',array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));
    $wp_customize->add_control('tutor_academy_faq_link',array(
        'label' => esc_html__('FAQs Link','tutor-academy'),
        'section' => 'online_tutor_top_header',
        'setting' => 'tutor_academy_faq_link',
        'type'  => 'url'
    ));
}
add_action('customize_register', 'tutor_academy_customize_register');

if ( ! function_exists( 'tutor_academy_setup' ) ) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function tutor_academy_setup() {

        add_theme_support( 'responsive-embeds' );

        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support( 'title-tag' );

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support( 'post-thumbnails' );

        add_image_size('tutor-academy-featured-header-image', 2000, 660, true);

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         * to output valid HTML5.
         */
        add_theme_support( 'html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ) );

        // Set up the WordPress core custom background feature.
        add_theme_support( 'custom-background', apply_filters( 'online_tutor_custom_background_args', array(
            'default-color' => '',
            'default-image' => '',
        ) ) );

        /**
         * Add support for core custom logo.
         *
         * @link https://codex.wordpress.org/Theme_Logo
         */
        add_theme_support( 'custom-logo', array(
            'height'      => 50,
            'width'       => 50,
            'flex-width'  => true,
        ) );

        add_editor_style( array( '/editor-style.css' ) );

        add_theme_support( 'align-wide' );

        add_theme_support( 'wp-block-styles' );
    }
endif;
add_action( 'after_setup_theme', 'tutor_academy_setup' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function tutor_academy_widgets_init() {
        register_sidebar( array(
        'name'          => esc_html__( 'Sidebar', 'tutor-academy' ),
        'id'            => 'sidebar',
        'description'   => esc_html__( 'Add widgets here.', 'tutor-academy' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h5 class="widget-title">',
        'after_title'   => '</h5>',
    ) );
}
add_action( 'widgets_init', 'tutor_academy_widgets_init' );

function tutor_academy_remove_customize_register() {
    global $wp_customize;
    $wp_customize->remove_section( 'online_tutor_color_option' );

    $wp_customize->remove_setting( 'online_tutor_ticket_url' );
    $wp_customize->remove_control( 'online_tutor_ticket_url' );

    $wp_customize->remove_setting( 'online_tutor_phone_number' );
    $wp_customize->remove_control( 'online_tutor_phone_number' );

    $wp_customize->remove_setting( 'online_tutor_email' );
    $wp_customize->remove_control( 'online_tutor_email' );

    $wp_customize->remove_setting( 'online_tutor_consultation_button2' );
    $wp_customize->remove_control( 'online_tutor_consultation_button2' );

    $wp_customize->remove_setting( 'online_tutor_button2_url' );
    $wp_customize->remove_control( 'online_tutor_button2_url' );
}
add_action( 'customize_register', 'tutor_academy_remove_customize_register', 11 );

if ( ! defined( 'ONLINE_TUTOR_CONTACT_SUPPORT' ) ) {
define('ONLINE_TUTOR_CONTACT_SUPPORT',__('https://wordpress.org/support/theme/tutor-academy','tutor-academy'));
}
if ( ! defined( 'ONLINE_TUTOR_REVIEW' ) ) {
define('ONLINE_TUTOR_REVIEW',__('https://wordpress.org/support/theme/tutor-academy/reviews/#new-post','tutor-academy'));
}
if ( ! defined( 'ONLINE_TUTOR_LIVE_DEMO' ) ) {
define('ONLINE_TUTOR_LIVE_DEMO',__('https://www.themagnifico.net/demo/tutor-academy/','tutor-academy'));
}
if ( ! defined( 'ONLINE_TUTOR_GET_PREMIUM_PRO' ) ) {
define('ONLINE_TUTOR_GET_PREMIUM_PRO',__('https://www.themagnifico.net/themes/tutor-university-wordpress-theme/','tutor-academy'));
}
if ( ! defined( 'ONLINE_TUTOR_PRO_DOC' ) ) {
define('ONLINE_TUTOR_PRO_DOC',__('https://www.themagnifico.net/eard/wathiqa/tutor-academy-pro-doc/','tutor-academy'));
}
