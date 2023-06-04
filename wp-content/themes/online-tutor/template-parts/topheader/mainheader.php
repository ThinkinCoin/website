<?php
/**
 * Displays main header
 *
 * @package Online Tutor
 */
?>
<?php if(get_theme_mod('online_tutor_top_header_setting') != ''){ ?>
<div class="top_header py-3 text-center text-md-left">
    <div class="container">
        <div class="row">
            <div class="col-lg-2 col-md-3 col-sm-3 align-self-center">
              <div class="social-link">
    				  		<?php if(get_theme_mod('online_tutor_facebook_url') != ''){ ?>
    							<a href="<?php echo esc_url(get_theme_mod('online_tutor_facebook_url','')); ?>"><i class="<?php echo esc_attr( get_theme_mod('online_tutor_facebook_icon') ); ?>"></i></a>
    						<?php }?>
    						<?php if(get_theme_mod('online_tutor_twitter_url') != ''){ ?>
    							<a href="<?php echo esc_url(get_theme_mod('online_tutor_twitter_url','')); ?>"><i class="<?php echo esc_attr( get_theme_mod('online_tutor_twitter_icon') ); ?>"></i></a>
    						<?php }?>
    						<?php if(get_theme_mod('online_tutor_intagram_url') != ''){ ?>
    							<a href="<?php echo esc_url(get_theme_mod('online_tutor_intagram_url','')); ?>"><i class="<?php echo esc_attr( get_theme_mod('online_tutor_instagram_icon') ); ?>"></i></a>
    						<?php }?>
    						<?php if(get_theme_mod('online_tutor_linkedin_url') != ''){ ?>
    							<a href="<?php echo esc_url(get_theme_mod('online_tutor_linkedin_url','')); ?>"><i class="<?php echo esc_attr( get_theme_mod('online_tutor_linkedin_icon') ); ?>"></i></a>
    						<?php }?>
    						<?php if(get_theme_mod('online_tutor_pintrest_url') != ''){ ?>
    							<a href="<?php echo esc_url(get_theme_mod('online_tutor_pintrest_url','')); ?>"><i class="<?php echo esc_attr( get_theme_mod('online_tutor_pinterest_icon') ); ?>"></i></a>
    						<?php }?>
					   </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 align-self-center">
                <?php if(get_theme_mod('online_tutor_ticket_text') != '' || get_theme_mod('online_tutor_ticket_url') != ''){ ?>
                    <p class="mb-0 text-center"><?php echo esc_html(get_theme_mod('online_tutor_ticket_text','')); ?><a href="<?php echo esc_url(get_theme_mod('online_tutor_ticket_url','')); ?>" class="ml-3"><?php esc_html_e('Get Ticket','online-tutor'); ?></a></p>
                <?php }?>
            </div>
            <div class="col-lg-4 col-md-3 col-sm-3 align-self-center text-md-right">
                <?php if(get_theme_mod('online_tutor_phone_number') != ''){ ?>
                    <a href="tel:<?php echo esc_html(get_theme_mod('online_tutor_phone_number','')); ?>"><span><?php echo esc_html(get_theme_mod('online_tutor_phone_number','')); ?></span></a><span>|</span>
                <?php }?>
                <?php if(get_theme_mod('online_tutor_email') != ''){ ?>
                    <a href="mailto:<?php echo esc_html(get_theme_mod('online_tutor_email','')); ?>"><span><?php echo esc_html(get_theme_mod('online_tutor_email','')); ?></span></a>
                <?php }?>
            </div>
        </div>
    </div>
</div>
<?php }?>
