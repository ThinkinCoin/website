<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div class="content-ts">
 *
 * @package Educator Education
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
  <?php if ( function_exists( 'wp_body_open' ) ) {
    wp_body_open();
  } else {
    do_action( 'wp_body_open' );
  } ?>
  <header role="banner">
    <!-- preloader -->
    <?php if(get_theme_mod('educator_education_preloader_option',true)!= '' || get_theme_mod('educator_education_responsive_preloader', true) != ''){ ?>
      <?php if(get_theme_mod('educator_education_preloader_type_options', 'Preloader 1')  == 'Preloader 1') {?>
        <div id="loader-wrapper" class="w-100 h-100">
          <div id="loader" class="rounded-circle"></div>
          <div class="loader-section section-left"></div>
          <div class="loader-section section-right"></div>
        </div>
      <?php } else if(get_theme_mod('educator_education_preloader_type_options', 'Preloader 2') ==  'Preloader 2') {?>
        <div id="loader-wrapper" class="w-100 h-100">
          <div class="loader">
            <div></div>
            <div></div>
            <div></div>
          </div>
        </div>
      <?php }?>
    <?php }?>
  <!-- preloader end -->
    <a class="screen-reader-text skip-link" href="#maincontent" ><?php esc_html_e( 'Skip to content', 'educator-education' ); ?></a>    

    <div id="header" class="position-relative">
      <div class="topbar">
        <div class="container">
          <div class="row">
            <div class="col-lg-3 col-md-6 col-8 align-self-center">
              <div class="social-icons">
                <?php if(get_theme_mod('educator_education_instagram_url') != ''){?>
                  <a href="<?php echo esc_url(get_theme_mod('educator_education_instagram_url')); ?>"><i class="fab fa-instagram"></i><span class="screen-reader-text"><?php echo esc_html('Instagram', 'educator-education'); ?></span></a>
                <?php }?>
                <?php if(get_theme_mod('educator_education_twitter_url') != ''){?>
                  <a href="<?php echo esc_url(get_theme_mod('educator_education_twitter_url')); ?>"><i class="fab fa-twitter"></i><span class="screen-reader-text"><?php echo esc_html('Twitter', 'educator-education'); ?></span></a>
                <?php }?>
                <?php if(get_theme_mod('educator_education_tumblr_url') != ''){?>
                  <a href="<?php echo esc_url(get_theme_mod('educator_education_tumblr_url')); ?>"><i class="fab fa-tumblr"></i><span class="screen-reader-text"><?php echo esc_html('Tumblr', 'educator-education'); ?></span></a>
                <?php }?>
                <?php if(get_theme_mod('educator_education_facebook_url') != ''){?>
                  <a href="<?php echo esc_url(get_theme_mod('educator_education_facebook_url')); ?>"><i class="fab fa-facebook-f"></i><span class="screen-reader-text"><?php echo esc_html('Facebook', 'educator-education'); ?></span></a>
                <?php }?>
              </div>
            </div>
            <div class="offset-lg-6 col-lg-3 col-md-6 col-4 align-self-center text-end">
              <?php if( get_theme_mod('educator_education_login_link') != ''){ ?>
                <a href="<?php echo esc_url(get_theme_mod('educator_education_login_link')); ?>" class="login-link"><i class="fas fa-lock me-2"></i><?php esc_html_e( 'Login','educator-education' );?><span class="screen-reader-text"><?php esc_html_e( 'Login','educator-education' );?></span></a>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
      <div class="middle-header">
        <div class="container">
          <div class="row">
            <div class="col-lg-3 col-md-6 align-self-center">
              <div class="logo">
                <?php if ( has_custom_logo() ) : ?>
                  <div class="site-logo"><?php the_custom_logo(); ?></div>
                <?php endif; ?>
                <?php $blog_info = get_bloginfo( 'name' ); ?>
                <?php if ( ! empty( $blog_info ) ) : ?>
                  <?php if( get_theme_mod('educator_education_site_title',true) != ''){ ?>
                    <?php if ( is_front_page() && is_home() ) : ?>
                      <h1 class="site-title p-0"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="text-start pt-0" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                    <?php else : ?>
                      <p class="site-title mb-0"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="text-start pt-0"><?php bloginfo( 'name' ); ?></a></p>
                    <?php endif; ?>
                  <?php }?>
                <?php endif; ?>
                <?php
                $description = get_bloginfo( 'description', 'display' );
                if ( $description || is_customize_preview() ) :
                  ?>
                  <?php if( get_theme_mod('educator_education_tagline',true) != ''){ ?>
                    <p class="site-description mb-0">
                      <?php echo esc_html($description); ?>
                    </p>
                  <?php }?>
                <?php endif; ?>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 location align-self-center">
              <?php if( get_theme_mod('educator_education_location_text') != '' || get_theme_mod('educator_education_location_address') != '' ) {?>
                <div class="row">
                  <div class="col-lg-2 col-md-2 align-self-center">
                    <i class="fas fa-map-marker-alt"></i>
                  </div>
                  <div class="col-lg-10 col-md-10 align-self-center">
                    <?php if( get_theme_mod('educator_education_location_text') != '') {?>
                      <p class="location-text mb-0"><?php echo esc_html(get_theme_mod('educator_education_location_text')); ?></p>
                    <?php }?>
                    <?php if( get_theme_mod('educator_education_location_address') != '') {?>
                      <p class="address mb-0"><?php echo esc_html(get_theme_mod('educator_education_location_address')); ?></p>
                    <?php }?>
                  </div>
                </div>
              <?php }?>
            </div>
            <div class="col-lg-3 col-md-6 phone align-self-center">
              <?php if( get_theme_mod('educator_education_phone_text') != '' || get_theme_mod('educator_education_phoneno') != '' ) {?>
                <div class="row">
                  <div class="col-lg-2 col-md-2 align-self-center">
                    <i class="fas fa-phone"></i>
                  </div>
                  <div class="col-lg-10 col-md-10 align-self-center">
                    <?php if( get_theme_mod('educator_education_phone_text') != '') {?>
                      <p class="phone-text mb-0"><?php echo esc_html(get_theme_mod('educator_education_phone_text')); ?></p>
                    <?php }?>
                    <?php if( get_theme_mod('educator_education_phoneno') != '') {?>
                      <a href="tel:<?php echo esc_attr(get_theme_mod('educator_education_phoneno')); ?>"><?php echo esc_html(get_theme_mod('educator_education_phoneno')); ?><span class="screen-reader-text"><?php echo esc_html(get_theme_mod('educator_education_phoneno')); ?></span></a>
                    <?php }?>
                  </div>
                </div>
              <?php }?>
            </div>
            <div class="col-lg-3 col-md-6 mail align-self-center">
              <?php if( get_theme_mod('educator_education_mail_text') != '' || get_theme_mod('educator_education_mail_address') != '' ) {?>
                <div class="row">
                  <div class="col-lg-2 col-md-2 align-self-center">
                    <i class="fas fa-envelope"></i>
                  </div>
                  <div class="col-lg-10 col-md-10 align-self-center">
                    <?php if( get_theme_mod('educator_education_mail_text') != '') {?>
                      <p class="phone-text mb-0"><?php echo esc_html(get_theme_mod('educator_education_mail_text')); ?></p>
                    <?php }?>
                    <?php if( get_theme_mod('educator_education_mail_address') != '') {?>
                      <a href="mailto:<?php echo esc_attr(get_theme_mod('educator_education_mail_address')); ?>"><?php echo esc_html(get_theme_mod('educator_education_mail_address')); ?><span class="screen-reader-text"><?php echo esc_html(get_theme_mod('educator_education_mail_address')); ?></span></a>
                    <?php }?>
                  </div>
                </div>
              <?php }?>
            </div>
          </div>
        </div>
      </div>
      <div class="menu-section">
        <div class="container">
          <div class="main-menu text-center">
            <?php 
              if(has_nav_menu('primary')){ ?>
              <div class="toggle-menu mobile-menu text-center">
                <button class="mobiletoggle responsive-toggle"><i class="fas fa-bars"></i><span class="screen-reader-text"><?php esc_html_e('Open Menu','educator-education'); ?></span></button>
              </div>
            <?php }?>
            <div id="menu-sidebar" class="nav sidebar text-center">
              <nav id="primary-site-navigation" class="primary-navigation ps-0" role="navigation" aria-label="<?php esc_attr_e( 'Top Menu', 'educator-education' ); ?>">
                <?php
                  if(has_nav_menu('primary')){
                    wp_nav_menu( array(
                      'theme_location' => 'primary',
                      'container_class' => 'main-menu-navigation responsive-menu clearfix' ,
                      'menu_class' => 'clearfix',
                      'items_wrap' => '<ul id="%1$s" class="%2$s mobile_nav">%3$s</ul>',
                      'fallback_cb' => 'wp_page_menu',
                    ) );
                  } 
                ?>
                <a href="javascript:void(0)" class="closebtn mobile-menu"><i class="far fa-times-circle"></i><span class="screen-reader-text"><?php esc_html_e('Close Menu','educator-education'); ?></span></a>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>