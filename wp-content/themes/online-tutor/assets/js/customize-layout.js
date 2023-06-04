
(function( $ ) {
	wp.customize.bind( 'ready', function() {

		var optPrefix = '#customize-control-online_tutor_options-';
		
		// Label
		function online_tutor_customizer_label( id, title ) {

			// General Setting

			if ( id === 'online_tutor_preloader_hide' || id === 'online_tutor_sticky_header' || id === 'online_tutor_scroll_hide' ) {
				$( '#customize-control-'+ id ).before('<li class="tab-title customize-control">'+ title  +'</li>');
			} else {
				$( '#customize-control-online_tutor_options-'+ id ).before('<li class="tab-title customize-control">'+ title +'</li>');
			}

			// Colors

			if ( id === 'online_tutor_theme_color' || id === 'background_color' || id === 'background_image' ) {
				$( '#customize-control-'+ id ).before('<li class="tab-title customize-control">'+ title  +'</li>');
			} else {
				$( '#customize-control-online_tutor_options-'+ id ).before('<li class="tab-title customize-control">'+ title +'</li>');
			}

			// Site Identity

			if ( id === 'custom_logo' || id === 'site_icon' ) {
				$( '#customize-control-'+ id ).before('<li class="tab-title customize-control">'+ title  +'</li>');
			} else {
				$( '#customize-control-online_tutor_options-'+ id ).before('<li class="tab-title customize-control">'+ title +'</li>');
			}

			// Header Image

			if ( id === 'header_image' ) {
				$( '#customize-control-'+ id ).before('<li class="tab-title customize-control">'+ title  +'</li>');
			} else {
				$( '#customize-control-online_tutor_options-'+ id ).before('<li class="tab-title customize-control">'+ title +'</li>');
			}

			// Top Header

			if ( id === 'online_tutor_ticket_text' || id === 'online_tutor_phone_number' || id === 'online_tutor_email' ) {
				$( '#customize-control-'+ id ).before('<li class="tab-title customize-control">'+ title  +'</li>');
			} else {
				$( '#customize-control-online_tutor_options-'+ id ).before('<li class="tab-title customize-control">'+ title +'</li>');
			}

			// Header

			if ( id === 'online_tutor_search_on_off' || id === 'online_tutor_consultation_button1' || id === 'online_tutor_consultation_button2' ) {
				$( '#customize-control-'+ id ).before('<li class="tab-title customize-control">'+ title  +'</li>');
			} else {
				$( '#customize-control-online_tutor_options-'+ id ).before('<li class="tab-title customize-control">'+ title +'</li>');
			}

			
			// Social Icon

			if ( id === 'online_tutor_facebook_icon' || id === 'online_tutor_twitter_icon' || id === 'online_tutor_instagram_icon'|| id === 'online_tutor_linkedin_icon'|| id === 'online_tutor_pinterest_icon' ) {
				$( '#customize-control-'+ id ).before('<li class="tab-title customize-control">'+ title  +'</li>');
			} else {
				$( '#customize-control-online_tutor_options-'+ id ).before('<li class="tab-title customize-control">'+ title +'</li>');
			}

			// Slider

			if ( id === 'online_tutor_top_slider_setting' ) {
				$( '#customize-control-'+ id ).before('<li class="tab-title customize-control">'+ title  +'</li>');
			} else {
				$( '#customize-control-online_tutor_options-'+ id ).before('<li class="tab-title customize-control">'+ title +'</li>');
			}
			
			// Online Lessons

			if ( id === 'online_tutor_other_project_setting' ) {
				$( '#customize-control-'+ id ).before('<li class="tab-title customize-control">'+ title  +'</li>');
			} else {
				$( '#customize-control-online_tutor_options-'+ id ).before('<li class="tab-title customize-control">'+ title +'</li>');
			}

			// Footer

			if ( id === 'online_tutor_footer_text_setting' ) {
				$( '#customize-control-'+ id ).before('<li class="tab-title customize-control">'+ title  +'</li>');
			} else {
				$( '#customize-control-online_tutor_options-'+ id ).before('<li class="tab-title customize-control">'+ title +'</li>');
			}
			
		}

		// General Setting
		online_tutor_customizer_label( 'online_tutor_preloader_hide', 'Preloader' );
		online_tutor_customizer_label( 'online_tutor_sticky_header', 'Sticky Header' );
		online_tutor_customizer_label( 'online_tutor_scroll_hide', 'Scroll To Top' );


		// Colors
		online_tutor_customizer_label( 'online_tutor_theme_color', 'Theme Color' );
		online_tutor_customizer_label( 'background_color', 'Colors' );
		online_tutor_customizer_label( 'background_image', 'Image' );

		// Site Identity
		online_tutor_customizer_label( 'custom_logo', 'Logo Setup' );
		online_tutor_customizer_label( 'site_icon', 'Favicon' );

		//Header Image
		online_tutor_customizer_label( 'header_image', 'Header Image' );

		// Top Header
		online_tutor_customizer_label( 'online_tutor_ticket_text', 'Ticket Text' );
		online_tutor_customizer_label( 'online_tutor_phone_number', 'Phone' );
		online_tutor_customizer_label( 'online_tutor_email', 'Email' );

		// Header
		online_tutor_customizer_label( 'online_tutor_search_on_off', 'Search' );
		online_tutor_customizer_label( 'online_tutor_consultation_button1', 'Button 1' );
		online_tutor_customizer_label( 'online_tutor_consultation_button2', 'Button 2' );

		
		// Social Icon
		online_tutor_customizer_label( 'online_tutor_facebook_icon', 'Facebook' );
		online_tutor_customizer_label( 'online_tutor_twitter_icon', 'Twitter' );
		online_tutor_customizer_label( 'online_tutor_instagram_icon', 'Intagram' );
		online_tutor_customizer_label( 'online_tutor_linkedin_icon', 'Linkedin' );
		online_tutor_customizer_label( 'online_tutor_pinterest_icon', 'Pintrest' );

		//Slider
		online_tutor_customizer_label( 'online_tutor_top_slider_setting', 'Slider' );

		//Online Lessons
		online_tutor_customizer_label( 'online_tutor_other_project_setting', 'Online Lessons' );

		//Footer
		online_tutor_customizer_label( 'online_tutor_footer_text_setting', 'Footer' );
	

	}); 

})( jQuery );
