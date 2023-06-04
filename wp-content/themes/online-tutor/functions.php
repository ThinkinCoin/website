<?php
/**
 * Online Tutor functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Online Tutor
 */

include get_theme_file_path( 'vendor/wptrt/autoload/src/Online_Tutor_Loader.php' );

$Online_Tutor_Loader = new \WPTRT\Autoload\Online_Tutor_Loader();

$Online_Tutor_Loader->online_tutor_add( 'WPTRT\\Customize\\Section', get_theme_file_path( 'vendor/wptrt/customize-section-button/src' ) );

$Online_Tutor_Loader->online_tutor_register();

if ( ! function_exists( 'online_tutor_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function online_tutor_setup() {

		add_theme_support( 'woocommerce' );
		add_theme_support( "responsive-embeds" );
		add_theme_support( "align-wide" );
		add_theme_support( "wp-block-styles" );

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

        add_image_size('online-tutor-featured-header-image', 2000, 660, true);

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus( array(
            'primary' => esc_html__( 'Primary','online-tutor' ),
	        'footer'=> esc_html__( 'Footer Menu','online-tutor' ),
        ) );

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
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

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
	}
endif;
add_action( 'after_setup_theme', 'online_tutor_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function online_tutor_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'online_tutor_content_width', 1170 );
}
add_action( 'after_setup_theme', 'online_tutor_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function online_tutor_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'online-tutor' ),
		'id'            => 'sidebar',
		'description'   => esc_html__( 'Add widgets here.', 'online-tutor' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h5 class="widget-title">',
		'after_title'   => '</h5>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Front Page Sidebar', 'online-tutor' ),
		'id'            => 'front-sidebar',
		'description'   => esc_html__( 'Add widgets here.', 'online-tutor' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h5 class="widget-title">',
		'after_title'   => '</h5>',
	) );
}
add_action( 'widgets_init', 'online_tutor_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function online_tutor_scripts() {

	require_once get_theme_file_path( 'inc/wptt-webfont-loader.php' );

	wp_enqueue_style(
		'Montserrat',
		wptt_get_webfont_url( 'https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap' ),
		array(),
		'1.0'
	);

	wp_enqueue_style(
		'Poppins',
		wptt_get_webfont_url( 'https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap' ),
		
		array(),
		'1.0'
	);
	wp_enqueue_style(
		'Open Sans',
		wptt_get_webfont_url( 'https://fonts.googleapis.com/css2?family=Open Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap' ),
		
		array(),
		'1.0'
	);

	wp_enqueue_style( 'online-tutor-block-editor-style', get_theme_file_uri('/assets/css/block-editor-style.css') );

	// load bootstrap css
    wp_enqueue_style( 'bootstrap-css',get_template_directory_uri() . '/assets/css/bootstrap.css');

    wp_enqueue_style( 'owl.carousel-css',get_template_directory_uri() . '/assets/css/owl.carousel.css');

		wp_enqueue_style( 'online-tutor-style', get_stylesheet_uri() );

    wp_style_add_data('online-tutor-style', 'rtl', 'replace');

	// fontawesome
	wp_enqueue_style( 'fontawesome-style',get_template_directory_uri().'/assets/css/fontawesome/css/all.css' );

    wp_enqueue_script('online-tutor-theme-js',get_template_directory_uri() . '/assets/js/theme-script.js', array('jquery'), '', true );

    wp_enqueue_script('owl.carousel-js',get_template_directory_uri() . '/assets/js/owl.carousel.js', array('jquery'), '', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'online_tutor_scripts' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */

require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Enqueue theme color style.
 */
function online_tutor_theme_color() {

    $online_tutor_theme_color_css = '';
    $online_tutor_theme_color = get_theme_mod('online_tutor_theme_color');
    $online_tutor_theme_color_2 = get_theme_mod('online_tutor_theme_color_2');
    $online_tutor_preloader_bg_color = get_theme_mod('online_tutor_preloader_bg_color');
    $online_tutor_preloader_dot_1_color = get_theme_mod('online_tutor_preloader_dot_1_color');
    $online_tutor_preloader_dot_2_color = get_theme_mod('online_tutor_preloader_dot_2_color');

    if(get_theme_mod('online_tutor_preloader_bg_color') == '') {
			$online_tutor_preloader_bg_color = '#000';
	}
	if(get_theme_mod('online_tutor_preloader_dot_1_color') == '') {
		$online_tutor_preloader_dot_1_color = '#fff';
	}
	if(get_theme_mod('online_tutor_preloader_dot_2_color') == '') {
		$online_tutor_preloader_dot_2_color = '#ffa155';
	}

	$online_tutor_theme_color_css = '
		.top_header p a,.button-box a.box1,.button-box a.box2:hover,.slider-box-btn a,#button,.btn-primary,.box h5,.box:hover:before,#colophon,.social-link i:hover,.sidebar input[type="submit"], .sidebar button[type="submit"],.meta-info-box,.comment-respond input#submit,.post-navigation .nav-previous a:hover,.main-navigation .sub-menu > li > a, .main-navigation .sub-menu > li > .menu-item-link-return,.sidebar h5,.woocommerce .widget_shopping_cart .buttons a, .woocommerce.widget_shopping_cart .buttons a,.pro-button a, .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt,.woocommerce-account .woocommerce-MyAccount-navigation ul li,.woocommerce .woocommerce-ordering select,.toggle-nav i,.woocommerce a.added_to_cart,.sidebar .tagcloud a:hover {
			background: '.esc_attr($online_tutor_theme_color).';
		}
		.main-navigation .sub-menu > li > a:hover, .main-navigation .sub-menu > li > a:focus {
			background: '.esc_attr($online_tutor_theme_color).'!important;
		}
		a,.main-navigation .menu > li > a:hover,.top_header span,a.btn-text,.widget a:hover,.sidebar ul li a:hover, .main-navigation .sub-menu > li > .menu-item-link-return:hover,p.price, .woocommerce ul.products li.product .price, .woocommerce div.product p.price, .woocommerce div.product span.price,.woocommerce ul.products li.product .star-rating, .woocommerce .star-rating,.woocommerce-message::before, .woocommerce-info::before {
			color: '.esc_attr($online_tutor_theme_color).';
		}
		.btn-primary,.post-navigation .nav-previous a:hover,.woocommerce-message, .woocommerce-info,.main-navigation .sub-menu > li{
			border-color: '.esc_attr($online_tutor_theme_color).';
		}
		@media screen and (max-width:1000px){
	         .sidenav #site-navigation {
	        background: '.esc_attr($online_tutor_theme_color).';
	 		}
		}
		.top_header,.searchbox h3,.slider-box-btn a:hover,.btn-primary:hover,#button:hover,.searchbox form.search-from,.searchbox,.woocommerce a.button:hover,.woocommerce-account .woocommerce-MyAccount-navigation ul li:hover,.woocommerce button.button:hover,.woocommerce button.button.alt:hover,.woocommerce #respond input#submit:hover,.woocommerce a.button:hover,.woocommerce a.button.alt:hover,.woocommerce a.added_to_cart:hover,.sidenav .closebtn{
			background: '.esc_attr($online_tutor_theme_color_2).';
		}
		    h1,h2,h3,h4,h5,h6,a:hover,.button-box a.box2, .top_header p a:hover, .button-box a.box1:hover,.top_header i{
			color: '.esc_attr($online_tutor_theme_color_2).';
		}
		   .loading{
			background-color: '.esc_attr($online_tutor_preloader_bg_color).';
		 }
		 @keyframes loading {
		  0%,
		  100% {
		  	transform: translatey(-2.5rem);
		    background-color: '.esc_attr($online_tutor_preloader_dot_1_color).';
		  }
		  50% {
		  	transform: translatey(2.5rem);
		    background-color: '.esc_attr($online_tutor_preloader_dot_2_color).';
		  }
		}
	';
    wp_add_inline_style( 'online-tutor-style',$online_tutor_theme_color_css );

}
add_action( 'wp_enqueue_scripts', 'online_tutor_theme_color' );

/**
 * Enqueue S Header.
 */
function online_tutor_sticky_header() {

  $online_tutor_sticky_header = get_theme_mod('online_tutor_sticky_header');

  $online_tutor_custom_style= "";

  if($online_tutor_sticky_header != true){

    $online_tutor_custom_style .='.stick_header{';

      $online_tutor_custom_style .='position: static;';

    $online_tutor_custom_style .='}';
  }

  wp_add_inline_style( 'online-tutor-style',$online_tutor_custom_style );

}
add_action( 'wp_enqueue_scripts', 'online_tutor_sticky_header' );

/*radio button sanitization*/
function online_tutor_sanitize_choices( $input, $setting ) {
    global $wp_customize;
    $control = $wp_customize->get_control( $setting->id );
    if ( array_key_exists( $input, $control->choices ) ) {
        return $input;
    } else {
        return $setting->default;
    }
}

/*dropdown page sanitization*/
function online_tutor_sanitize_dropdown_pages( $page_id, $setting ) {
	$page_id = absint( $page_id );
	return ( 'publish' == get_post_status( $page_id ) ? $page_id : $setting->default );
}

function online_tutor_sanitize_phone_number( $phone ) {
	return preg_replace( '/[^\d+]/', '', $phone );
}

function online_tutor_sanitize_checkbox( $input ) {
	// Boolean check
	return ( ( isset( $input ) && true == $input ) ? true : false );
}

function online_tutor_gt_get_post_view() {
    $online_tutor_count = get_post_meta( get_the_ID(), 'post_views_count', true );
    return "$online_tutor_count views";
}
function online_tutor_gt_set_post_view() {
    $key = 'post_views_count';
    $post_id = get_the_ID();
    $online_tutor_count = (int) get_post_meta( $post_id, $key, true );
    $online_tutor_count++;
    update_post_meta( $post_id, $key, $online_tutor_count );
}
function online_tutor_gt_posts_column_views( $columns ) {
    $columns['post_views'] = 'Views';
    return $columns;
}
function online_tutor_gt_posts_custom_column_views( $column ) {
    if ( $column === 'post_views') {
        echo esc_html(online_tutor_gt_get_post_view());
    }
}
add_filter( 'manage_posts_columns', 'online_tutor_gt_posts_column_views' );
add_action( 'manage_posts_custom_column', 'online_tutor_gt_posts_custom_column_views' );

/**
 * Get CSS
 */

function online_tutor_getpage_css($hook) {
	if ( 'appearance_page_online-tutor-info' != $hook ) {
		return;
	}
	wp_enqueue_style( 'online-tutor-demo-style', get_template_directory_uri() . '/assets/css/demo.css' );
}
add_action( 'admin_enqueue_scripts', 'online_tutor_getpage_css' );

add_action('after_switch_theme', 'online_tutor_setup_options');

function online_tutor_setup_options () {
	wp_redirect( admin_url() . 'themes.php?page=online-tutor-info.php' );
}

if ( ! defined( 'ONLINE_TUTOR_CONTACT_SUPPORT' ) ) {
define('ONLINE_TUTOR_CONTACT_SUPPORT',__('https://wordpress.org/support/theme/online-tutor','online-tutor'));
}
if ( ! defined( 'ONLINE_TUTOR_REVIEW' ) ) {
define('ONLINE_TUTOR_REVIEW',__('https://wordpress.org/support/theme/online-tutor/reviews/#new-post','online-tutor'));
}
if ( ! defined( 'ONLINE_TUTOR_LIVE_DEMO' ) ) {
define('ONLINE_TUTOR_LIVE_DEMO',__('https://www.themagnifico.net/demo/online-tutor/','online-tutor'));
}
if ( ! defined( 'ONLINE_TUTOR_GET_PREMIUM_PRO' ) ) {
define('ONLINE_TUTOR_GET_PREMIUM_PRO',__('https://www.themagnifico.net/themes/online-tutor-wordpress-theme/','online-tutor'));
}
if ( ! defined( 'ONLINE_TUTOR_PRO_DOC' ) ) {
define('ONLINE_TUTOR_PRO_DOC',__('https://www.themagnifico.net/eard/wathiqa/online-tutor-pro-doc/','online-tutor'));
}

add_action('admin_menu', 'online_tutor_themepage');
function online_tutor_themepage(){
	$online_tutor_theme_info = add_theme_page( __('Theme Options','online-tutor'), __('Theme Options','online-tutor'), 'manage_options', 'online-tutor-info.php', 'online_tutor_info_page' );
}

function online_tutor_info_page() {
	$online_tutor_user = wp_get_current_user();
	$online_tutor_theme = wp_get_theme();
	?>
	<div class="wrap about-wrap online-tutor-add-css">
		<div>
			<h1>
				<?php esc_html_e('Welcome To ','online-tutor'); ?><?php echo esc_html( $online_tutor_theme ); ?>
			</h1>
			<div class="feature-section three-col">
				<div class="col">
					<div class="widgets-holder-wrap">
						<h3><?php esc_html_e("Contact Support", "online-tutor"); ?></h3>
						<p><?php esc_html_e("Thank you for trying Online Tutor , feel free to contact us for any support regarding our theme.", "online-tutor"); ?></p>
						<p><a target="_blank" href="<?php echo esc_url( ONLINE_TUTOR_CONTACT_SUPPORT ); ?>" class="button button-primary get">
							<?php esc_html_e("Contact Support", "online-tutor"); ?>
						</a></p>
					</div>
				</div>
				<div class="col">
					<div class="widgets-holder-wrap">
						<h3><?php esc_html_e("Checkout Premium", "online-tutor"); ?></h3>
						<p><?php esc_html_e("Our premium theme comes with extended features like demo content import , responsive layouts etc.", "online-tutor"); ?></p>
						<p><a target="_blank" href="<?php echo esc_url( ONLINE_TUTOR_GET_PREMIUM_PRO ); ?>" class="button button-primary get">
							<?php esc_html_e("Get Premium", "online-tutor"); ?>
						</a></p>
					</div>
				</div>
				<div class="col">
					<div class="widgets-holder-wrap">
						<h3><?php esc_html_e("Review", "online-tutor"); ?></h3>
						<p><?php esc_html_e("If You love Online Tutor theme then we would appreciate your review about our theme.", "online-tutor"); ?></p>
						<p><a target="_blank" href="<?php echo esc_url( ONLINE_TUTOR_REVIEW ); ?>" class="button button-primary get">
							<?php esc_html_e("Review", "online-tutor"); ?>
						</a></p>
					</div>
				</div>
			</div>
		</div>
		<hr>
		<h2><?php esc_html_e("Free Vs Premium","online-tutor"); ?></h2>
		<div class="online-tutor-button-container">
			<a target="_blank" href="<?php echo esc_url( ONLINE_TUTOR_PRO_DOC ); ?>" class="button button-primary get">
				<?php esc_html_e("Checkout Documentation", "online-tutor"); ?>
			</a>
			<a target="_blank" href="<?php echo esc_url( ONLINE_TUTOR_LIVE_DEMO ); ?>" class="button button-primary get">
				<?php esc_html_e("View Theme Demo", "online-tutor"); ?>
			</a>
		</div>
		<table class="wp-list-table widefat">
			<thead class="table-book">
				<tr>
					<th><strong><?php esc_html_e("Theme Feature", "online-tutor"); ?></strong></th>
					<th><strong><?php esc_html_e("Basic Version", "online-tutor"); ?></strong></th>
					<th><strong><?php esc_html_e("Premium Version", "online-tutor"); ?></strong></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><?php esc_html_e("Header Background Color", "online-tutor"); ?></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Custom Navigation Logo Or Text", "online-tutor"); ?></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Hide Logo Text", "online-tutor"); ?></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Premium Support", "online-tutor"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Fully SEO Optimized", "online-tutor"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Recent Posts Widget", "online-tutor"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Easy Google Fonts", "online-tutor"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Pagespeed Plugin", "online-tutor"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Only Show Header Image On Front Page", "online-tutor"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Show Header Everywhere", "online-tutor"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Custom Text On Header Image", "online-tutor"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Full Width (Hide Sidebar)", "online-tutor"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Only Show Upper Widgets On Front Page", "online-tutor"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Replace Copyright Text", "online-tutor"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Customize Upper Widgets Colors", "online-tutor"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Customize Navigation Color", "online-tutor"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Customize Post/Page Color", "online-tutor"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Customize Blog Feed Color", "online-tutor"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Customize Footer Color", "online-tutor"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Customize Sidebar Color", "online-tutor"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Customize Background Color", "online-tutor"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Importable Demo Content	", "online-tutor"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
			</tbody>
		</table>
		<div class="online-tutor-button-container">
			<a target="_blank" href="<?php echo esc_url( ONLINE_TUTOR_GET_PREMIUM_PRO ); ?>" class="button button-primary get">
				<?php esc_html_e("Go Premium", "online-tutor"); ?>
			</a>
		</div>
	</div>
	<?php
}
/**
 * Change number or products per row to 3
 */
add_filter('loop_shop_columns', 'online_tutor_loop_columns', 999);
if (!function_exists('online_tutor_loop_columns')) {
	function online_tutor_loop_columns() {
		return 3;
	}
}
