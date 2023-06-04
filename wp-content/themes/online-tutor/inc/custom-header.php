<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so ...
 *
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package Online Tutor
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses online_tutor_header_style()
 */
function online_tutor_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'online_tutor_custom_header_args', array(
		'width'                  => 1600,
		'height'                 => 250,
		'flex-height'            => true,
		'flex-width'            => true,
		'header-text'            => false,
		'wp-head-callback'       => 'online_tutor_header_style',
	) ) );
}
add_action( 'after_setup_theme', 'online_tutor_custom_header_setup' );

if ( ! function_exists( 'online_tutor_header_style' ) ) :
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see online_tutor_custom_header_setup().
	 */
	function online_tutor_header_style() {
		$header_text_color = get_header_textcolor(); ?>

		<style type="text/css">
			<?php
				//Check if user has defined any header image.
				if ( get_header_image() ) :
			?>
				.navigation_header,.page-template-home-template .navigation_header {
					background: url(<?php echo esc_url( get_header_image() ); ?>) no-repeat;
					background-position: center top;
				    background-size: cover;
				}
			<?php endif; ?>
		</style>

		<?php
	}
endif;
