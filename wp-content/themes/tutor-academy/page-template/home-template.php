<?php
/**
 * Template Name: Home Template
 */

get_header(); ?>

<main id="skip-content">
  <section id="top-slider">
    <?php if(get_theme_mod('online_tutor_top_slider_setting') != ''){ ?>
    <?php $online_tutor_slide_pages = array();
      for ( $tutor_academy_count = 1; $tutor_academy_count <= 3; $tutor_academy_count++ ) {
        $tutor_academy_mod = intval( get_theme_mod( 'online_tutor_top_slider_page' . $tutor_academy_count ));
        if ( 'page-none-selected' != $tutor_academy_mod ) {
          $online_tutor_slide_pages[] = $tutor_academy_mod;
        }
      }
      if( !empty($online_tutor_slide_pages) ) :
        $tutor_academy_args = array(
          'post_type' => 'page',
          'post__in' => $online_tutor_slide_pages,
          'orderby' => 'post__in'
        );
        $tutor_academy_query = new WP_Query( $tutor_academy_args );
        if ( $tutor_academy_query->have_posts() ) :
          $i = 1;
    ?>
    <div class="owl-carousel" role="listbox">
      <?php  while ( $tutor_academy_query->have_posts() ) : $tutor_academy_query->the_post(); ?>
        <div class="slider-box">
          <img src="<?php esc_url(the_post_thumbnail_url('full')); ?>"/>
          <div class="slider-inner-box">
            <h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
            <p class="post"><?php echo wp_trim_words( get_the_content(), 30 ); ?></p>
            <div class="slider-box-btn mt-4">
              <a href="<?php the_permalink(); ?>"><?php esc_html_e('Learn More','tutor-academy'); ?></a>
            </div>
          </div>
        </div>
      <?php $i++; endwhile;
      wp_reset_postdata();?>
    </div>
    <?php else : ?>
      <div class="no-postfound"></div>
    <?php endif;
    endif;?>
    <?php }?>
  </section>

  <?php if(get_theme_mod('online_tutor_search_on_off') != ''){ ?>

  <div class="container">
    <div class="searchbox">
      <h3><?php esc_html_e('Find A Tutor','tutor-academy'); ?></h3>
      <?php get_search_form(); ?>
    </div>
  </div>

<?php }?>

<?php if(get_theme_mod('online_tutor_other_project_setting') != ''){ ?>
  <section id="projects" class="py-5">
    <div class="container">
      <?php if(get_theme_mod('online_tutor_projects_title') != ''){ ?>
        <h2 class="text-center"><?php echo esc_html(get_theme_mod('online_tutor_projects_title')); ?></h2>
      <?php }?>
      <div class="row mt-5">
        <?php $online_tutor_other_project_section = array();
          $tutor_academy_project_loop = get_theme_mod('online_tutor_project_loop');
          for ($i=1; $i <= $tutor_academy_project_loop; $i++) {
            $tutor_academy_mod = intval( get_theme_mod( 'online_tutor_other_project_section' .$i));
            if ( 'page-none-selected' != $tutor_academy_mod ) {
              $online_tutor_other_project_section[] = $tutor_academy_mod;
            }
          }
          if( !empty($online_tutor_other_project_section) ) :
          $tutor_academy_args = array(
            'post_type' => 'post',
            'post__in' => $online_tutor_other_project_section,
            'orderby' => 'post__in'
          );
          $tutor_academy_query = new WP_Query( $tutor_academy_args );
          if ( $tutor_academy_query->have_posts() ) :
            $i = 1;
        ?>
        <?php while ( $tutor_academy_query->have_posts() ) : $tutor_academy_query->the_post(); ?>
          <div class="col-lg-4 col-md-6">
            <div class="box mb-4">
              <?php if ( has_post_thumbnail() ) { ?>
                <img src="<?php esc_url(the_post_thumbnail_url('full')); ?>" class="w-100"/>
                <div class="date-box">
                  <p class="mb-0"><?php echo esc_html(get_the_date()); ?></p>
                </div>
                <div class="price-box text-right">
                  <?php if(get_theme_mod('online_tutor_projects_price'.$i) != ''){ ?>
                    <h5><?php echo esc_html(get_theme_mod('online_tutor_projects_price'.$i)); ?></h5>
                  <?php }?>
                </div>
              <?php }?>
              <div class="p-3">
                <h3><?php the_title(); ?></h3>
              </div>
              <div class="box-content">
                <h3 class="title mb-3"><?php the_title(); ?></h3>
                <p class="post"><?php echo wp_trim_words( get_the_content(), 25 ); ?></p>
                <div class="row">
                  <div class="col-lg-6 col-md-6 col-6 align-self-center">
                    <div class="readmore">
                      <a href="<?php the_permalink(); ?>"><?php esc_html_e('Enroll Now','tutor-academy'); ?></a>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-6 text-right align-self-center">
                    <?php if(get_theme_mod('online_tutor_projects_price'.$i) != ''){ ?>
                      <h5><?php echo esc_html(get_theme_mod('online_tutor_projects_price'.$i)); ?></h5>
                    <?php }?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php $i++; endwhile;
        wp_reset_postdata();?>
        <?php else : ?>
          <div class="no-postfound"></div>
        <?php endif;
        endif;?>
      </div>
    </div>
  </section>
  <?php }?>

  <section id="page-content">
    <div class="container">
      <div class="py-5">
        <?php
          if ( have_posts() ) :
            while ( have_posts() ) : the_post();
              the_content();
            endwhile;
          endif;
        ?>
      </div>
    </div>
  </section>
</main>

<?php get_footer(); ?>
