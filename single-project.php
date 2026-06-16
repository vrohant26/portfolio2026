<?php
get_header();

while (have_posts()) :
    the_post();
    
    $project_url = get_post_meta(get_the_ID(), '_project_url', true);
    $project_description = get_post_meta(get_the_ID(), '_project_description', true);
    
    $image = get_the_post_thumbnail_url(get_the_ID(), 'full');
    $previews = get_post_meta(get_the_ID(), '_project_previews', true);
    if (!is_array($previews)) {
        $previews = [];
        for ($i = 1; $i <= 4; $i++) {
            $val = get_post_meta(get_the_ID(), '_project_preview_' . $i, true);
            if ($val) $previews[] = $val;
        }
    }
    
    $media_items = [];
    if ($image) {
        $media_items[] = array('url' => $image, 'type' => 'image');
    }
    if (is_array($previews)) {
        foreach ($previews as $preview_id) {
            if ($preview_id) {
                $preview_url = wp_get_attachment_url($preview_id);
                $mime_type = get_post_mime_type($preview_id);
                $is_video = strpos($mime_type, 'video') === 0;
                $media_items[] = array('url' => $preview_url, 'type' => $is_video ? 'video' : 'image');
            }
        }
    }
?>

  <section id="single-project" class="flex h-full p-sm direction-column justify-between" style="max-width : 1300px; margin : auto;">
    <div class="top flex gap-lg direction-column justify-end">
      <div class="flex direction-column gap-sm">
          <h4 class="fs-sm w-50 text-light m-0"><?php the_title(); ?></h4>
          <?php if ($project_description): ?>
              <p class="fs-xs text-gray-500  m-0" style="max-width: 600px;"><?php echo nl2br(esc_html($project_description)); ?></p>
          <?php endif; ?>
      </div>
      
      <div class="flex w-full justify-between mb-xs">
        
        <div class="flex gap-sm">
            <?php
            $tags = get_the_tags();
            if ($tags) {
                foreach ($tags as $tag) {
                    ?>
                    <div class="fit-content flex align-center gap-xs anim-translate">
                        <span class="scramble fs-xs text-gray-500"><?php echo esc_html($tag->name); ?></span>
                    </div>
                    <?php
                }
            }
            ?>
        </div>

        <?php if ($project_url) : ?>
            <a href="<?php echo esc_url($project_url); ?>" target="_blank" rel="noopener noreferrer" class="fit-content flex align-center gap-xs cursor-pointer filter-btn active anim-translate" style="text-decoration: none;">
                <span class="scramble fs-xs text-gray-500">Visit Site</span>
                <svg class="icon text-gray-500" viewBox="0 0 9 9" style="fill: currentColor;" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6.68067 2.276L0.942667 8.014L0 7.07133L5.738 1.33333H0.68V0H8.01333V7.33333H6.68L6.68067 2.276Z" />
                </svg>
            </a>
        <?php endif; ?>
        
      </div>
    </div>
    
    <div class="bottom" style="height: auto; padding-top: 100px; padding-bottom: 100px;">
        <div class="project-media-list flex direction-column" style="gap: 100px;">
            <?php foreach ($media_items as $media) : ?>
                <div class="single-media-container" style="width: 100%; overflow: hidden; ">
                    <?php if ($media['type'] === 'video') : ?>
                        <video class="lazy-video" src="<?php echo esc_url($media['url']); ?>" style="width: 100%; height: auto; display: block;" muted loop playsinline></video>
                    <?php else : ?>
                        <img src="<?php echo esc_url($media['url']); ?>" style="width: 100%; height: auto; display: block;" alt="<?php the_title_attribute(); ?>">
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Next Project Navigation -->
        <?php
        $next_post = get_next_post();
        if (!$next_post) {
            // Loop back to the first post if there is no next post
            $first_post_args = array(
                'post_type'      => 'project',
                'posts_per_page' => 1,
                'order'          => 'ASC',
            );
            $first_post_query = new WP_Query($first_post_args);
            if ($first_post_query->have_posts()) {
                $next_post = $first_post_query->posts[0];
            }
        }
        
        if ($next_post) :
        ?>
            <div class="next-project flex justify-center" style="margin-top: 100px;">
                <a href="<?php echo get_permalink($next_post->ID); ?>" class="flex align-center gap-xs cursor-pointer filter-btn" style="border: 1px solid var(--gray-300); padding: 0.5rem 1.5rem; border-radius: 50px; text-decoration: none;">
                    <span class="scramble fs-xs text-gray-500">Next: <?php echo esc_html($next_post->post_title); ?> ➔</span>
                </a>
            </div>
        <?php endif; ?>
    </div>
  </section>

<?php
endwhile;
get_footer(); 
?>
