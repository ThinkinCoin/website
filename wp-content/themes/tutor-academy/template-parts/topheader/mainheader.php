<?php
/**
 * Displays main header
 *
 * @package Tutor Academy
 */
?>
<?php if(get_theme_mod('online_tutor_top_header_setting') != ''){ ?>
<div class="top_header py-2 text-center text-md-left">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-5 col-sm-5 align-self-center">
                <?php if(get_theme_mod('online_tutor_ticket_text') != '' ){ ?>
                    <p class="mb-0"><?php echo esc_html(get_theme_mod('online_tutor_ticket_text','')); ?></p>
                <?php }?>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 align-self-center text-md-right">
                <?php if(get_theme_mod('tutor_academy_admission') != '' || get_theme_mod('tutor_academy_admission_link') != ''){ ?>
                    <a href="<?php echo esc_url(get_theme_mod('tutor_academy_admission_link','')); ?>" class="mr-2 info-text"><?php echo esc_html(get_theme_mod('tutor_academy_admission','')); ?></a>
                <?php }?>
                <?php if(get_theme_mod('tutor_academy_research') != '' || get_theme_mod('tutor_academy_research_link') != ''){ ?>
                    <a href="<?php echo esc_url(get_theme_mod('tutor_academy_research_link','')); ?>" class="mr-2 info-text"><?php echo esc_html(get_theme_mod('tutor_academy_research','')); ?></a>
                <?php }?>
                <?php if(get_theme_mod('tutor_academy_faq') != '' || get_theme_mod('tutor_academy_faq_link') != ''){ ?>
                    <a  href="<?php echo esc_url(get_theme_mod('tutor_academy_faq_link','')); ?>" class="info-text"><?php echo esc_html(get_theme_mod('tutor_academy_faq','')); ?></a>
                <?php }?>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-3 align-self-center">
                <?php if(get_theme_mod('online_tutor_facebook_url') != '' || get_theme_mod('online_tutor_twitter_url') != '' || get_theme_mod('online_tutor_intagram_url') != '' || get_theme_mod('online_tutor_linkedin_url') != '' || get_theme_mod('online_tutor_pintrest_url') != ''){ ?>
                    <div class="social-link text-md-right">
                        <?php if(get_theme_mod('online_tutor_facebook_url') != ''){ ?>
                            <a href="<?php echo esc_url(get_theme_mod('online_tutor_facebook_url','')); ?>"><i class="fab fa-facebook-f mr-2"></i></a>
                        <?php }?>
                        <?php if(get_theme_mod('online_tutor_twitter_url') != ''){ ?>
                            <a href="<?php echo esc_url(get_theme_mod('online_tutor_twitter_url','')); ?>"><i class="fab fa-twitter mr-2"></i></a>
                        <?php }?>
                        <?php if(get_theme_mod('online_tutor_intagram_url') != ''){ ?>
                            <a href="<?php echo esc_url(get_theme_mod('online_tutor_intagram_url','')); ?>"><i class="fab fa-instagram mr-2"></i></a>
                        <?php }?>
                        <?php if(get_theme_mod('online_tutor_linkedin_url') != ''){ ?>
                            <a href="<?php echo esc_url(get_theme_mod('online_tutor_linkedin_url','')); ?>"><i class="fab fa-linkedin-in mr-2"></i></a>
                        <?php }?>
                        <?php if(get_theme_mod('online_tutor_pintrest_url') != ''){ ?>
                            <a href="<?php echo esc_url(get_theme_mod('online_tutor_pintrest_url','')); ?>"><i class="fab fa-pinterest-p"></i></a>
                        <?php }?>
                    </div>
                <?php }?>
            </div>
        </div>
    </div>
</div>
<?php }?>