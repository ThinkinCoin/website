<?php
/**
 * The template part for displaying grid post
 *
 * @package Educator Education
 * @subpackage educator-education
 * @since educator-education 1.0
 */
?>
<?php 
  $archive_year  = get_the_time('Y'); 
  $archive_month = get_the_time('m'); 
  $archive_day   = get_the_time('d'); 
?>
<div class="col-lg-4 col-md-4">
  <article class="page-box p-3 my-3">
    <?php if( get_theme_mod( 'educator_education_show_featured_image_post',true) != '') { ?>
      <div class="box-img">
        <?php the_post_thumbnail(); ?>
      </div>
    <?php } ?>
    <div class="new-text">
      <?php if( get_theme_mod( 'educator_education_date_hide',true) != '' || get_theme_mod( 'educator_education_author_hide',true) != '' || get_theme_mod( 'educator_education_comment_hide',true) != '' || get_theme_mod( 'educator_education_time_hide',true) != '') { ?>
        <div class="metabox">
          <?php if( get_theme_mod( 'educator_education_date_hide',true) != '') { ?>
            <span class="entry-date me-3"><a href="<?php echo esc_url( get_day_link( $archive_year, $archive_month, $archive_day)); ?>"><?php echo esc_html( get_the_date() ); ?><span class="screen-reader-text"><?php echo esc_html( get_the_date() ); ?></span></a></span><?php echo esc_html( get_theme_mod('educator_education_metabox_separator_blog_post') ); ?>
          <?php } ?>
          <?php if( get_theme_mod( 'educator_education_author_hide',true) != '') { ?>
            <span class="entry-author me-3"><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' )) ); ?>"><?php the_author(); ?><span class="screen-reader-text"><?php the_author(); ?></span></a></span><?php echo esc_html( get_theme_mod('educator_education_metabox_separator_blog_post') ); ?>
          <?php } ?>
          <?php if( get_theme_mod( 'educator_education_comment_hide',true) != '') { ?>
            <span class="entry-comments me-3"><?php comments_number( __('0 Comments','educator-education'), __('0 Comments','educator-education'), __('% Comments','educator-education') ); ?></span><?php echo esc_html( get_theme_mod('educator_education_metabox_separator_blog_post') ); ?>
          <?php } ?>
          <?php if( get_theme_mod( 'educator_education_time_hide',false) != '') { ?>
            <span class="entry-time me-3"><?php echo esc_html( get_the_time() ); ?></span>
          <?php }?>
        </div>
      <?php }?>
      <h2 class="text-uppercase"><a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php echo the_title_attribute(); ?>"><?php the_title(); ?><span class="screen-reader-text"><?php the_title(); ?></span></a></h2>
      <div class="entry-content"><p class="my-3"><?php $educator_education_excerpt = get_the_excerpt(); echo esc_html( educator_education_string_limit_words( $educator_education_excerpt, esc_attr(get_theme_mod('educator_education_excerpt_number','20')))); ?> <?php echo esc_html( get_theme_mod('educator_education_post_suffix_option','...') ); ?></p></div>
      <?php if( get_theme_mod('educator_education_button_text','Read More') != ''){ ?>
        <div class="read-more-btn mt-3">
          <a href="<?php the_permalink(); ?>" class="py-3 px-4"><?php echo esc_html(get_theme_mod('educator_education_button_text','Read More'));?><span class="screen-reader-text"><?php echo esc_html(get_theme_mod('educator_education_button_text','Read More'));?></span></a>
        </div>
      <?php } ?>
    </div>
    <div class="clearfix"></div>
  </article>
</div>