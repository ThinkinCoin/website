<?php
/**
 * Educator Education functions and definitions
 *
 * @package Educator Education
 */
/**
 * Set the content width based on the theme's design and stylesheet.
 */
/* Breadcrumb Begin */
function educator_education_the_breadcrumb() {
	if (!is_home()) {
		echo '<a href="';
			echo esc_url( home_url() );
		echo '">';
			bloginfo('name');
		echo "</a> ";
		if (is_category() || is_single()) {
			the_category(',');
			if (is_single()) {
				echo "<span> ";
					the_title();
				echo "</span> ";
			}
		} elseif (is_page()) {
			echo "<span> ";
				the_title();
		}
	}
}
/* Theme Setup */
if (!function_exists('educator_education_setup')):

function educator_education_setup() {

	$GLOBALS['content_width'] = apply_filters('educator_education_content_width', 640);

	load_theme_textdomain( 'educator-education', get_template_directory() . '/languages' );
	add_theme_support('automatic-feed-links');
	add_theme_support('post-thumbnails');
	add_theme_support('woocommerce');
	add_theme_support( 'wc-product-gallery-slider' );
	add_theme_support('align-wide');
	add_theme_support('wp-block-styles');
	add_theme_support('title-tag');
	add_theme_support('custom-logo', array(
		'height'      => 250,
		'width'       => 250,
		'flex-width'  => true,
		'flex-height' => true,
	));
	add_image_size('educator-education-homepage-thumb', 250, 145, true);
	register_nav_menus(array(
		'primary' => __('Primary Menu', 'educator-education'),
	));

	add_theme_support('custom-background', array(
		'default-color' => 'ffffff',
	));

	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	add_theme_support('responsive-embeds');
	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style(array('css/editor-style.css', educator_education_font_url()));
}
endif;
add_action( 'after_setup_theme', 'educator_education_setup' );

// Theme Widgets Setup
function educator_education_widgets_init() {
	register_sidebar(array(
		'name'          => __('Blog Sidebar', 'educator-education'),
		'description'   => __('Appears on blog page sidebar', 'educator-education'),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	));

	register_sidebar(array(
		'name'          => __('Page Sidebar', 'educator-education'),
		'description'   => __('Appears on page sidebar', 'educator-education'),
		'id'            => 'sidebar-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	));

	register_sidebar(array(
		'name'          => __('Third Column Sidebar', 'educator-education'),
		'description'   => __('Appears on page sidebar', 'educator-education'),
		'id'            => 'sidebar-3',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	));

	//Footer widget areas
	$educator_education_widget_areas = get_theme_mod('educator_education_footer_widget_areas', '4');
	for ($i=1; $i<=$educator_education_widget_areas; $i++) {
		register_sidebar( array(
			'name'          => __( 'Footer Nav ', 'educator-education' ) . $i,
			'id'            => 'footer-' . $i,
			'description'   => '',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title text-start text-transform py-0 mb-2">',
			'after_title'   => '</h3>',
		) );
	}

	register_sidebar( array(
		'name'          => __( 'Shop Page Sidebar', 'educator-education' ),
		'description'   => __( 'Appears on shop page', 'educator-education' ),
		'id'            => 'woocommerce_sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Single Product Page Sidebar', 'educator-education' ),
		'description'   => __( 'Appears on shop page', 'educator-education' ),
		'id'            => 'woocommerce-single-sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}

add_action('widgets_init', 'educator_education_widgets_init');

/* Theme Font URL */
function educator_education_font_url(){
	$font_family = array(
		'PT+Sans:ital,wght@0,400;0,700;1,400;1,700',
		'Roboto:ital,wght@0,100;0,300;0,400;1,100;1,300;1,400',
		'Roboto+Condensed:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700',
		'Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800',
		'Overpass:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900',
		'Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900',
		'Playball',
		'Alegreya+Sans:ital,wght@0,100;0,300;0,400;0,500;0,700;0,800;0,900;1,100;1,300;1,400;1,500;1,700;1,800;1,900',
		'Julius+Sans+One',
		'Arsenal:ital,wght@0,400;0,700;1,400;1,700',
		'Slabo+27px',
		'Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900',
		'Overpass+Mono:wght@300;400;500;600;700',
		'Source+Sans+Pro:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700;1,900',
		'Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900',
		'Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900',
		'Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900',
		'Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700',
		'Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700',
		'Cabin:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700',
		'Arimo:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700',
		'Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900',
		'Quicksand:wght@300;400;500;600;700',
		'Padauk:wght@400;700',
		'Mulish:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;0,1000;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900;1,1000',
		'Inconsolata:wght@200;300;400;500;600;700;800;900',
		'Bitter:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900',
		'Pacifico',
		'Indie+Flower',
		'VT323',
		'Dosis:wght@200;300;400;500;600;700;800',
		'Frank+Ruhl+Libre:wght@300;400;500;700;900',
		'Fjalla+One',
		'Oxygen:wght@300;400;700',
		'Arvo:ital,wght@0,400;0,700;1,400;1,700',
		'Noto+Serif:ital,wght@0,400;0,700;1,400;1,700',
		'Lobster',
		'Crimson+Text:ital,wght@0,400;0,600;0,700;1,400;1,600;1,700',	
		'Yanone+Kaffeesatz:wght@200;300;400;500;600;700',
		'Anton',
		'Libre+Baskerville:ital,wght@0,400;0,700;1,400',
		'Bree+Serif',
		'Gloria+Hallelujah',
		'Josefin+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700',
		'Abril+Fatface',
		'Varela+Round',
		'Vampiro+One',
		'Shadows+Into+Light',
		'Cuprum:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700',
		'Rokkitt',
		'Vollkorn:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900',
		'Francois+One',
		'Orbitron:wght@400;500;600;700;800;900',
		'Patua+One',
		'Acme',
		'Satisfy',
		'Josefin+Slab:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700',
		'Quattrocento+Sans:ital,wght@0,400;0,700;1,400;1,700',
		'Architects+Daughter',
		'Russo+One',
		'Monda:wght@400;700',
		'Righteous',
		'Lobster+Two:ital,wght@0,400;0,700;1,400;1,700',
		'Hammersmith+One',
		'Courgette',
		'Permanent+Marker',
		'Cherry+Swash:wght@400;700',
		'Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700',
		'Poiret+One',
		'BenchNine:wght@300;400;700',
		'Economica:ital,wght@0,400;0,700;1,400;1,700',
		'Handlee',
		'Cardo:ital,wght@0,400;0,700;1,400',
		'Alfa+Slab+One',
		'Averia+Serif+Libre:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700',
		'Cookie',
		'Chewy',
		'Great+Vibes',
		'Coming+Soon',
		'Philosopher:ital,wght@0,400;0,700;1,400;1,700',
		'Days+One',
		'Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900',
		'Shrikhand',
		'Tangerine',
		'IM+Fell+English+SC',
		'Boogaloo',
		'Bangers',
		'Fredoka+One',
		'Bad+Script',
		'Volkhov:ital,wght@0,400;0,700;1,400;1,700',
		'Shadows+Into+Light+Two',
		'Marck+Script',
		'Sacramento',
		'Unica+One',
		'Noto+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900',
		'Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900'
	);
	
	$fonts_url = add_query_arg( array(
	'family' => implode( '&family=', $font_family ),
	'display' => 'swap',
	), 'https://fonts.googleapis.com/css2' );

	$contents = wptt_get_webfont_url( esc_url_raw( $fonts_url ) );
	return $contents;
}

//Display the related posts
if ( ! function_exists( 'educator_education_related_posts' ) ) {
	function educator_education_related_posts() {
		wp_reset_postdata();
		global $post;
		$args = array(
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
			'ignore_sticky_posts'    => 1,
			'orderby'                => 'rand',
			'post__not_in'           => array( $post->ID ),
			'posts_per_page'    => absint( get_theme_mod( 'educator_education_related_posts_number', '3' ) ),
		);
		// Categories
		if ( get_theme_mod( 'educator_education_related_posts_taxanomies_options', 'categories' ) == 'categories' ) {

			$cats = get_post_meta( $post->ID, 'related-posts', true );

			if ( ! $cats ) {
				$cats                 = wp_get_post_categories( $post->ID, array( 'fields' => 'ids' ) );
				$args['category__in'] = $cats;
			} else {
				$args['cat'] = $cats;
			}
		}
		// Tags
		if ( get_theme_mod( 'educator_education_related_posts_taxanomies_options', 'categories' ) == 'tags' ) {

			$tags = get_post_meta( $post->ID, 'related-posts', true );

			if ( ! $tags ) {
				$tags            = wp_get_post_tags( $post->ID, array( 'fields' => 'ids' ) );
				$args['tag__in'] = $tags;
			} else {
				$args['tag_slug__in'] = explode( ',', $tags );
			}
			if ( ! $tags ) {
				$break = true;
			}
		}
		$query = ! isset( $break ) ? new WP_Query( $args ) : new WP_Query();
		return $query;
	}
}

function educator_education_sanitize_dropdown_pages($page_id, $setting) {
	// Ensure $input is an absolute integer.
	$page_id = absint($page_id);
	// If $page_id is an ID of a published page, return it; otherwise, return the default.
	return ('publish' == get_post_status($page_id)?$page_id:$setting->default);
}

// radio button sanitization
function educator_education_sanitize_choices($input, $setting) {
	global $wp_customize;
	$control = $wp_customize->get_control($setting->id);
	if (array_key_exists($input, $control->choices)) {
		return $input;
	} else {
		return $setting->default;
	}
}

function educator_education_sanitize_phone_number( $phone ) {
	return preg_replace( '/[^\d+]/', '', $phone );
}

function educator_education_sanitize_checkbox( $input ) {
	return ( ( isset( $input ) && true == $input ) ? true : false );
}

function educator_education_sanitize_float( $input ) {
	return filter_var($input, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
}

function educator_education_sanitize_number_range( $number, $setting ) {
	$number = absint( $number );
	$atts = $setting->manager->get_control( $setting->id )->input_attrs;
	$min = ( isset( $atts['min'] ) ? $atts['min'] : $number );
	$max = ( isset( $atts['max'] ) ? $atts['max'] : $number );
	$step = ( isset( $atts['step'] ) ? $atts['step'] : 1 );
	return ( $min <= $number && $number <= $max && is_int( $number / $step ) ? $number : $setting->default );
}

// Excerpt Limit Begin
function educator_education_string_limit_words($string, $word_limit) {
	$words = explode(' ', $string, ($word_limit + 1));
	if(count($words) > $word_limit)
	array_pop($words);
	return implode(' ', $words);
}

// Change number or products per row to 3
add_filter('loop_shop_columns', 'educator_education_loop_columns');
if (!function_exists('educator_education_loop_columns')) {
	function educator_education_loop_columns() {
		$columns = get_theme_mod( 'educator_education_wooproducts_per_columns', 3 );
		return $columns; // 3 products per row
	}
}

//Change number of products that are displayed per page (shop page)
add_filter( 'loop_shop_per_page', 'educator_education_shop_per_page', 20 );
function educator_education_shop_per_page( $cols ) {
  	$cols = get_theme_mod( 'educator_education_wooproducts_per_page', 9 );
	return $cols;
}

define('EDUCATOR_EDUCATION_BUY_NOW',__('https://www.themeshopy.com/themes/educator-wordpress-theme/','educator-education'));
define('EDUCATOR_EDUCATION_LIVE_DEMO',__('https://www.themeshopy.com/educator-education-pro/','educator-education'));
define('EDUCATOR_EDUCATION_PRO_DOC',__('https://www.themeshopy.com/demo/docs/educator-education-pro/','educator-education'));
define('EDUCATOR_EDUCATION_FREE_DOC',__('https://themeshopy.com/demo/docs/free-educator-education/','educator-education'));
define('EDUCATOR_EDUCATION_CONTACT',__('https://wordpress.org/support/theme/educator-education/','educator-education'));
define('EDUCATOR_EDUCATION_CREDIT',__('https://www.themeshopy.com/themes/free-educator-wordpress-theme/', 'educator-education'));

if (!function_exists('educator_education_credit')) {
	function educator_education_credit() {
		echo "<a href=".esc_url(EDUCATOR_EDUCATION_CREDIT)." >".esc_html__('Educator WordPress Theme', 'educator-education')."</a>";
	}
}

// Theme enqueue scripts
function educator_education_scripts() {
	wp_enqueue_style('educator-education-font', educator_education_font_url(), array());
	// blocks-css
	wp_enqueue_style( 'educator-education-block-style', get_theme_file_uri('/css/blocks.css') );
	wp_enqueue_style('bootstrap-style', get_template_directory_uri().'/css/bootstrap.css');
	wp_enqueue_style('educator-education-basic-style', get_stylesheet_uri());
	wp_enqueue_style('educator-education-block-pattern-frontend', get_template_directory_uri().'/theme-block-pattern/css/block-pattern-frontend.css');
	wp_style_add_data('educator-education-basic-style', 'rtl', 'replace');

	wp_enqueue_style('educator-education-customcss', get_template_directory_uri().'/css/custom.css');
	wp_enqueue_style('owl-carousel-style', get_template_directory_uri().'/css/owl.carousel.css' );
	wp_enqueue_style('font-awesome-style', get_template_directory_uri().'/css/fontawesome-all.css');

	wp_enqueue_script('educator-education-customscripts-jquery', get_template_directory_uri().'/js/custom.js', array('jquery'));
	wp_enqueue_script('bootstrap-script', get_template_directory_uri().'/js/bootstrap.js', array('jquery'));
	wp_enqueue_script('jquery-superfish', get_template_directory_uri() . '/js/jquery.superfish.js', array('jquery') ,'',true);
	wp_enqueue_script('owl-carousel-script', get_template_directory_uri() . '/js/owl.carousel.js', array('jquery'), '', true);
	require get_parent_theme_file_path( '/inc/ts-color-pallete.php' );
	wp_add_inline_style( 'educator-education-basic-style',$educator_education_custom_css );
	require get_parent_theme_file_path( '/inc/typo-style.php' );
	wp_add_inline_style( 'educator-education-basic-style',$educator_education_typo_css );

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'educator_education_scripts');
/*** Enqueue block editor style */
function educator_education_block_editor_styles() {
	wp_enqueue_style( 'educator-education-font', educator_education_font_url(), array() );
    wp_enqueue_style( 'block-pattern-patterns-style-editor', get_theme_file_uri( '/theme-block-pattern/css/block-pattern-editor.css' ), false, '1.0', 'all' );
	wp_enqueue_style( 'font-awesome-css', get_template_directory_uri().'/css/fontawesome-all.css' );
    wp_enqueue_style( 'bootstrap-style', get_template_directory_uri().'/css/bootstrap.css' );
}
add_action( 'enqueue_block_editor_assets', 'educator_education_block_editor_styles' );


/* Custom header additions. */
require get_template_directory().'/inc/custom-header.php';

/* Custom template tags for this theme. */
require get_template_directory().'/inc/template-tags.php';

/* Customizer additions. */
require get_template_directory().'/inc/customizer.php';

/* TGM Plugin Activation */
require get_template_directory() .'/inc/tgm.php';

/* Get Started. */
require get_template_directory().'/inc/admin/admin.php';

/* Implement the block pattern */
require get_template_directory().'/theme-block-pattern/theme-block-pattern.php';

/* Webfonts */
require get_template_directory() . '/inc/wptt-webfont-loader.php';
