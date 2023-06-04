<?php
/**
 * Educator Education Theme Customizer
 *
 * @package Educator Education
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */

function educator_education_customize_register($wp_customize) {
	//add home page setting pannel
	$wp_customize->add_panel('educator_education_panel_id', array(
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => __('Theme Settings', 'educator-education'),
		'description'    => __('Description of what this panel does.', 'educator-education'),
	));	

	// font array
	$educator_education_font_array = array(
        '' => 'No Fonts',
        'Abril Fatface' => 'Abril Fatface',
        'Acme' => 'Acme',
        'Anton' => 'Anton',
        'Architects Daughter' => 'Architects Daughter',
        'Arimo' => 'Arimo',
        'Arsenal' => 'Arsenal', 
        'Arvo' => 'Arvo',
        'Alegreya' => 'Alegreya',
        'Alfa Slab One' => 'Alfa Slab One',
        'Averia Serif Libre' => 'Averia Serif Libre',
        'Bangers' => 'Bangers', 
        'Boogaloo' => 'Boogaloo',
        'Bad Script' => 'Bad Script',
        'Bitter' => 'Bitter',
        'Bree Serif' => 'Bree Serif',
        'BenchNine' => 'BenchNine', 
        'Cabin' => 'Cabin', 
        'Cardo' => 'Cardo',
        'Courgette' => 'Courgette',
        'Coming+Soon' => 'Coming+Soon',
        'Cherry Swash' => 'Cherry Swash',
        'Cormorant Garamond' => 'Cormorant Garamond',
        'Crimson Text' => 'Crimson Text',
        'Cuprum' => 'Cuprum', 
        'Cookie' => 'Cookie', 
        'Chewy' => 'Chewy', 
        'Days One' => 'Days One', 
        'Dosis' => 'Dosis',
        'Droid Sans' => 'Droid Sans',
        'Economica' => 'Economica',
        'Fredoka One' => 'Fredoka One',
        'Fjalla One' => 'Fjalla One',
        'Francois One' => 'Francois One',
        'Frank Ruhl Libre' => 'Frank Ruhl Libre',
        'Gloria Hallelujah' => 'Gloria Hallelujah',
        'Great Vibes' => 'Great Vibes',
        'Handlee' => 'Handlee', 
        'Hammersmith One' => 'Hammersmith One',
        'Inconsolata' => 'Inconsolata', 
        'Indie Flower' => 'Indie Flower', 
        'IM Fell English SC' => 'IM Fell English SC', 
        'Julius Sans One' => 'Julius Sans One',
        'Josefin Slab' => 'Josefin Slab', 
        'Josefin Sans' => 'Josefin Sans', 
        'Kanit' => 'Kanit', 
        'Lobster' => 'Lobster', 
        'Lato' => 'Lato',
        'Lora' => 'Lora', 
        'Libre Baskerville' =>'Libre Baskerville',
        'Lobster Two' => 'Lobster Two',
        'Merriweather' =>'Merriweather', 
        'Monda' => 'Monda',
        'Montserrat' => 'Montserrat',
        'Muli' => 'Muli', 
        'Marck Script' => 'Marck Script',
        'Noto Serif' => 'Noto Serif',
        'Noto Sans' => 'Noto Sans',
        'Open Sans' => 'Open Sans', 
        'Overpass' => 'Overpass',
        'Overpass Mono' => 'Overpass Mono',
        'Oxygen' => 'Oxygen', 
        'Orbitron' => 'Orbitron', 
        'Patua One' => 'Patua One', 
        'Pacifico' => 'Pacifico',
        'Padauk' => 'Padauk', 
        'Playball' => 'Playball',
        'Playfair Display' => 'Playfair Display', 
        'PT Sans' => 'PT Sans',
        'Philosopher' => 'Philosopher',
        'Permanent Marker' => 'Permanent Marker',
        'Poiret One' => 'Poiret One', 
        'Poppins' => 'Poppins',
        'Quicksand' => 'Quicksand', 
        'Quattrocento Sans' => 'Quattrocento Sans', 
        'Raleway' => 'Raleway', 
        'Rubik' => 'Rubik', 
        'Rokkitt' => 'Rokkitt', 
        'Roboto' => 'Roboto',
        'Roboto Condensed' => 'Roboto Condensed',
        'Russo One' => 'Russo One', 
        'Righteous' => 'Righteous', 
        'Slabo' => 'Slabo', 
        'Satisfy' => 'Satisfy',
        'Source Sans Pro' => 'Source Sans Pro', 
        'Shadows Into Light Two' =>'Shadows Into Light Two', 
        'Shadows Into Light' => 'Shadows Into Light', 
        'Sacramento' => 'Sacramento', 
        'Shrikhand' => 'Shrikhand', 
        'Tangerine' => 'Tangerine',
        'Unica One' => 'Unica One',
        'Ubuntu' => 'Ubuntu', 
        'VT323' => 'VT323', 
        'Varela Round' => 'Varela Round', 
        'Vampiro One' => 'Vampiro One',
        'Vollkorn' => 'Vollkorn',
        'Volkhov' => 'Volkhov', 
        'Yanone Kaffeesatz' => 'Yanone Kaffeesatz'
    );

	//Typography
	$wp_customize->add_section( 'educator_education_typography', array(
    	'title'      => __( 'Typography', 'educator-education' ),
		'priority'   => 30,
		'panel' => 'educator_education_panel_id'
	) );
	
	// This is Paragraph Color picker setting
	$wp_customize->add_setting( 'educator_education_paragraph_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'educator_education_paragraph_color', array(
		'label' => __('Paragraph Color', 'educator-education'),
		'section' => 'educator_education_typography',
		'settings' => 'educator_education_paragraph_color',
	)));

	//This is Paragraph FontFamily picker setting
	$wp_customize->add_setting('educator_education_paragraph_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'educator_education_sanitize_choices'
	));
	$wp_customize->add_control(
	    'educator_education_paragraph_font_family', array(
	    'section'  => 'educator_education_typography',
	    'label'    => __( 'Paragraph Fonts','educator-education'),
	    'type'     => 'select',
	    'choices'  => $educator_education_font_array,
	));

	$wp_customize->add_setting('educator_education_paragraph_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('educator_education_paragraph_font_size',array(
		'label'	=> __('Paragraph Font Size','educator-education'),
		'section'	=> 'educator_education_typography',
		'setting'	=> 'educator_education_paragraph_font_size',
		'type'	=> 'text'
	));

	// This is "a" Tag Color picker setting
	$wp_customize->add_setting( 'educator_education_atag_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'educator_education_atag_color', array(
		'label' => __('"a" Tag Color', 'educator-education'),
		'section' => 'educator_education_typography',
		'settings' => 'educator_education_atag_color',
	)));

	//This is "a" Tag FontFamily picker setting
	$wp_customize->add_setting('educator_education_atag_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'educator_education_sanitize_choices'
	));
	$wp_customize->add_control(
	    'educator_education_atag_font_family', array(
	    'section'  => 'educator_education_typography',
	    'label'    => __( '"a" Tag Fonts','educator-education'),
	    'type'     => 'select',
	    'choices'  => $educator_education_font_array,
	));

	// This is "a" Tag Color picker setting
	$wp_customize->add_setting( 'educator_education_li_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'educator_education_li_color', array(
		'label' => __('"li" Tag Color', 'educator-education'),
		'section' => 'educator_education_typography',
		'settings' => 'educator_education_li_color',
	)));

	//This is "li" Tag FontFamily picker setting
	$wp_customize->add_setting('educator_education_li_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'educator_education_sanitize_choices'
	));
	$wp_customize->add_control(
	    'educator_education_li_font_family', array(
	    'section'  => 'educator_education_typography',
	    'label'    => __( '"li" Tag Fonts','educator-education'),
	    'type'     => 'select',
	    'choices'  => $educator_education_font_array,
	));

	// This is H1 Color picker setting
	$wp_customize->add_setting( 'educator_education_h1_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'educator_education_h1_color', array(
		'label' => __('H1 Color', 'educator-education'),
		'section' => 'educator_education_typography',
		'settings' => 'educator_education_h1_color',
	)));

	//This is H1 FontFamily picker setting
	$wp_customize->add_setting('educator_education_h1_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'educator_education_sanitize_choices'
	));
	$wp_customize->add_control(
	    'educator_education_h1_font_family', array(
	    'section'  => 'educator_education_typography',
	    'label'    => __( 'H1 Fonts','educator-education'),
	    'type'     => 'select',
	    'choices'  => $educator_education_font_array,
	));

	//This is H1 FontSize setting
	$wp_customize->add_setting('educator_education_h1_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('educator_education_h1_font_size',array(
		'label'	=> __('H1 Font Size','educator-education'),
		'section'	=> 'educator_education_typography',
		'setting'	=> 'educator_education_h1_font_size',
		'type'	=> 'text'
	));

	// This is H2 Color picker setting
	$wp_customize->add_setting( 'educator_education_h2_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'educator_education_h2_color', array(
		'label' => __('h2 Color', 'educator-education'),
		'section' => 'educator_education_typography',
		'settings' => 'educator_education_h2_color',
	)));

	//This is H2 FontFamily picker setting
	$wp_customize->add_setting('educator_education_h2_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'educator_education_sanitize_choices'
	));
	$wp_customize->add_control(
	    'educator_education_h2_font_family', array(
	    'section'  => 'educator_education_typography',
	    'label'    => __( 'h2 Fonts','educator-education'),
	    'type'     => 'select',
	    'choices'  => $educator_education_font_array,
	));

	//This is H2 FontSize setting
	$wp_customize->add_setting('educator_education_h2_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('educator_education_h2_font_size',array(
		'label'	=> __('h2 Font Size','educator-education'),
		'section'	=> 'educator_education_typography',
		'setting'	=> 'educator_education_h2_font_size',
		'type'	=> 'text'
	));

	// This is H3 Color picker setting
	$wp_customize->add_setting( 'educator_education_h3_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'educator_education_h3_color', array(
		'label' => __('h3 Color', 'educator-education'),
		'section' => 'educator_education_typography',
		'settings' => 'educator_education_h3_color',
	)));

	//This is H3 FontFamily picker setting
	$wp_customize->add_setting('educator_education_h3_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'educator_education_sanitize_choices'
	));
	$wp_customize->add_control(
	    'educator_education_h3_font_family', array(
	    'section'  => 'educator_education_typography',
	    'label'    => __( 'h3 Fonts','educator-education'),
	    'type'     => 'select',
	    'choices'  => $educator_education_font_array,
	));

	//This is H3 FontSize setting
	$wp_customize->add_setting('educator_education_h3_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('educator_education_h3_font_size',array(
		'label'	=> __('h3 Font Size','educator-education'),
		'section'	=> 'educator_education_typography',
		'setting'	=> 'educator_education_h3_font_size',
		'type'	=> 'text'
	));

	// This is H4 Color picker setting
	$wp_customize->add_setting( 'educator_education_h4_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'educator_education_h4_color', array(
		'label' => __('h4 Color', 'educator-education'),
		'section' => 'educator_education_typography',
		'settings' => 'educator_education_h4_color',
	)));

	//This is H4 FontFamily picker setting
	$wp_customize->add_setting('educator_education_h4_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'educator_education_sanitize_choices'
	));
	$wp_customize->add_control(
	    'educator_education_h4_font_family', array(
	    'section'  => 'educator_education_typography',
	    'label'    => __( 'h4 Fonts','educator-education'),
	    'type'     => 'select',
	    'choices'  => $educator_education_font_array,
	));

	//This is H4 FontSize setting
	$wp_customize->add_setting('educator_education_h4_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('educator_education_h4_font_size',array(
		'label'	=> __('h4 Font Size','educator-education'),
		'section'	=> 'educator_education_typography',
		'setting'	=> 'educator_education_h4_font_size',
		'type'	=> 'text'
	));

	// This is H5 Color picker setting
	$wp_customize->add_setting( 'educator_education_h5_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'educator_education_h5_color', array(
		'label' => __('h5 Color', 'educator-education'),
		'section' => 'educator_education_typography',
		'settings' => 'educator_education_h5_color',
	)));

	//This is H5 FontFamily picker setting
	$wp_customize->add_setting('educator_education_h5_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'educator_education_sanitize_choices'
	));
	$wp_customize->add_control(
	    'educator_education_h5_font_family', array(
	    'section'  => 'educator_education_typography',
	    'label'    => __( 'h5 Fonts','educator-education'),
	    'type'     => 'select',
	    'choices'  => $educator_education_font_array,
	));

	//This is H5 FontSize setting
	$wp_customize->add_setting('educator_education_h5_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('educator_education_h5_font_size',array(
		'label'	=> __('h5 Font Size','educator-education'),
		'section'	=> 'educator_education_typography',
		'setting'	=> 'educator_education_h5_font_size',
		'type'	=> 'text'
	));

	// This is H6 Color picker setting
	$wp_customize->add_setting( 'educator_education_h6_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'educator_education_h6_color', array(
		'label' => __('h6 Color', 'educator-education'),
		'section' => 'educator_education_typography',
		'settings' => 'educator_education_h6_color',
	)));

	//This is H6 FontFamily picker setting
	$wp_customize->add_setting('educator_education_h6_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'educator_education_sanitize_choices'
	));
	$wp_customize->add_control(
	    'educator_education_h6_font_family', array(
	    'section'  => 'educator_education_typography',
	    'label'    => __( 'h6 Fonts','educator-education'),
	    'type'     => 'select',
	    'choices'  => $educator_education_font_array,
	));

	//This is H6 FontSize setting
	$wp_customize->add_setting('educator_education_h6_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('educator_education_h6_font_size',array(
		'label'	=> __('h6 Font Size','educator-education'),
		'section'	=> 'educator_education_typography',
		'setting'	=> 'educator_education_h6_font_size',
		'type'	=> 'text'
	));

  	$wp_customize->add_setting('educator_education_background_skin_mode',array(
        'default' => 'Transparent Background',
        'sanitize_callback' => 'educator_education_sanitize_choices'
	));
	$wp_customize->add_control('educator_education_background_skin_mode',array(
        'type' => 'select',
        'label' => __('Background Type','educator-education'),
        'section' => 'background_image',
        'choices' => array(
            'With Background' => __('With Background','educator-education'),
            'Transparent Background' => __('Transparent Background','educator-education'),
        ),
	) );

	// woocommerce section
	$wp_customize->add_setting('educator_education_show_related_products',array(
       'default' => true,
       'sanitize_callback'	=> 'educator_education_sanitize_checkbox'
    ));
    $wp_customize->add_control('educator_education_show_related_products',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Related Product','educator-education'),
       'section' => 'woocommerce_product_catalog',
    ));

	$wp_customize->add_setting('educator_education_show_wooproducts_border',array(
       'default' => false,
       'sanitize_callback'	=> 'educator_education_sanitize_checkbox'
    ));
    $wp_customize->add_control('educator_education_show_wooproducts_border',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Product Border','educator-education'),
       'section' => 'woocommerce_product_catalog',
    ));

    $wp_customize->add_setting( 'educator_education_wooproducts_per_columns' , array(
		'default'           => 3,
		'transport'         => 'refresh',
		'sanitize_callback' => 'educator_education_sanitize_choices',
	) );
	$wp_customize->add_control( 'educator_education_wooproducts_per_columns', array(
		'label'    => __( 'Display Product Per Columns', 'educator-education' ),
		'section'  => 'woocommerce_product_catalog',
		'type'     => 'select',
		'choices'  => array(
			'2' => '2',
			'3' => '3',
			'4' => '4',
			'5' => '5',
		),
	)  );

	$wp_customize->add_setting('educator_education_wooproducts_per_page',array(
		'default'	=> 9,
		'sanitize_callback'	=> 'educator_education_sanitize_float',
	));	
	$wp_customize->add_control('educator_education_wooproducts_per_page',array(
		'label'	=> __('Display Product Per Page','educator-education'),
		'section'	=> 'woocommerce_product_catalog',
		'type'		=> 'number'
	));

	$wp_customize->add_setting( 'educator_education_top_bottom_wooproducts_padding',array(
		'default' => '',
		'sanitize_callback'	=> 'educator_education_sanitize_float',
	));
	$wp_customize->add_control( 'educator_education_top_bottom_wooproducts_padding',	array(
		'label' => esc_html__( 'Top Bottom Product Padding','educator-education' ),
		'section' => 'woocommerce_product_catalog',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
		'type'		=> 'number'
	));

	$wp_customize->add_setting( 'educator_education_left_right_wooproducts_padding',array(
		'default' => '',
		'sanitize_callback'	=> 'educator_education_sanitize_float',
	));
	$wp_customize->add_control( 'educator_education_left_right_wooproducts_padding',	array(
		'label' => esc_html__( 'Right Left Product Padding','educator-education' ),
		'section' => 'woocommerce_product_catalog',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
		'type'		=> 'number'
	));

	$wp_customize->add_setting( 'educator_education_wooproducts_border_radius',array(
		'default' => 0,
		'sanitize_callback'	=> 'educator_education_sanitize_number_range',
	));
	$wp_customize->add_control('educator_education_wooproducts_border_radius',array(
		'label' => esc_html__( 'Product Border Radius','educator-education' ),
		'section' => 'woocommerce_product_catalog',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
		'type' => 'range'
	));

	$wp_customize->add_setting( 'educator_education_wooproducts_box_shadow',array(
		'default' => 0,
		'sanitize_callback'	=> 'educator_education_sanitize_number_range',
	));
	$wp_customize->add_control('educator_education_wooproducts_box_shadow',array(
		'label' => esc_html__( 'Product Box Shadow','educator-education' ),
		'section' => 'woocommerce_product_catalog',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
		'type'		=> 'range'
	));

	$wp_customize->add_setting('educator_education_products_navigation',array(
       'default' => 'Yes',
       'sanitize_callback'	=> 'educator_education_sanitize_choices'
    ));
    $wp_customize->add_control('educator_education_products_navigation',array(
       'type' => 'radio',
       'label' => __('Woocommerce Products Navigation','educator-education'),
       'choices' => array(
            'Yes' => __('Yes','educator-education'),
            'No' => __('No','educator-education'),
        ),
       'section' => 'woocommerce_product_catalog',
    ));

	$wp_customize->add_section('educator_education_product_button_section', array(
		'title'    => __('Product Button Settings', 'educator-education'),
		'priority' => null,
		'panel'    => 'woocommerce',
	));

	$wp_customize->add_setting( 'educator_education_top_bottom_product_button_padding',array(
		'default' => 10,
		'sanitize_callback'	=> 'educator_education_sanitize_float',
	));
	$wp_customize->add_control('educator_education_top_bottom_product_button_padding',	array(
		'label' => esc_html__( 'Product Button Top Bottom Padding','educator-education' ),
		'section' => 'educator_education_product_button_section',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
		'type'		=> 'number',
	));

	$wp_customize->add_setting( 'educator_education_left_right_product_button_padding',array(
		'default' => 16,
		'sanitize_callback'	=> 'educator_education_sanitize_float',
	));
	$wp_customize->add_control('educator_education_left_right_product_button_padding',array(
		'label' => esc_html__( 'Product Button Right Left Padding','educator-education' ),
		'section' => 'educator_education_product_button_section',
		'type'		=> 'number',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
	));

	$wp_customize->add_setting( 'educator_education_product_button_border_radius',array(
		'default' => 8,
		'sanitize_callback'	=> 'educator_education_sanitize_number_range',
	));
	$wp_customize->add_control('educator_education_product_button_border_radius',array(
		'label' => esc_html__( 'Product Button Border Radius','educator-education' ),
		'section' => 'educator_education_product_button_section',
		'type'		=> 'range',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
	));

	$wp_customize->add_section('educator_education_product_sale_section', array(
		'title'    => __('Product Sale Button Settings', 'educator-education'),
		'priority' => null,
		'panel'    => 'woocommerce',
	));

	$wp_customize->add_setting('educator_education_align_product_sale',array(
        'default' => 'Right',
        'sanitize_callback' => 'educator_education_sanitize_choices'
	));
	$wp_customize->add_control('educator_education_align_product_sale',array(
        'type' => 'radio',
        'label' => __('Product Sale Button Alignment','educator-education'),
        'section' => 'educator_education_product_sale_section',
        'choices' => array(
            'Right' => __('Right','educator-education'),
            'Left' => __('Left','educator-education'),
        ),
	) );

	$wp_customize->add_setting( 'educator_education_border_radius_product_sale',array(
		'default' => 0,
		'sanitize_callback'	=> 'educator_education_sanitize_float',
	));
	$wp_customize->add_control('educator_education_border_radius_product_sale', array(
        'label'  => __('Product Sale Button Border Radius','educator-education'),
        'section'  => 'educator_education_product_sale_section',
        'type'        => 'number',
        'input_attrs' => array(
        	'step'=> 1,
            'min' => 0,
            'max' => 50,
        )
    ) );

	$wp_customize->add_setting('educator_education_product_sale_font_size',array(
		'default'=> 14,
		'sanitize_callback'	=> 'educator_education_sanitize_float'
	));
	$wp_customize->add_control('educator_education_product_sale_font_size',array(
		'label'	=> __('Product Sale Button Font Size','educator-education'),
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'section'=> 'educator_education_product_sale_section',
		'type'=> 'number'
	));

	// sale button padding
	$wp_customize->add_setting( 'educator_education_sale_padding_top',array(
		'default' => 0,
		'sanitize_callback'	=> 'educator_education_sanitize_float',
	));
	$wp_customize->add_control( 'educator_education_sale_padding_top',	array(
		'label' => esc_html__( ' Product Sale Top Bottom Padding','educator-education' ),
		'section' => 'educator_education_product_sale_section',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
		'type'		=> 'number'
	));

	$wp_customize->add_setting( 'educator_education_sale_padding_left',array(
		'default' => 0,
		'sanitize_callback'	=> 'educator_education_sanitize_float',
	));
	$wp_customize->add_control( 'educator_education_sale_padding_left',	array(
		'label' => esc_html__( ' Product Sale Left Right Padding','educator-education' ),
		'section' => 'educator_education_product_sale_section',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
		'type'		=> 'number'
	));

	//Layouts
	$wp_customize->add_section('educator_education_left_right', array(
		'title'    => __('Layout Settings', 'educator-education'),
		'priority' => null,
		'panel'    => 'educator_education_panel_id',
	));

	$wp_customize->add_setting('educator_education_preloader_option',array(
       'default' => true,
       'sanitize_callback'	=> 'educator_education_sanitize_checkbox'
    ));
    $wp_customize->add_control('educator_education_preloader_option',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Preloader','educator-education'),
       'section' => 'educator_education_left_right'
    ));

    $wp_customize->add_setting('educator_education_preloader_type_options', array(
		'default'           => 'Preloader 1',
		'sanitize_callback' => 'educator_education_sanitize_choices',
	));
	$wp_customize->add_control('educator_education_preloader_type_options',array(
		'type'           => 'radio',
		'label'          => __('Preloader Type', 'educator-education'),
		'section'        => 'educator_education_left_right',
		'choices'        => array(
			'Preloader 1'  => __('Preloader 1', 'educator-education'),
			'Preloader 2' => __('Preloader 2', 'educator-education'),
		),
	));

    $wp_customize->add_setting( 'educator_education_loader_background_color_settings', array(
	    'default' => '#222',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'educator_education_loader_background_color_settings', array(
  		'label' => __('Preloader Background Color', 'educator-education'),
	    'section' => 'educator_education_left_right',
	    'settings' => 'educator_education_loader_background_color_settings',
  	)));

	$wp_customize->add_setting( 'educator_education_shop_page_sidebar',array(
		'default' => true,
		'sanitize_callback'	=> 'educator_education_sanitize_checkbox'
    ) );
    $wp_customize->add_control('educator_education_shop_page_sidebar',array(
    	'type' => 'checkbox',
       	'label' => __('Show / Hide Shop Page Sidebar','educator-education'),
		'section' => 'educator_education_left_right'
    ));

    // shop page sidebar alignment
    $wp_customize->add_setting('educator_education_shop_page_layout', array(
		'default'           => 'Right Sidebar',
		'sanitize_callback' => 'educator_education_sanitize_choices',
	));
	$wp_customize->add_control('educator_education_shop_page_layout',array(
		'type'           => 'radio',
		'label'          => __('Shop Page layout', 'educator-education'),
		'section'        => 'educator_education_left_right',
		'choices'        => array(
			'Left Sidebar'  => __('Left Sidebar', 'educator-education'),
			'Right Sidebar' => __('Right Sidebar', 'educator-education'),
		),
	));

	$wp_customize->add_setting( 'educator_education_wocommerce_single_page_sidebar',array(
		'default' => true,
		'sanitize_callback'	=> 'educator_education_sanitize_checkbox'
    ) );
    $wp_customize->add_control('educator_education_wocommerce_single_page_sidebar',array(
    	'type' => 'checkbox',
       	'label' => __('Show / Hide Single Product Page Sidebar','educator-education'),
		'section' => 'educator_education_left_right'
    ));
    
    // single product page sidebar alignment
    $wp_customize->add_setting('educator_education_single_product_page_layout', array(
		'default'           => 'Right Sidebar',
		'sanitize_callback' => 'educator_education_sanitize_choices',
	));
	$wp_customize->add_control('educator_education_single_product_page_layout',array(
		'type'           => 'radio',
		'label'          => __('Single product Page layout', 'educator-education'),
		'section'        => 'educator_education_left_right',
		'choices'        => array(
			'Left Sidebar'  => __('Left Sidebar', 'educator-education'),
			'Right Sidebar' => __('Right Sidebar', 'educator-education'),
		),
	));

    $wp_customize->add_setting( 'educator_education_single_page_breadcrumb',array(
		'default' => true,
      	'sanitize_callback'	=> 'educator_education_sanitize_checkbox'
    ) );
    $wp_customize->add_control('educator_education_single_page_breadcrumb',array(
    	'type' => 'checkbox',
        'label' => __( 'Show / Hide Single Page Breadcrumb','educator-education' ),
        'section' => 'educator_education_left_right'
    ));

	$wp_customize->add_setting('educator_education_layout_options', array(
		'default'           => 'Right Sidebar',
		'sanitize_callback' => 'educator_education_sanitize_choices',
	));
	$wp_customize->add_control('educator_education_layout_options',array(
		'type'           => 'radio',
		'label'          => __('Change Layouts', 'educator-education'),
		'section'        => 'educator_education_left_right',
		'choices'        => array(
			'Left Sidebar'  => __('Left Sidebar', 'educator-education'),
			'Right Sidebar' => __('Right Sidebar', 'educator-education'),
			'One Column'    => __('One Column', 'educator-education'),
			'Three Columns'    => __('Three Columns', 'educator-education'),
			'Four Columns'    => __('Four Columns', 'educator-education'),
			'Grid Layout'   => __('Grid Layout', 'educator-education')
		),
	));

	$wp_customize->add_setting('educator_education_single_page_sidebar_layout', array(
		'default'           => 'One Column',
		'sanitize_callback' => 'educator_education_sanitize_choices',
	));
	$wp_customize->add_control('educator_education_single_page_sidebar_layout',array(
		'type'           => 'radio',
		'label'          => __('Single Page Layouts', 'educator-education'),
		'section'        => 'educator_education_left_right',
		'choices'        => array(
			'Left Sidebar'  => __('Left Sidebar', 'educator-education'),
			'Right Sidebar' => __('Right Sidebar', 'educator-education'),
			'One Column'    => __('One Column', 'educator-education'),
		),
	));

	$wp_customize->add_setting('educator_education_single_post_sidebar_layout', array(
		'default'           => 'Right Sidebar', 
		'sanitize_callback' => 'educator_education_sanitize_choices',
	));
	$wp_customize->add_control('educator_education_single_post_sidebar_layout',array(
		'type'           => 'radio',
		'label'          => __('Single Post Layouts', 'educator-education'),
		'section'        => 'educator_education_left_right',
		'choices'        => array(
			'Left Sidebar'  => __('Left Sidebar', 'educator-education'),
			'Right Sidebar' => __('Right Sidebar', 'educator-education'),
			'One Column'    => __('One Column', 'educator-education'),
		),
	));

	$wp_customize->add_setting('educator_education_theme_options',array(
        'default' => 'Default',
        'sanitize_callback' => 'educator_education_sanitize_choices'
	));
	$wp_customize->add_control('educator_education_theme_options',array(
        'type' => 'radio',
        'label' => __('Container Box','educator-education'),
        'description' => __('Here you can change the Width layout. ','educator-education'),
        'section' => 'educator_education_left_right',
        'choices' => array(
            'Default' => __('Default','educator-education'),
            'Container' => __('Container','educator-education'),
            'Box Container' => __('Box Container','educator-education'),
        ),
	) );

	// Button
	$wp_customize->add_section( 'educator_education_theme_button', array(
		'title' => __('Button Option','educator-education'),
		'panel' => 'educator_education_panel_id',
	));

	$wp_customize->add_setting('educator_education_button_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'educator_education_sanitize_float',
	));
	$wp_customize->add_control('educator_education_button_padding_top_bottom',array(
		'label'	=> __('Top and Bottom Padding','educator-education'),
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'section'=> 'educator_education_theme_button',
		'type'=> 'number'
	));

	$wp_customize->add_setting('educator_education_button_padding_left_right',array(
		'default'=> '',
		'sanitize_callback'	=> 'educator_education_sanitize_float',
	));
	$wp_customize->add_control('educator_education_button_padding_left_right',array(
		'label'	=> __('Left and Right Padding','educator-education'),
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'section'=> 'educator_education_theme_button',
		'type'=> 'number'
	));

	$wp_customize->add_setting( 'educator_education_button_border_radius', array(
		'default'=> '',
		'sanitize_callback'	=> 'educator_education_sanitize_float',
	) );
	$wp_customize->add_control( 'educator_education_button_border_radius', array(
		'label'       => esc_html__( 'Button Border Radius','educator-education' ),
		'section'     => 'educator_education_theme_button',
		'type'        => 'number',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	// Social Icons
	$wp_customize->add_section('educator_education_social_icons',array(
		'title'	=> __('Social Icons','educator-education'),
		'description'	=> __('Add social icons.','educator-education'),
		'priority'	=> null,
		'panel' => 'educator_education_panel_id',
	));

	$wp_customize->add_setting('educator_education_instagram_url',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));	
	$wp_customize->add_control('educator_education_instagram_url',array(
		'label'	=> __('Add Instagram Link','educator-education'),
		'section'	=> 'educator_education_social_icons',
		'type'	=> 'url'
	));

	$wp_customize->add_setting('educator_education_twitter_url',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));	
	$wp_customize->add_control('educator_education_twitter_url',array(
		'label'	=> __('Add Twitter Link','educator-education'),
		'section'	=> 'educator_education_social_icons',
		'type'	=> 'url'
	));

	$wp_customize->add_setting('educator_education_tumblr_url',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));	
	$wp_customize->add_control('educator_education_tumblr_url',array(
		'label'	=> __('Add Tumblr Link','educator-education'),
		'section'	=> 'educator_education_social_icons',
		'type'	=> 'url'
	));

	$wp_customize->add_setting('educator_education_facebook_url',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));	
	$wp_customize->add_control('educator_education_facebook_url',array(
		'label'	=> __('Add Facebook Link','educator-education'),
		'section'	=> 'educator_education_social_icons',
		'type'	=> 'url'
	));

	//Header
	$wp_customize->add_section('educator_education_header',array(
		'title'	=> __('Header Section','educator-education'),
		'description'	=> __('Add topbar content','educator-education'),
		'priority'	=> null,
		'panel' => 'educator_education_panel_id',
	));

	$wp_customize->add_setting('educator_education_login_link',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('educator_education_login_link',array(
		'label'	=> __('Add Login Link','educator-education'),
		'section'	=> 'educator_education_header',
		'type'	=> 'text'
	));

	$wp_customize->add_setting('educator_education_location_text',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('educator_education_location_text',array(
		'label'	=> __('Add Location Text','educator-education'),
		'section'	=> 'educator_education_header',
		'type'	=> 'text'
	));

	$wp_customize->add_setting('educator_education_location_address',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('educator_education_location_address',array(
		'label'	=> __('Add Location Address','educator-education'),
		'section'	=> 'educator_education_header',
		'type'	=> 'text'
	));

	$wp_customize->add_setting('educator_education_phone_text',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('educator_education_phone_text',array(
		'label'	=> __('Add Phone Text','educator-education'),
		'section'	=> 'educator_education_header',
		'type'	=> 'text'
	));

	$wp_customize->add_setting('educator_education_phoneno',array(
		'default'	=> '',
		'sanitize_callback'	=> 'educator_education_sanitize_phone_number',
	));
	$wp_customize->add_control('educator_education_phoneno',array(
		'label'	=> __('Phone Number','educator-education'),
		'section'	=> 'educator_education_header',
		'type'	=> 'text'
	));

	$wp_customize->add_setting('educator_education_mail_text',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('educator_education_mail_text',array(
		'label'	=> __('Add Mail Text','educator-education'),
		'section'	=> 'educator_education_header',
		'type'	=> 'text'
	));

	$wp_customize->add_setting('educator_education_mail_address',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_email',
	));
	$wp_customize->add_control('educator_education_mail_address',array(
		'label'	=> __('Mail Address','educator-education'),
		'section'	=> 'educator_education_header',
		'type'	=> 'text'
	));

	//Menus Settings
	$wp_customize->add_section('educator_education_menus_settings',array(
		'title'	=> __('Menus Settings','educator-education'),
		'priority'	=> null,
		'panel' => 'educator_education_panel_id',
	));

	$wp_customize->add_setting('educator_education_text_tranform_menu',array(
		'default' => 'Uppercase',
		'sanitize_callback' => 'educator_education_sanitize_choices'
 	));
 	$wp_customize->add_control('educator_education_text_tranform_menu',array(
		'type' => 'radio',
		'label' => __('Menu Text Transform','educator-education'),
		'section' => 'educator_education_menus_settings',
		'choices' => array(
		   'Uppercase' => __('Uppercase','educator-education'),
		   'Lowercase' => __('Lowercase','educator-education'),
		   'Capitalize' => __('Capitalize','educator-education'),
		),
	) );

	$wp_customize->add_setting('educator_education_menus_font_size',array(
		'default'=> 12,
		'sanitize_callback'	=> 'educator_education_sanitize_float'
	));
	$wp_customize->add_control('educator_education_menus_font_size',array(
		'label'	=> __('Menus Font Size','educator-education'),
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'section'=> 'educator_education_menus_settings',
		'type'=> 'number'
	));

	$wp_customize->add_setting('educator_education_menu_weight',array(
		'default'=> '',
		'sanitize_callback'	=> 'educator_education_sanitize_choices',
	));
	$wp_customize->add_control('educator_education_menu_weight',array(
		'label'	=> __('Menus Font Weight ','educator-education'),
		'section'=> 'educator_education_menus_settings',
		'type' => 'select',
		'choices' => array(
            '100' => __('100','educator-education'),
            '200' => __('200','educator-education'),
            '300' => __('300','educator-education'),
            '400' => __('400','educator-education'),
            '500' => __('500','educator-education'),
            '600' => __('600','educator-education'),
            '700' => __('700','educator-education'),
            '800' => __('800','educator-education'),
            '900' => __('900','educator-education'),
        ),
	));

	$wp_customize->add_setting('educator_education_menus_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'educator_education_sanitize_float'
	));
	$wp_customize->add_control('educator_education_menus_padding',array(
		'label'	=> __('Menus Padding','educator-education'),
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'section'=> 'educator_education_menus_settings',
		'type'=> 'number'
	));

	$wp_customize->add_setting( 'educator_education_menu_color_settings', array(
	    'default' => '',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'educator_education_menu_color_settings', array(
  		'label' => __('Menu Color', 'educator-education'),
	    'section' => 'educator_education_menus_settings',
	    'settings' => 'educator_education_menu_color_settings',
  	)));

  	$wp_customize->add_setting( 'educator_education_menu_hover_color_settings', array(
	    'default' => '',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'educator_education_menu_hover_color_settings', array(
  		'label' => __('Menu Hover Color', 'educator-education'),
	    'section' => 'educator_education_menus_settings',
	    'settings' => 'educator_education_menu_hover_color_settings',
  	)));
  

  	$wp_customize->add_setting( 'educator_education_submenu_color_settings', array(
	    'default' => '',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'educator_education_submenu_color_settings', array(
  		'label' => __('Sub-menu Color', 'educator-education'),
	    'section' => 'educator_education_menus_settings',
	    'settings' => 'educator_education_submenu_color_settings',
  	)));

  	$wp_customize->add_setting( 'educator_education_submenu_hover_color_settings', array(
	    'default' => '',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'educator_education_submenu_hover_color_settings', array(
  		'label' => __('Sub-menu Hover Color', 'educator-education'),
	    'section' => 'educator_education_menus_settings',
	    'settings' => 'educator_education_submenu_hover_color_settings',
  	)));

	//Slider
	$wp_customize->add_section( 'educator_education_slider' , array(
    	'title'      => __( 'Slider Settings', 'educator-education' ),
		'priority'   => null,
		'panel' => 'educator_education_panel_id'
	) );

	$wp_customize->add_setting('educator_education_slider_hide',array(
       'default' => false,
       'sanitize_callback'	=> 'educator_education_sanitize_checkbox'
    ));
    $wp_customize->add_control('educator_education_slider_hide',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide slider','educator-education'),
       'section' => 'educator_education_slider'
    ));

    $wp_customize->add_setting('educator_education_slider_title_Show_hide',array(
       'default' => true,
       'sanitize_callback'	=> 'educator_education_sanitize_checkbox'
    ));
    $wp_customize->add_control('educator_education_slider_title_Show_hide',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Slider Title','educator-education'),
       'section' => 'educator_education_slider'
    ));

    $wp_customize->add_setting('educator_education_slider_content_Show_hide',array(
       'default' => true,
       'sanitize_callback'	=> 'educator_education_sanitize_checkbox'
    ));
    $wp_customize->add_control('educator_education_slider_content_Show_hide',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Slider Content','educator-education'),
       'section' => 'educator_education_slider'
    ));

	for ( $count = 1; $count <= 4; $count++ ) {

		$wp_customize->add_setting( 'educator_education_slider_page' . $count, array(
			'default'           => '',
			'sanitize_callback' => 'educator_education_sanitize_dropdown_pages'
		) );
		$wp_customize->add_control( 'educator_education_slider_page' . $count, array(
			'label'    => __( 'Select Slide Image Page', 'educator-education' ),
			'description'	=> __('Size of image should be 1600 x 633','educator-education'),
			'section'  => 'educator_education_slider',
			'type'     => 'dropdown-pages'
		) );
	}

	//Slider excerpt
	$wp_customize->add_setting( 'educator_education_slider_excerpt_length', array(
		'default'              => 20,
		'sanitize_callback'	=> 'educator_education_sanitize_float',
	) );
	$wp_customize->add_control( 'educator_education_slider_excerpt_length', array(
		'label'       => esc_html__( 'Slider Excerpt length','educator-education' ),
		'section'     => 'educator_education_slider',
		'type'        => 'number',
		'settings'    => 'educator_education_slider_excerpt_length',
		'input_attrs' => array(
			'step'             => 2,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting('educator_education_slider_overlay',array(
       'default' => true,
       'sanitize_callback'	=> 'educator_education_sanitize_checkbox'
    ));
    $wp_customize->add_control('educator_education_slider_overlay',array(
       'type' => 'checkbox',
       'label' => __('Home Page Slider Overlay','educator-education'),
		'description'    => __('This option will add colors over the slider.','educator-education'),
       'section' => 'educator_education_slider'
    ));

    $wp_customize->add_setting('educator_education_slider_image_overlay_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'educator_education_slider_image_overlay_color', array(
		'label'    => __('Home Page Slider Overlay Color', 'educator-education'),
		'section'  => 'educator_education_slider',
		'description'    => __('It will add the color overlay of the slider. To make it transparent, use the below option.','educator-education'),
		'settings' => 'educator_education_slider_image_overlay_color',
	)));

	//Opacity
	$wp_customize->add_setting('educator_education_slider_image_opacity',array(
      'default'              => 0.7,
      'sanitize_callback' => 'educator_education_sanitize_choices'
	));
	$wp_customize->add_control( 'educator_education_slider_image_opacity', array(
	'label'       => esc_html__( 'Slider Image Opacity','educator-education' ),
	'section'     => 'educator_education_slider',
	'type'        => 'select',
	'settings'    => 'educator_education_slider_image_opacity',
	'choices' => array(
		'0' =>  esc_attr('0','educator-education'),
		'0.1' =>  esc_attr('0.1','educator-education'),
		'0.2' =>  esc_attr('0.2','educator-education'),
		'0.3' =>  esc_attr('0.3','educator-education'),
		'0.4' =>  esc_attr('0.4','educator-education'),
		'0.5' =>  esc_attr('0.5','educator-education'),
		'0.6' =>  esc_attr('0.6','educator-education'),
		'0.7' =>  esc_attr('0.7','educator-education'),
		'0.8' =>  esc_attr('0.8','educator-education'),
		'0.9' =>  esc_attr('0.9','educator-education')
	),
	));

	$wp_customize->add_setting( 'educator_education_slider_speed_option',array(
		'default' => 3000,
		'sanitize_callback'=> 'educator_education_sanitize_number_range',
	));
	$wp_customize->add_control( 'educator_education_slider_speed_option',array(
		'label' => esc_html__( 'Slider Speed Option','educator-education' ),
		'section' => 'educator_education_slider',
		'type'        => 'range',
		'input_attrs' => array(
			'min' => 1000,
			'max' => 5000,
			'step' => 500,
		),
	));

	$wp_customize->add_setting('educator_education_slider_image_height',array(
		'default'=> __('550','educator-education'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('educator_education_slider_image_height',array(
		'label'	=> __('Slider Image Height','educator-education'),
		'section'=> 'educator_education_slider',
		'type'=> 'text'
	));

	$wp_customize->add_setting('educator_education_slider_button',array(
		'default'=> __('Read More','educator-education'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('educator_education_slider_button',array(
		'label'	=> __('Slider Button','educator-education'),
		'section'=> 'educator_education_slider',
		'type'=> 'text'
	));

	$wp_customize->add_setting('educator_education_top_bottom_slider_content_space',array(
		'default'=> '',
		'sanitize_callback'	=> 'educator_education_sanitize_float',
	));
	$wp_customize->add_control('educator_education_top_bottom_slider_content_space',array(
		'label'	=> __('Top Bottom Slider Content Space','educator-education'),
		'section'=> 'educator_education_slider',
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'type'=> 'number'
	));

	$wp_customize->add_setting('educator_education_left_right_slider_content_space',array(
		'default'=> '',
		'sanitize_callback'	=> 'educator_education_sanitize_float',
	));
	$wp_customize->add_control('educator_education_left_right_slider_content_space',array(
		'label'	=> __('Left Right Slider Content Space','educator-education'),
		'section'=> 'educator_education_slider',
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'type'=> 'number'
	));

	// Our Courses Settings
	$wp_customize->add_section('educator_education_services',array(
		'title' => __("Our Courses",'educator-education'),
		'panel' => 'educator_education_panel_id',
    ));

    $wp_customize->add_setting('educator_education_services_title',array(
        'default'=> '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('educator_education_services_title',array(
        'label' => __('Section Title','educator-education'),
        'section'=> 'educator_education_services',
        'setting'=> 'educator_education_services_title',
        'type'=> 'text'
    ));

    $args = array(
		'type'         => 'lp_course',
		'taxonomy'     => 'course_category'
	);
    $categories = get_categories($args);
    $cats = array();
    $i = 0;
    $cats[]='Select';	
    foreach($categories as $category){
        if($i==0){
            $default = $category->slug;
            $i++;
        }
        $cats[$category->slug] = $category->name;
    }

    $wp_customize->add_setting('educator_education_course_category',array(
    	'default'	=> 'select',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('educator_education_course_category',array(
        'type'    => 'select',
        'choices' => $cats,
        'label' => __('Select Course category','educator-education'),
        'section' => 'educator_education_services',
    ));

	//404 Page Setting
	$wp_customize->add_section('educator_education_404_page_setting',array(
		'title'	=> __('404 Page','educator-education'),
		'panel' => 'educator_education_panel_id',
	));	

	$wp_customize->add_setting('educator_education_title_404_page',array(
		'default'=> __('404','educator-education'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('educator_education_title_404_page',array(
		'label'	=> __('404 Page Title','educator-education'),
		'section'=> 'educator_education_404_page_setting',
		'type'=> 'text'
	));

	$wp_customize->add_setting('educator_education_content_404_page',array(
		'default'=>  __('We could not find the page you were looking for.','educator-education'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('educator_education_content_404_page',array(
		'label'	=> __('404 Page Content','educator-education'),
		'section'=> 'educator_education_404_page_setting',
		'type'=> 'text'
	));

	$wp_customize->add_setting('educator_education_button_404_page',array(
		'default'=> __('Go Back','educator-education'), 
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('educator_education_button_404_page',array(
		'label'	=> __('404 Page Button','educator-education'),
		'section'=> 'educator_education_404_page_setting',
		'type'=> 'text'
	));

	//Responsive Media Settings
	$wp_customize->add_section('educator_education_responsive_setting',array(
		'title'	=> __('Responsive Setting','educator-education'),
		'panel' => 'educator_education_panel_id',
	));

	$wp_customize->add_setting( 'educator_education_toggle_button_color_settings', array(
	    'default' => '',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'educator_education_toggle_button_color_settings', array(
  		'label' => __('Toggle Button Color', 'educator-education'),
	    'section' => 'educator_education_responsive_setting',
	    'settings' => 'educator_education_toggle_button_color_settings',
  	)));

	$wp_customize->add_setting('educator_education_responsive_slider',array(
       'default' => false,
       'sanitize_callback'	=> 'educator_education_sanitize_checkbox'
    ));
    $wp_customize->add_control('educator_education_responsive_slider',array(
       'type' => 'checkbox',
       'label' => __('Slider','educator-education'),
       'section' => 'educator_education_responsive_setting'
    ));

    $wp_customize->add_setting('educator_education_responsive_scroll',array(
       'default' => true,
       'sanitize_callback'	=> 'educator_education_sanitize_checkbox'
    ));
    $wp_customize->add_control('educator_education_responsive_scroll',array(
       'type' => 'checkbox',
       'label' => __('Scroll To Top','educator-education'),
       'section' => 'educator_education_responsive_setting'
    ));

	//Blog Post
	$wp_customize->add_section('educator_education_blog_post',array(
		'title'	=> __('Blog Page Settings','educator-education'),
		'panel' => 'educator_education_panel_id',
	));	

	$wp_customize->add_setting('educator_education_date_hide',array(
       'default' => true,
       'sanitize_callback'	=> 'educator_education_sanitize_checkbox'
    ));
    $wp_customize->add_control('educator_education_date_hide',array(
       'type' => 'checkbox',
       'label' => __('Post Date','educator-education'),
       'section' => 'educator_education_blog_post'
    ));

    $wp_customize->add_setting('educator_education_comment_hide',array(
       'default' => true,
       'sanitize_callback'	=> 'educator_education_sanitize_checkbox'
    ));
    $wp_customize->add_control('educator_education_comment_hide',array(
       'type' => 'checkbox',
       'label' => __('Comments','educator-education'),
       'section' => 'educator_education_blog_post'
    ));

    $wp_customize->add_setting('educator_education_author_hide',array(
       'default' => true,
       'sanitize_callback'	=> 'educator_education_sanitize_checkbox'
    ));
    $wp_customize->add_control('educator_education_author_hide',array(
       'type' => 'checkbox',
       'label' => __('Author','educator-education'),
       'section' => 'educator_education_blog_post'
    ));

    $wp_customize->add_setting('educator_education_time_hide',array(
       'default' => false,
       'sanitize_callback'	=> 'educator_education_sanitize_checkbox'
    ));
    $wp_customize->add_control('educator_education_time_hide',array(
       'type' => 'checkbox',
       'label' => __('Time','educator-education'),
       'section' => 'educator_education_blog_post'
    ));

    $wp_customize->add_setting('educator_education_show_featured_image_post',array(
       'default' => true,
       'sanitize_callback'	=> 'educator_education_sanitize_checkbox'
    ));
    $wp_customize->add_control('educator_education_show_featured_image_post',array(
       'type' => 'checkbox',
       'label' => __('Blog Post Image','educator-education'),
       'section' => 'educator_education_blog_post'
    ));

    $wp_customize->add_setting( 'educator_education_featured_img_border_radius', array(
		'default'=> 0,
		'sanitize_callback'	=> 'educator_education_sanitize_float',
	) );
	$wp_customize->add_control( 'educator_education_featured_img_border_radius', array(
		'label'       => esc_html__( 'Blog Post Image Border Radius','educator-education' ),
		'section'     => 'educator_education_blog_post',
		'type'        => 'number',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 0,
			'max'              => 100,
		),
	) );

	$wp_customize->add_setting( 'educator_education_featured_img_box_shadow',array(
		'default' => 0,
		'sanitize_callback'    => 'educator_education_sanitize_float',
	));
	$wp_customize->add_control('educator_education_featured_img_box_shadow',array(
		'label' => esc_html__( 'Blog Post Image Shadow','educator-education' ),
		'section' => 'educator_education_blog_post',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
		'type' => 'number'
	));

	$wp_customize->add_setting('educator_education_blog_post_description_option',array(
    	'default'   => 'Excerpt Content', 
        'sanitize_callback' => 'educator_education_sanitize_choices'
	));
	$wp_customize->add_control('educator_education_blog_post_description_option',array(
        'type' => 'radio',
        'label' => __('Post Description Length','educator-education'),
        'section' => 'educator_education_blog_post',
        'choices' => array(
            'No Content' => __('No Content','educator-education'),
            'Excerpt Content' => __('Excerpt Content','educator-education'),
            'Full Content' => __('Full Content','educator-education'),
        ),
	) );

    $wp_customize->add_setting( 'educator_education_excerpt_number', array(
		'default'              => 20,
		'sanitize_callback'	=> 'educator_education_sanitize_float',
	) );
	$wp_customize->add_control( 'educator_education_excerpt_number', array(
		'label'       => esc_html__( 'Excerpt length','educator-education' ),
		'section'     => 'educator_education_blog_post',
		'type'        => 'number',
		'settings'    => 'educator_education_excerpt_number',
		'input_attrs' => array(
			'step'             => 2,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting( 'educator_education_post_suffix_option', array(
		'default'   => __('...','educator-education'), 
		'sanitize_callback'	=> 'sanitize_text_field'
	) );
	$wp_customize->add_control( 'educator_education_post_suffix_option', array(
		'label'       => esc_html__( 'Post Excerpt Indicator Option','educator-education' ),
		'section'     => 'educator_education_blog_post',
		'type'        => 'text',
		'settings'    => 'educator_education_post_suffix_option',
	) );

	$wp_customize->add_setting('educator_education_button_text',array(
		'default'=> __('Read More','educator-education'), 
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('educator_education_button_text',array(
		'label'	=> __('Add Button Text','educator-education'),
		'section'=> 'educator_education_blog_post',
		'type'=> 'text'
	));

	$wp_customize->add_setting('educator_education_button_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'educator_education_sanitize_float'
	));
	$wp_customize->add_control('educator_education_button_font_size',array(
		'label'	=> __('Button Font Size','educator-education'),
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'section'=> 'educator_education_blog_post',
		'type'=> 'number'
	));

	$wp_customize->add_setting('educator_education_button_text_transform',array(
		'default' => 'Uppercase',
		'sanitize_callback' => 'educator_education_sanitize_choices'
 	));
 	$wp_customize->add_control('educator_education_button_text_transform',array(
		'type' => 'radio',
		'label' => __('Button Text Transform','educator-education'),
		'section' => 'educator_education_blog_post',
		'choices' => array(
		   'Uppercase' => __('Uppercase','educator-education'),
		   'Lowercase' => __('Lowercase','educator-education'),
		   'Capitalize' => __('Capitalize','educator-education'),
		),
	) );

	$wp_customize->add_setting( 'educator_education_metabox_separator_blog_post', array(
		'default'   => '',
		'sanitize_callback'	=> 'sanitize_text_field'
	) );
	$wp_customize->add_control( 'educator_education_metabox_separator_blog_post', array(
		'label'       => esc_html__( 'Meta Box Separator','educator-education' ),
		'input_attrs' => array(
            'placeholder' => __( 'Add Meta Separator. e.g.: "|", "/", etc.', 'educator-education' ),
        ),
		'section'     => 'educator_education_blog_post',
		'type'        => 'text',
		'settings'    => 'educator_education_metabox_separator_blog_post',
	) );

	$wp_customize->add_setting('educator_education_display_blog_page_post',array(
        'default' => 'In Box',
        'sanitize_callback' => 'educator_education_sanitize_choices'
	));
	$wp_customize->add_control('educator_education_display_blog_page_post',array(
        'type' => 'radio',
        'label' => __('Display Blog Page Post :','educator-education'),
        'section' => 'educator_education_blog_post',
        'choices' => array(
            'In Box' => __('In Box','educator-education'),
            'Without Box' => __('Without Box','educator-education'),
        ),
	) );

	$wp_customize->add_setting('educator_education_blog_post_pagination',array(
       'default' => true,
       'sanitize_callback'	=> 'educator_education_sanitize_checkbox'
    ));
    $wp_customize->add_control('educator_education_blog_post_pagination',array(
       'type' => 'checkbox',
       'label' => __('Pagination in Blog Page','educator-education'),
       'section' => 'educator_education_blog_post'
    ));

 	//Single Post Settings
	$wp_customize->add_section('educator_education_single_post',array(
		'title'	=> __('Single Post Settings','educator-education'),
		'panel' => 'educator_education_panel_id',
	));	

	$wp_customize->add_setting('educator_education_single_post_date_hide',array(
       'default' => true,
       'sanitize_callback'	=> 'educator_education_sanitize_checkbox'
    ));
    $wp_customize->add_control('educator_education_single_post_date_hide',array(
       'type' => 'checkbox',
       'label' => __('Single Post Date','educator-education'),
       'section' => 'educator_education_single_post'
    ));

    $wp_customize->add_setting('educator_education_single_post_author_hide',array(
       'default' => true,
       'sanitize_callback'	=> 'educator_education_sanitize_checkbox'
    ));
    $wp_customize->add_control('educator_education_single_post_author_hide',array(
       'type' => 'checkbox',
       'label' => __('Single Post Author','educator-education'),
       'section' => 'educator_education_single_post'
    ));

    $wp_customize->add_setting('educator_education_single_post_comment_hide',array(
       'default' => true,
       'sanitize_callback'	=> 'educator_education_sanitize_checkbox'
    ));
    $wp_customize->add_control('educator_education_single_post_comment_hide',array(
       'type' => 'checkbox',
       'label' => __('Single Post Comments','educator-education'),
       'section' => 'educator_education_single_post'
    ));

    $wp_customize->add_setting('educator_education_single_post_time_hide',array(
       'default' => false,
       'sanitize_callback'	=> 'educator_education_sanitize_checkbox'
    ));
    $wp_customize->add_control('educator_education_single_post_time_hide',array(
       'type' => 'checkbox',
       'label' => __('Single Post Time','educator-education'),
       'section' => 'educator_education_single_post'
    ));

	$wp_customize->add_setting('educator_education_tags_hide',array(
       'default' => true,
       'sanitize_callback'	=> 'educator_education_sanitize_checkbox'
    ));
    $wp_customize->add_control('educator_education_tags_hide',array(
       'type' => 'checkbox',
       'label' => __('Single Post Tags','educator-education'),
       'section' => 'educator_education_single_post'
    ));

    $wp_customize->add_setting('educator_education_show_featured_image_single_post',array(
       'default' => true,
       'sanitize_callback'	=> 'educator_education_sanitize_checkbox'
    ));
    $wp_customize->add_control('educator_education_show_featured_image_single_post',array(
       'type' => 'checkbox',
       'label' => __('Single Post Image','educator-education'),
       'section' => 'educator_education_single_post'
    ));


    $wp_customize->add_setting( 'educator_education_show_related_post',array(
		'default' => true,
      	'sanitize_callback'	=> 'educator_education_sanitize_checkbox'
    ) );
    $wp_customize->add_control('educator_education_show_related_post',array(
    	'type' => 'checkbox',
        'label' => __( 'Related Post','educator-education' ),
        'section' => 'educator_education_single_post'
    ));

    $wp_customize->add_setting( 'educator_education_post_comment',array(
		'default' => true,
		'sanitize_callback'	=> 'educator_education_sanitize_checkbox'
		) );
	$wp_customize->add_control('educator_education_post_comment',array(
		'type' => 'checkbox',
		'label' => __('Single Post Comment Box','educator-education'),
		'section' => 'educator_education_single_post'
		));

	$wp_customize->add_setting( 'educator_education_single_post_breadcrumb',array(
		'default' => true,
		'transport' => 'refresh',
      	'sanitize_callback'	=> 'educator_education_sanitize_checkbox'
    ) );
    $wp_customize->add_control('educator_education_single_post_breadcrumb',array(
    	'type' => 'checkbox',
        'label' => __( 'Show / Hide Single Post Breadcrumb','educator-education' ),
        'section' => 'educator_education_single_post'
    ));

    // show/hide single post pagination
    $wp_customize->add_setting('educator_education_show_single_post_pagination',array(
       'default' => true,
       'sanitize_callback'	=> 'educator_education_sanitize_checkbox'
    ));
    $wp_customize->add_control('educator_education_show_single_post_pagination',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Single Post Pagination','educator-education'),
       'section' => 'educator_education_single_post'
    ));

    $wp_customize->add_setting('educator_education_category_show_hide',array(
       'default' => true,
       'sanitize_callback'	=> 'educator_education_sanitize_checkbox'
    ));
    $wp_customize->add_control('educator_education_category_show_hide',array(
       'type' => 'checkbox',
       'label' => __('Single Post Category','educator-education'),
       'section' => 'educator_education_single_post'
    ));

    $wp_customize->add_setting('educator_education_title_comment_form',array(
       'default' => __('Leave a Reply','educator-education'),
       'sanitize_callback'	=> 'sanitize_text_field'
    ));
    $wp_customize->add_control('educator_education_title_comment_form',array(
       'type' => 'text',
       'label' => __('Comment Form Heading Text','educator-education'),
       'section' => 'educator_education_single_post'
    ));

    $wp_customize->add_setting('educator_education_comment_form_button_content',array(
       'default' => __('Post Comment','educator-education'),
       'sanitize_callback'	=> 'sanitize_text_field'
    ));
    $wp_customize->add_control('educator_education_comment_form_button_content',array(
       'type' => 'text',
       'label' => __('Comment Form Button Text','educator-education'),
       'section' => 'educator_education_single_post'
    ));

    //Comment Textarea Width
    $wp_customize->add_setting( 'educator_education_comment_width', array(
		'default'=> '100',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(
	    'educator_education_comment_width', array(
		'label'  => __('Comment Textarea Width','educator-education'),
		'section'  => 'educator_education_single_post',
		'description' => __('Measurement is in %.','educator-education'),
		'input_attrs' => array(
		   'step'=> 1,
		   'min' => 0,
		   'max' => 100,
		),
		'type'		=> 'number'
    ));

    $wp_customize->add_setting( 'educator_education_single_post_meta_seperator', array(
		'default'   => '',
		'sanitize_callback'	=> 'sanitize_text_field'
	) );
	$wp_customize->add_control( 'educator_education_single_post_meta_seperator', array(
		'label'       => esc_html__( 'Single Post Meta Box Seperator','educator-education' ),
		'section'     => 'educator_education_single_post',
		'description' => __('Here you can add the seperator for meta box. e.g. "|",  ",", "/", etc. ','educator-education'),
		'type'        => 'text',
		'settings'    => 'educator_education_single_post_meta_seperator',
	) );

    $wp_customize->add_setting('educator_education_related_posts_taxanomies_options',array(
        'default' => 'categories',
        'sanitize_callback' => 'educator_education_sanitize_choices'
	));
	$wp_customize->add_control('educator_education_related_posts_taxanomies_options',array(
        'type' => 'radio',
        'label' => __('Related Post Taxonomies','educator-education'),
        'section' => 'educator_education_single_post',
        'choices' => array(
            'categories' => __('Categories','educator-education'),
            'tags' => __('Tags','educator-education'),
        ),
	) );

	$wp_customize->add_setting('educator_education_related_post_title',array(
		'default'=> __('Related Posts','educator-education'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('educator_education_related_post_title',array(
		'label'	=> __('Related Post Title','educator-education'),
		'section'=> 'educator_education_single_post',
		'type'=> 'text'
	));

   	$wp_customize->add_setting('educator_education_related_posts_number',array(
		'default'=> 3,
		'sanitize_callback'	=> 'educator_education_sanitize_float',
	));
	$wp_customize->add_control('educator_education_related_posts_number',array(
		'label'	=> __('Related Post Number','educator-education'),
		'section'=> 'educator_education_single_post',
		'type'=> 'number',
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
	));

	$wp_customize->add_setting('educator_education_related_post_excerpt_number',array(
		'default'=> 20,
		'sanitize_callback'	=> 'educator_education_sanitize_float',
	));
	$wp_customize->add_control('educator_education_related_post_excerpt_number',array(
		'label'	=> __('Related Post Content Limit','educator-education'),
		'section'=> 'educator_education_single_post',
		'type'=> 'number',
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
	));

	//no Result Found
	$wp_customize->add_section('educator_education_noresult_found',array(
		'title'	=> __('No Result Found','educator-education'),
		'panel' => 'educator_education_panel_id',
	));	

	$wp_customize->add_setting('educator_education_nosearch_found_title',array(
		'default'=> __('Nothing Found','educator-education'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('educator_education_nosearch_found_title',array(
		'label'	=> __('No Result Found Title','educator-education'),
		'section'=> 'educator_education_noresult_found',
		'type'=> 'text'
	));

	$wp_customize->add_setting('educator_education_nosearch_found_content',array(
		'default'=> __('Sorry, but nothing matched your search terms. Please try again with some different keywords.','educator-education'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('educator_education_nosearch_found_content',array(
		'label'	=> __('No Result Found Content','educator-education'),
		'section'=> 'educator_education_noresult_found',
		'type'=> 'text'
	));

	$wp_customize->add_setting('educator_education_show_noresult_search',array(
       'default' => true,
       'sanitize_callback'	=> 'educator_education_sanitize_checkbox'
    ));
    $wp_customize->add_control('educator_education_show_noresult_search',array(
       'type' => 'checkbox',
       'label' => __('No Result search','educator-education'),
       'section' => 'educator_education_noresult_found'
    ));

	//footer
	$wp_customize->add_section('educator_education_footer_section', array(
		'title'       => __('Footer Text', 'educator-education'),
		'priority'    => null,
		'panel'       => 'educator_education_panel_id',
	));

	$wp_customize->add_setting('educator_education_footer_widget_areas',array(
        'default'           => 4,
        'sanitize_callback' => 'educator_education_sanitize_choices',
    ));
    $wp_customize->add_control('educator_education_footer_widget_areas',array(
        'type'        => 'select',
        'label'       => __('Footer widget area', 'educator-education'),
        'section'     => 'educator_education_footer_section',
        'description' => __('Select the number of widget areas you want in the footer. After that, go to Appearance > Widgets and add your widgets.', 'educator-education'),
        'choices' => array(
            '1'     => __('One', 'educator-education'),
            '2'     => __('Two', 'educator-education'),
            '3'     => __('Three', 'educator-education'),
            '4'     => __('Four', 'educator-education')
        ),
    ));

    $wp_customize->add_setting('educator_education_footer_widget_bg_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'educator_education_footer_widget_bg_color', array(
		'label'    => __('Footer Widget Background Color', 'educator-education'),
		'section'  => 'educator_education_footer_section',
	)));

	$wp_customize->add_setting('educator_education_footer_widget_bg_image',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw',
	));
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'educator_education_footer_widget_bg_image',array(
        'label' => __('Footer Widget Background Image','educator-education'),
        'section' => 'educator_education_footer_section'
	)));

	$wp_customize->add_setting('educator_education_footer_copy', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	));
	$wp_customize->add_control('educator_education_footer_copy', array(
		'label'   => __('Copyright Text', 'educator-education'),
		'section' => 'educator_education_footer_section',
		'type'    => 'text',
	));

	$wp_customize->add_setting('educator_education_copyright_content_align',array(
        'default' => 'center',
        'sanitize_callback' => 'educator_education_sanitize_choices'
	));
	$wp_customize->add_control('educator_education_copyright_content_align',array(
        'type' => 'select',
        'label' => __('Copyright Text Alignment ','educator-education'),
        'section' => 'educator_education_footer_section',
        'choices' => array(
            'left' => __('Left','educator-education'),
            'right' => __('Right','educator-education'),
            'center' => __('Center','educator-education'),
        ),
	) );

	$wp_customize->add_setting('educator_education_footer_content_font_size',array(
		'default'=> 16,
		'sanitize_callback'	=> 'educator_education_sanitize_float',
	));
	$wp_customize->add_control('educator_education_footer_content_font_size',array(
		'label' => esc_html__( 'Copyright Font Size','educator-education' ),
		'section'=> 'educator_education_footer_section',
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
        'type' => 'number',
	));

	$wp_customize->add_setting('educator_education_copyright_padding',array(
		'default'=> 15,
		'sanitize_callback'	=> 'educator_education_sanitize_float',
	));
	$wp_customize->add_control('educator_education_copyright_padding',array(
		'label'	=> __('Copyright Padding','educator-education'),
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'section'=> 'educator_education_footer_section',
		'type'=> 'number'
	));

	$wp_customize->add_setting('educator_education_enable_disable_scroll',array(
        'default' => true,
        'sanitize_callback'	=> 'educator_education_sanitize_checkbox'
	));
	$wp_customize->add_control('educator_education_enable_disable_scroll',array(
     	'type' => 'checkbox',
      	'label' => __('Show / Hide Scroll Top Button','educator-education'),
      	'section' => 'educator_education_footer_section',
	));

	$wp_customize->add_setting('educator_education_scroll_setting',array(
        'default' => 'Right',
        'sanitize_callback' => 'educator_education_sanitize_choices'
	));
	$wp_customize->add_control('educator_education_scroll_setting',array(
        'type' => 'select',
        'label' => __('Scroll Back to Top Position','educator-education'),
        'section' => 'educator_education_footer_section',
        'choices' => array(
            'Left' => __('Left','educator-education'),
            'Right' => __('Right','educator-education'),
            'Center' => __('Center','educator-education'),
        ),
	) );

	$wp_customize->add_setting('educator_education_scroll_font_size_icon',array(
		'default'=> 20,
		'sanitize_callback'	=> 'educator_education_sanitize_float',
	));
	$wp_customize->add_control('educator_education_scroll_font_size_icon',array(
		'label'	=> __('Scroll Icon Font Size','educator-education'),
		'section'=> 'educator_education_footer_section',
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
        'type' => 'number',
	)	);
	
}
add_action('customize_register', 'educator_education_customize_register');

// logo resize
load_template( trailingslashit( get_template_directory() ) . '/inc/logo/logo-resizer.php' );

/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class Educator_Education_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if (is_null($instance)) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action('customize_register', array($this, 'sections'));

		// Register scripts and styles for the coneducator_education_Customizetrols.
		add_action('customize_controls_enqueue_scripts', array($this, 'enqueue_control_scripts'), 0);
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function sections($manager) {

		// Load custom sections.
		load_template(trailingslashit(get_template_directory()).'/inc/section-pro.php');

		// Register custom section types.
		$manager->register_section_type('Educator_Education_Customize_Section_Pro');

		// Register sections.
		$manager->add_section(
			new Educator_Education_Customize_Section_Pro(
				$manager,
				'educator_education_example_1',
				array(
					'priority' => 9,
					'title'    => esc_html__('Educator Education', 'educator-education'),
					'pro_text' => esc_html__('GO PRO', 'educator-education'),
					'pro_url'  => esc_url('https://www.themeshopy.com/themes/educator-wordpress-theme/'),
				)
			)
		);
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {

		wp_enqueue_script('educator-education-customize-controls', trailingslashit(esc_url(get_template_directory_uri())).'/js/customize-controls.js', array('customize-controls'));
		wp_enqueue_style('educator-education-customize-controls', trailingslashit(esc_url(get_template_directory_uri())).'/css/customize-controls.css');
	}
}

// Doing this customizer thang!
Educator_Education_Customize::get_instance();