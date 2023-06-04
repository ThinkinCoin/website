<?php

// Paragraph
$educator_education_paragraph_color = get_theme_mod('educator_education_paragraph_color', '');
$educator_education_paragraph_font_family = get_theme_mod('educator_education_paragraph_font_family', '');
$educator_education_paragraph_font_size = get_theme_mod('educator_education_paragraph_font_size', '');
// "a" tag
$educator_education_atag_color = get_theme_mod('educator_education_atag_color', '');
$educator_education_atag_font_family = get_theme_mod('educator_education_atag_font_family', '');
// "li" tag
$educator_education_li_color = get_theme_mod('educator_education_li_color', '');
$educator_education_li_font_family = get_theme_mod('educator_education_li_font_family', '');
// H1
$educator_education_h1_color = get_theme_mod('educator_education_h1_color', '');
$educator_education_h1_font_family = get_theme_mod('educator_education_h1_font_family', '');
$educator_education_h1_font_size = get_theme_mod('educator_education_h1_font_size', '');
// H2
$educator_education_h2_color = get_theme_mod('educator_education_h2_color', '');
$educator_education_h2_font_family = get_theme_mod('educator_education_h2_font_family', '');
$educator_education_h2_font_size = get_theme_mod('educator_education_h2_font_size', '');
// H3
$educator_education_h3_color = get_theme_mod('educator_education_h3_color', '');
$educator_education_h3_font_family = get_theme_mod('educator_education_h3_font_family', '');
$educator_education_h3_font_size = get_theme_mod('educator_education_h3_font_size', '');
// H4
$educator_education_h4_color = get_theme_mod('educator_education_h4_color', '');
$educator_education_h4_font_family = get_theme_mod('educator_education_h4_font_family', '');
$educator_education_h4_font_size = get_theme_mod('educator_education_h4_font_size', '');
// H5
$educator_education_h5_color = get_theme_mod('educator_education_h5_color', '');
$educator_education_h5_font_family = get_theme_mod('educator_education_h5_font_family', '');
$educator_education_h5_font_size = get_theme_mod('educator_education_h5_font_size', '');
// H6
$educator_education_h6_color = get_theme_mod('educator_education_h6_color', '');
$educator_education_h6_font_family = get_theme_mod('educator_education_h6_font_family', '');
$educator_education_h6_font_size = get_theme_mod('educator_education_h6_font_size', '');

$educator_education_typo_css ='
	p,span{
	    color:'.esc_html($educator_education_paragraph_color).'!important;
	    font-family: '.esc_html($educator_education_paragraph_font_family).';
	    font-size: '.esc_html($educator_education_paragraph_font_size).';
	}
	a{
	    color:'.esc_html($educator_education_atag_color).'!important;
	    font-family: '.esc_html($educator_education_atag_font_family).';
	}
	li{
	    color:'.esc_html($educator_education_li_color).'!important;
	    font-family: '.esc_html($educator_education_li_font_family).';
	}
	h1{
	    color:'.esc_html($educator_education_h1_color).'!important;
	    font-family: '.esc_html($educator_education_h1_font_family).'!important;
	    font-size: '.esc_html($educator_education_h1_font_size).'!important;
	}
	h2{
	    color:'.esc_html($educator_education_h2_color).'!important;
	    font-family: '.esc_html($educator_education_h2_font_family).'!important;
	    font-size: '.esc_html($educator_education_h2_font_size).'!important;
	}
	h3{
	    color:'.esc_html($educator_education_h3_color).'!important;
	    font-family: '.esc_html($educator_education_h3_font_family).'!important;
	    font-size: '.esc_html($educator_education_h3_font_size).'!important;
	}
	h4{
	    color:'.esc_html($educator_education_h4_color).'!important;
	    font-family: '.esc_html($educator_education_h4_font_family).'!important;
	    font-size: '.esc_html($educator_education_h4_font_size).'!important;
	}
	h5{
	    color:'.esc_html($educator_education_h5_color).'!important;
	    font-family: '.esc_html($educator_education_h5_font_family).'!important;
	    font-size: '.esc_html($educator_education_h5_font_size).'!important;
	}
	h6{
	    color:'.esc_html($educator_education_h6_color).'!important;
	    font-family: '.esc_html($educator_education_h6_font_family).'!important;
	    font-size: '.esc_html($educator_education_h6_font_size).'!important;
	}
';