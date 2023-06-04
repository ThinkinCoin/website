<?php
/**
 * Template Name: Custom home
 */

get_header(); ?>

<main role="main" id="maincontent">
  <?php do_action( 'educator_education_above_slider' ); ?>

  <?php if( get_theme_mod( 'educator_education_slider_hide', false) != '' || get_theme_mod( 'educator_education_responsive_slider', false) != '') { ?>
    <section id="slider" class="mw-100 m-auto p-0">
      <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel" data-interval="<?php echo esc_attr(get_theme_mod('educator_education_slider_speed_option', 3000)); ?>"> 
        <?php $educator_education_slider_pages = array();
          for ( $count = 1; $count <= 4; $count++ ) {
            $mod = intval( get_theme_mod( 'educator_education_slider_page' . $count ));
            if ( 'page-none-selected' != $mod ) {
              $educator_education_slider_pages[] = $mod;
            }
          }
          if( !empty($educator_education_slider_pages) ) :
            $args = array(
              'post_type' => 'page',
              'post__in' => $educator_education_slider_pages,
              'orderby' => 'post__in'
            );
            $query = new WP_Query( $args );
            if ( $query->have_posts() ) :
              $i = 1;
        ?>     
        <div class="carousel-inner" role="listbox">
          <?php  while ( $query->have_posts() ) : $query->the_post(); ?>
            <div <?php if($i == 1){echo 'class="carousel-item active"';} else{ echo 'class="carousel-item"';}?>>
              <?php if(has_post_thumbnail()){
                  the_post_thumbnail();
              } else{?>
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/theme-block-pattern/images/banner.png" alt="" />
              <?php } ?>
              <div class="carousel-caption">
                <?php if( get_theme_mod('educator_education_slider_title_Show_hide',true) != ''){ ?>
                  <h1 class="m-0"><?php the_title(); ?></h1>
                <?php } ?>
                <?php if( get_theme_mod('educator_education_slider_content_Show_hide',true) != ''){ ?>
                  <p class="py-2"><?php $educator_education_excerpt = get_the_excerpt(); echo esc_html( educator_education_string_limit_words( $educator_education_excerpt, esc_attr(get_theme_mod('educator_education_slider_excerpt_length','20')))); ?></p>
                <?php } ?>
                <?php if( get_theme_mod('educator_education_slider_button','Read More') != ''){ ?>
                  <div class="read-btn mt-4">
                    <a href="<?php the_permalink(); ?>"><?php echo esc_html(get_theme_mod('educator_education_slider_button','Read More'));?><span class="screen-reader-text"><?php echo esc_html(get_theme_mod('educator_education_slider_button','Read More'));?></span></a>
                  </div>
                <?php } ?>
              </div>
            </div>
          <?php $i++; endwhile; 
          wp_reset_postdata();?>
        </div>
        <?php else : ?>
          <div class="no-postfound"></div>
        <?php endif;
        endif;?>
        <div class="slider-nex-pre">
          <a class="carousel-control-prev" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev" role="button">
            <span class="carousel-control-prev-icon w-auto h-auto" aria-hidden="true"><i class="fas fa-chevron-left"></i></span>
            <span class="screen-reader-text"><?php esc_html_e( 'Previous','educator-education' );?></span>
          </a>
          <a class="carousel-control-next" data-bs-target="#carouselExampleCaptions" data-bs-slide="next" role="button">
            <span class="carousel-control-next-icon w-auto h-auto" aria-hidden="true"><i class="fas fa-chevron-right"></i></span>
            <span class="screen-reader-text"><?php esc_html_e( 'Next','educator-education' );?></span>
          </a>
        </div>
      </div>
      <div class="clearfix"></div>
    </section>
  <?php } ?>

  <?php do_action( 'educator_education_below_slider' ); ?>

  <section id="courses-section" class="py-5">
    <div class="container">
      <?php if(get_theme_mod('educator_education_services_title') != ''){?>
        <h3 class="mb-5"><?php echo esc_html(get_theme_mod('educator_education_services_title')); ?></h3>
      <?php } ?>
      <div class="owl-carousel">
        <?php if (get_theme_mod('educator_education_course_category') != ''){
          $args = array(
            'post_type' => 'lp_course',
            'post_status' => 'publish',
            'course_category' =>  get_theme_mod('educator_education_course_category')
          );
          $query = new WP_Query($args); 
          if ( $query->have_posts() ) :  while ($query->have_posts()) : $query->the_post();

            $course = LP_Global::course();
            $price = $course->get_price_html();
            $lessons = $course->get_items( LP_LESSON_CPT );
            $lessons  = count( $lessons );
            $p = learn_press_format_price( $price, true ); 
            $students = $course->count_students();
            ?>
            <div class="box mx-3">
              <?php if(has_post_thumbnail()){?>
                <div class="box-image">
                  <?php the_post_thumbnail(); ?>
                  <span class="course-price">
                    <?php echo esc_html(  $course->get_origin_price_html()); ?>
                  </span>
                </div>
              <?php }?>
              <div class="box-content">
                <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                <span class="course-comments">
                  <i class="fas fa-file"></i>
                    <span class="comments-main"><?php echo esc_html($lessons); ?> <?php echo esc_html('Lessons', 'educator-education'); ?></span>
                </span>
                <span class="course-seats ms-4">
                  <i class="fas fa-users"></i>
                  <span class="users-main"><?php echo esc_html($students); ?> <?php echo esc_html('Students', 'educator-education'); ?></span>
                </span>
                <p><?php $educator_education_excerpt = get_the_excerpt(); echo esc_html(educator_education_string_limit_words($educator_education_excerpt,12)); ?></p>
                <a href="<?php the_permalink() ?>" class="course-btn"><?php esc_html_e('Read More','educator-education'); ?></a>
              </div>
            </div>
          <?php endwhile; endif; 
        }?>
      </div>
    </div>
  </section>

  <div id="content" class="py-5">
    <div class="container entry-content">
      <?php while ( have_posts() ) : the_post(); ?>
        <?php the_content(); ?>
      <?php endwhile; // end of the loop. ?>
    </div>
  </div>
</main>

<?php get_footer(); ?>