

<?php
/*
Template Name: Featured Work
*/
get_header();
?>
 
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
            <a href="<?php the_permalink(); ?>" class="project-card-item flex direction-column gap-sm" style="text-decoration: none;">
          
              <div class="project-title flex w-full justify-between">
              
                <p class="fs-xs text-light">
                  <?php the_title(); ?>
                </p >
               
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
              
                <div class="project-card-image" data-slideshow>
                  <?php
                  $media_items = [];
                  if ($image) {
                      $media_items[] = array('url' => $image, 'type' => 'image');
                  }
                  $previews = get_post_meta(get_the_ID(), '_project_previews', true);
                  if (!is_array($previews)) {
                      $previews = [];
                      for ($i = 1; $i <= 4; $i++) {
                          $val = get_post_meta(get_the_ID(), '_project_preview_' . $i, true);
                          if ($val) $previews[] = $val;
                      }
                  }
                  if (is_array($previews)) {
                      foreach ($previews as $preview_id) {
                          if ($preview_id) {
                              $preview_url = wp_get_attachment_url($preview_id);
                              $mime_type = get_post_mime_type($preview_id);
                              $is_video = strpos($mime_type, 'video') === 0;
                              if (!$is_video) {
                                  $media_items[] = array('url' => $preview_url, 'type' => 'image');
                              }
                          }
                      }
                  }
                  ?>
                  <?php foreach ($media_items as $index => $media) : ?>
                      <?php $style = $index === 0 ? 'display: block;' : 'display: none;'; ?>
                      <img src="<?php echo esc_url($media['url']); ?>" class="slideshow-media" style="<?php echo $style; ?> width: 100%; height: 100%; object-fit: cover;" alt="<?php the_title_attribute(); ?>">
                  <?php endforeach; ?>
                </div>
            </a>
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

 

</section>


<?php get_footer(); ?>
