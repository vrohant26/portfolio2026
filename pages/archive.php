<?php
/*
Template Name: archive page
*/
get_header();
?>



  <section id="archive" class="flex h-full p-sm direction-column justify-between">
    <div class="top flex gap-lg direction-column justify-end">
      <h4 class="fs-sm w-50 text-light">Where I experiment, break things,<br> and occasionally build something cool.</h4>
      <div class="flex w-full justify-between mb-xs">
        
        <!-- All Filter -->
        <div class="social-link flex align-center gap-xs cursor-pointer filter-btn active" data-filter="all">
            <span class="scramble fs-xs text-gray-500">All</span>
           
        </div>

        <?php
        // Get taxonomies for the 'archive' post type
        $taxonomies = get_object_taxonomies('archive', 'names');
        $taxonomy = !empty($taxonomies) ? $taxonomies[0] : 'category'; // Fallback to 'category' if no custom taxonomy found

        $terms = get_terms(array(
            'taxonomy' => $taxonomy,
            'hide_empty' => true,
        ));

        if (!empty($terms) && !is_wp_error($terms)) :
            foreach ($terms as $term) :
                if (strtolower($term->name) === 'uncategorized') continue; 
        ?>
            <div class="social-link flex align-center gap-xs cursor-pointer filter-btn" data-filter="<?php echo esc_attr($term->slug); ?>">
                <span class="scramble fs-xs text-gray-500">
                    <?php echo esc_html($term->name); ?>
                </span>
            
            </div>
        <?php
            endforeach;
        endif; 
        ?>
      </div>
    </div>
    <div class="bottom">
      <div class="archive-grid">
        <?php
        $args = array(
          'post_type' => 'archive',
          'posts_per_page' => -1,
          'post_status' => 'publish',
        );
        $archive_query = new WP_Query($args);

        if ($archive_query->have_posts()) :
          $count = 1;
          while ($archive_query->have_posts()) : $archive_query->the_post();
            $image = get_the_post_thumbnail_url(get_the_ID(), 'full');
            
            // Get post terms for filtering
            $post_terms = get_the_terms(get_the_ID(), $taxonomy);
            $term_slugs = '';
            if ($post_terms && !is_wp_error($post_terms)) {
                $term_slugs = implode(' ', wp_list_pluck($post_terms, 'slug'));
            }
            ?>
            <div class="archive-item flex direction-column  <?php echo esc_attr($term_slugs); ?>" data-category="<?php echo esc_attr($term_slugs); ?>">
              <div class="archive-image mb-sm flex justify-center align-end">
                <?php if ($image) : ?>
                  <img src="<?php echo esc_url($image); ?>" alt="<?php the_title_attribute(); ?>">
               
               
                <?php endif; ?>
              </div>
              <div class="archive-info flex justify-between align-start">
                <h3 class="fs-xs text-light"><?php the_title(); ?></h3>
                 <span class="fs-xs text-gray-500 text-nowrap">[ <?php echo str_pad($count, 2, '0', STR_PAD_LEFT); ?> ]</span>
              </div>
               <p class="fs-xs text-gray-500"><?php echo esc_html($term_slugs);?></p>
            </div>
            <?php
            $count++;
            endwhile;
          wp_reset_postdata();
        else :
          ?>
          <p class="fs-xs">No archive items found.</p>
        <?php endif; ?>
      </div>
    </div>
  </section>





<?php get_footer(); ?>
