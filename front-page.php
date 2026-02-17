

<?php get_header(); ?>

<section id="work" class="h-full">

  <div class="swiper mySwiper">
    <div class="swiper-wrapper">
      <?php
      $args = array(
        'post_type' => 'project',
        'posts_per_page' => -1,
        'post_status' => 'publish',
      );
      $project_query = new WP_Query($args);
      
      if ($project_query->have_posts()) :
        while ($project_query->have_posts()) : $project_query->the_post();
          $image = get_the_post_thumbnail_url(get_the_ID(), 'large');
          ?>
          <div class="swiper-slide">
            <div class="project-card-item flex direction-column gap-sm" >
              <div class="project-title flex w-full justify-between">
                <div class="flex align-center gap-xs">
 <p class="fs-xs text-light">
                  <?php the_title(); ?>
                </p >
                <svg class="icon" viewBox="0 0 9 9"  xmlns="http://www.w3.org/2000/svg">
<path d="M6.68067 2.276L0.942667 8.014L0 7.07133L5.738 1.33333H0.68V0H8.01333V7.33333H6.68L6.68067 2.276Z" />
</svg>
                </div>
               
                <p class="fs-xs mobile-hide text-gray-500">
                  <?php 
                  $tags = get_the_tags();
                  if ($tags) {
                      $tag_names = wp_list_pluck($tags, 'name');
                      echo esc_html(implode(', ', $tag_names));
                  }
                  ?>
                </p>
              </div>

                <div class="project-card-image">
                            <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($title); ?>">
                        </div>
            </div>
          </div>
          <?php
        endwhile;
        wp_reset_postdata();
      else :
        ?>
        <div class="swiper-slide">
          <div class="project-card-item flex align-center justify-center">
            <p class="fs-sm">No projects found</p>
          </div>
        </div>
      <?php endif; ?>
    </div>

  </div>

  <div class="brief">
    <p class="fs-xs text-gray-500">Hey, I’m Rohant Villarosa, a creative developer and designer. I build websites and fix what’s broken (usually before anyone notices).</p>
  </div>

</section>


<?php get_footer(); ?>
