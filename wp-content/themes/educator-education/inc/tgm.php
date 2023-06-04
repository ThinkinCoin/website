<?php

	require get_template_directory() . '/inc/class-tgm-plugin-activation.php';
/**
 * Recommended plugins.
 */
function educator_education_register_recommended_plugins() {
	$plugins = array(
		array(
			'name'             => __( 'LearnPress – WordPress LMS Plugin', 'educator-education' ),
			'slug'             => 'learnpress',
			'required'         => false,
			'force_activation' => false,
		),
		
	);
	$config = array();
	tgmpa( $plugins, $config );

}
add_action( 'tgmpa_register', 'educator_education_register_recommended_plugins' );