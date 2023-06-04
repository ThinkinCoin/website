<?php
/**
 * @package Educator Education
 * @subpackage educator_education
 * @since educator-education 1.0
 * Setup the WordPress core custom header feature.
 *
 * @uses educator_education_header_style()
*/

function educator_education_custom_header_setup() {

	add_theme_support( 'custom-header', apply_filters( 'educator_education_custom_header_args', array(
		'default-text-color'     => 'fff',
		'header-text' 			 =>	false,
		'width'                  => 1400,
		'height'                 => 115,
		'flex-width'         	=> true,
        'flex-height'        	=> true,
		'wp-head-callback'       => 'educator_education_header_style',
	) ) );
}

add_action( 'after_setup_theme', 'educator_education_custom_header_setup' );

if ( ! function_exists( 'educator_education_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see educator_education_custom_header_setup().
 */
add_action( 'wp_enqueue_scripts', 'educator_education_header_style' );
function educator_education_header_style() {
	//Check if user has defined any header image.
	if ( get_header_image() ) :
	$educator_education_custom_css = "
        .middle-header{
			background-image:url('".esc_url(get_header_image())."');
			background-position: center top;
			background-size: 100% 100%;
		}";
	   	wp_add_inline_style( 'educator-education-basic-style', $educator_education_custom_css );
	endif;
}
endif; // educator_education_header_style