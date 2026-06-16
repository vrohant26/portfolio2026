<?php

/**
 * --------------------------------------------------------
 * THEME SETUP
 * --------------------------------------------------------
 */
 
function custom_portfolio_theme_setup() {

    // Let WordPress manage <title>
    add_theme_support('title-tag');

    // Enable featured images
    add_theme_support('post-thumbnails');

    // HTML5 markup support
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script'
    ));

  
}

add_action('after_setup_theme', 'custom_portfolio_theme_setup');


/**
 * --------------------------------------------------------
 * CUSTOM POST TYPES
 * --------------------------------------------------------
 */
function custom_portfolio_register_custom_post_types() {
    // Register 'Project' CPT
    $project_labels = array(
        'name'                  => _x( 'Projects', 'Post type general name', 'custom-portfolio' ),
        'singular_name'         => _x( 'Project', 'Post type singular name', 'custom-portfolio' ),
        'menu_name'             => _x( 'Projects', 'Admin Menu text', 'custom-portfolio' ),
        'name_admin_bar'        => _x( 'Project', 'Add New on Toolbar', 'custom-portfolio' ),
        'add_new'               => __( 'Add New', 'custom-portfolio' ),
        'add_new_item'          => __( 'Add New Project', 'custom-portfolio' ),
        'new_item'              => __( 'New Project', 'custom-portfolio' ),
        'edit_item'             => __( 'Edit Project', 'custom-portfolio' ),
        'view_item'             => __( 'View Project', 'custom-portfolio' ),
        'all_items'             => __( 'All Projects', 'custom-portfolio' ),
        'search_items'          => __( 'Search Projects', 'custom-portfolio' ),
        'not_found'             => __( 'No projects found.', 'custom-portfolio' ),
        'not_found_in_trash'    => __( 'No projects found in Trash.', 'custom-portfolio' ),
    );

    $project_args = array(
        'labels'             => $project_labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'project' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-portfolio',
        'supports'           => array( 'title', 'thumbnail', 'excerpt', 'custom-fields' ),
        'taxonomies'         => array( 'post_tag' ),
        'show_in_rest'       => true,
    );

    register_post_type( 'project', $project_args );

    // Register 'Archive' CPT
    $archive_labels = array(
        'name'                  => _x( 'Archives', 'Post type general name', 'custom-portfolio' ),
        'singular_name'         => _x( 'Archive', 'Post type singular name', 'custom-portfolio' ),
        'menu_name'             => _x( 'Archives', 'Admin Menu text', 'custom-portfolio' ),
        'name_admin_bar'        => _x( 'Archive', 'Add New on Toolbar', 'custom-portfolio' ),
        'add_new'               => __( 'Add New', 'custom-portfolio' ),
        'add_new_item'          => __( 'Add New Archive', 'custom-portfolio' ),
        'new_item'              => __( 'New Archive', 'custom-portfolio' ),
        'edit_item'             => __( 'Edit Archive', 'custom-portfolio' ),
        'view_item'             => __( 'View Archive', 'custom-portfolio' ),
        'all_items'             => __( 'All Archives', 'custom-portfolio' ),
        'search_items'          => __( 'Search Archives', 'custom-portfolio' ),
        'not_found'             => __( 'No archives found.', 'custom-portfolio' ),
        'not_found_in_trash'    => __( 'No archives found in Trash.', 'custom-portfolio' ),
    );

    $archive_args = array(
        'labels'             => $archive_labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'archive' ),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 6,
        'menu_icon'          => 'dashicons-archive',
        'supports'           => array( 'title', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes' ),
        'taxonomies'         => array( 'category' ),
        'show_in_rest'       => true,
    );

    register_post_type( 'archive', $archive_args );
}
add_action( 'init', 'custom_portfolio_register_custom_post_types' );


/**
 * --------------------------------------------------------
 * ENQUEUE STYLES & SCRIPTS
 * --------------------------------------------------------
 */

function custom_portfolio_enqueue_scripts() {

    $theme_version = wp_get_theme()->get('Version');

    /**
     * Swiper CSS
     */
    wp_enqueue_style(
        'swiper-css',
        'https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css',
        array(),
        '12.0.0'
    );

    /**
     * Main Stylesheet
     */
    wp_enqueue_style(
        'custom-portfolio-style',
        get_stylesheet_directory_uri() . '/style.css',
        array(),
        filemtime(get_stylesheet_directory() . '/style.css')
    );

    /**
     * GSAP Core
     */
    wp_enqueue_script(
        'gsap',
        'https://cdn.jsdelivr.net/npm/gsap@3.14.1/dist/gsap.min.js',
        array(),
        '3.14.1',
        true
    );

    /**
     * GSAP ScrambleText Plugin
     */
    wp_enqueue_script(
        'gsap-scrambletext',
        'https://cdn.jsdelivr.net/npm/gsap@3.14.1/dist/ScrambleTextPlugin.min.js',
        array('gsap'),
        '3.14.1',
        true
    );

    /**
     * Barba.js
     */
    wp_enqueue_script(
        'barba',
        'https://unpkg.com/@barba/core',
        array(),
        null,
        true
    );

    wp_enqueue_script(
        'barba-prefetch',
        'https://unpkg.com/@barba/prefetch',
        array('barba'),
        null,
        true
    );

    /**
     * Main JS
     */
    wp_enqueue_script(
        'custom-portfolio-js',
        get_stylesheet_directory_uri() . '/js/main.js',
        array('gsap', 'gsap-scrambletext', 'barba'),
        filemtime(get_stylesheet_directory() . '/js/main.js'),
        true
    );

    wp_localize_script('custom-portfolio-js', 'themeData', array(
        'themeUri' => get_template_directory_uri(),
        'ajaxUrl' => admin_url('admin-ajax.php')
    ));

    /**
     * Page Transitions JS
     */
    wp_enqueue_script(
        'custom-portfolio-transitions',
        get_stylesheet_directory_uri() . '/js/page-transition.js',
        array('gsap', 'barba'),
        filemtime(get_stylesheet_directory() . '/js/page-transition.js'),
        true
    );

    /**
     * Swiper JS
     */
    wp_enqueue_script(
        'swiper-js',
        'https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js',
        array(),
        '12.0.0',
        true
    );

    /**
     * Grained.js
     */
    wp_enqueue_script(
        'grained',
        'https://unpkg.com/grained',
        array(),
        '1.0.0',
        true
    );

    /**
     * SplitType
     */
    wp_enqueue_script(
        'split-type',
        'https://unpkg.com/split-type',
        array(),
        '0.3.3',
        true
    );
}



add_action('wp_enqueue_scripts', 'custom_portfolio_enqueue_scripts');


/**
 * --------------------------------------------------------
 * OPTIONAL: CUSTOM IMAGE SIZES
 * --------------------------------------------------------
 */

add_image_size('portfolio-large', 1600, 900, true);
add_image_size('portfolio-medium', 800, 600, true);


/**
 * --------------------------------------------------------
 * CLEANUP (Optional but Professional)
 * --------------------------------------------------------
 */

// Remove WP version from <head>
remove_action('wp_head', 'wp_generator');

/**
 * --------------------------------------------------------
 * AJAX CONTACT FORM HANDLER
 * --------------------------------------------------------
 */
add_action('wp_ajax_nopriv_send_contact_email', 'handle_send_contact_email');
add_action('wp_ajax_send_contact_email', 'handle_send_contact_email');

function handle_send_contact_email() {
    check_ajax_referer('contact_form_nonce', 'nonce');

    $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
    if (empty($email) || !is_email($email)) {
        wp_send_json_error(array('message' => 'Invalid email address.'));
    }

    $to = 'hello@rohantvillarosa.in';
    $subject = 'New Project Inquiry from Portfolio';
    $message = "You have a new contact inquiry.\n\nAlight... I need a website\nResponder Email: " . $email;
    $headers = array('Content-Type: text/plain; charset=UTF-8', 'Reply-To: ' . $email);

    $sent = wp_mail($to, $subject, $message, $headers);

    if ($sent) {
        wp_send_json_success(array('message' => 'Email sent successfully.'));
    } else {
        wp_send_json_error(array('message' => 'Failed to send email.'));
    }
}


/**
 * --------------------------------------------------------
 * CUSTOM META BOXES FOR PROJECTS
 * --------------------------------------------------------
 */
function custom_portfolio_add_project_meta_boxes() {
    add_meta_box(
        'project_details_meta_box', // ID
        'Project Details', // Title
        'custom_portfolio_render_project_meta_box', // Callback
        'project', // Post type
        'normal', // Context
        'high' // Priority
    );
}
add_action('add_meta_boxes', 'custom_portfolio_add_project_meta_boxes');

function custom_portfolio_render_project_meta_box($post) {
    wp_nonce_field('save_project_meta_box', 'project_meta_box_nonce');

    $project_url = get_post_meta($post->ID, '_project_url', true);
    $project_description = get_post_meta($post->ID, '_project_description', true);
    
    // Get new array format
    $previews = get_post_meta($post->ID, '_project_previews', true);
    
    // Fallback to old format if array doesn't exist
    if (!is_array($previews)) {
        $previews = array();
        for ($i = 1; $i <= 4; $i++) {
            $old_val = get_post_meta($post->ID, '_project_preview_' . $i, true);
            if ($old_val) $previews[] = $old_val;
        }
    }
    
    // If still empty, default to 4 empty items
    if (empty($previews)) {
        $previews = array('', '', '', '');
    }
    
    // Output HTML
    echo '<style>
        .project-meta-row { margin-bottom: 15px; }
        .project-meta-row label { font-weight: bold; display: block; margin-bottom: 5px; }
        .project-meta-row input[type="url"], .project-meta-row textarea { width: 100%; max-width: 600px; }
        .project-meta-row textarea { height: 100px; }
        .project-meta-image-preview { max-width: 150px; display: block; margin-bottom: 10px; }
        .repeater-container { border: 1px solid #ddd; padding: 10px; margin-bottom: 15px; background: #fafafa; }
        .repeater-item { border-bottom: 1px dashed #ccc; padding-bottom: 10px; margin-bottom: 10px; position: relative; }
        .repeater-item:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
    </style>';

    echo '<div class="project-meta-row">';
    echo '<label for="project_url">Website URL</label>';
    echo '<input type="url" id="project_url" name="project_url" value="' . esc_attr($project_url) . '" />';
    echo '</div>';

    echo '<div class="project-meta-row">';
    echo '<label for="project_description">Small Description</label>';
    echo '<textarea id="project_description" name="project_description">' . esc_textarea($project_description) . '</textarea>';
    echo '</div>';

    echo '<div class="project-meta-row">';
    echo '<label>Previews (Image or Video)</label>';
    echo '<div id="previews_repeater" class="repeater-container">';
    
    foreach ($previews as $index => $preview_id) {
        $preview_url = $preview_id ? wp_get_attachment_url($preview_id) : '';
        $mime_type = $preview_id ? get_post_mime_type($preview_id) : '';
        $is_video = strpos($mime_type, 'video') === 0;
        
        echo '<div class="repeater-item">';
        echo '<div class="preview_media_container" style="margin-bottom: 10px;">';
        if ($preview_url) {
            if ($is_video) {
                echo '<video src="' . esc_url($preview_url) . '" controls style="max-width: 150px; display: block;"></video>';
            } else {
                echo '<img src="' . esc_url($preview_url) . '" style="max-width: 150px; display: block;" />';
            }
        }
        echo '</div>';
        echo '<input type="hidden" name="project_previews[]" class="preview-hidden-input" value="' . esc_attr($preview_id) . '" />';
        echo '<button type="button" class="button upload_image_button">Select Media</button>';
        echo ' <button type="button" class="button remove_image_button">Remove</button>';
        echo '</div>';
    }
    
    echo '</div>';
    echo '<button type="button" class="button" id="add_more_previews">Add More Previews</button>';
    echo '</div>';
}

function custom_portfolio_save_project_meta($post_id) {
    if (!isset($_POST['project_meta_box_nonce']) || !wp_verify_nonce($_POST['project_meta_box_nonce'], 'save_project_meta_box')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['project_url'])) {
        update_post_meta($post_id, '_project_url', sanitize_url($_POST['project_url']));
    }

    if (isset($_POST['project_description'])) {
        update_post_meta($post_id, '_project_description', sanitize_textarea_field($_POST['project_description']));
    }

    if (isset($_POST['project_previews']) && is_array($_POST['project_previews'])) {
        $clean_previews = array_map('sanitize_text_field', $_POST['project_previews']);
        update_post_meta($post_id, '_project_previews', array_values($clean_previews));
    } else {
        delete_post_meta($post_id, '_project_previews');
    }
}
add_action('save_post_project', 'custom_portfolio_save_project_meta');

/**
 * --------------------------------------------------------
 * ENQUEUE ADMIN SCRIPTS FOR MEDIA UPLOADER
 * --------------------------------------------------------
 */
function custom_portfolio_admin_scripts($hook) {
    global $post;

    if ($hook == 'post-new.php' || $hook == 'post.php') {
        if ('project' === $post->post_type) {
            wp_enqueue_media();
            wp_enqueue_script('custom-admin-media', get_stylesheet_directory_uri() . '/js/admin-media-uploader.js', array('jquery'), null, true);
        }
    }
}
add_action('admin_enqueue_scripts', 'custom_portfolio_admin_scripts');

/**
 * --------------------------------------------------------
 * CUSTOM META BOXES FOR ARCHIVES
 * --------------------------------------------------------
 */
function custom_portfolio_add_archive_meta_boxes() {
    add_meta_box(
        'archive_details_meta_box', // ID
        'Archive Details', // Title
        'custom_portfolio_render_archive_meta_box', // Callback
        'archive', // Post type
        'normal', // Context
        'high' // Priority
    );
}
add_action('add_meta_boxes', 'custom_portfolio_add_archive_meta_boxes');

function custom_portfolio_render_archive_meta_box($post) {
    wp_nonce_field('save_archive_meta_box', 'archive_meta_box_nonce');
    $archive_url = get_post_meta($post->ID, '_archive_url', true);
    
    echo '<div class="project-meta-row" style="margin-bottom: 15px;">';
    echo '<label for="archive_url" style="font-weight: bold; display: block; margin-bottom: 5px;">URL</label>';
    echo '<input type="url" id="archive_url" name="archive_url" value="' . esc_attr($archive_url) . '" style="width: 100%; max-width: 600px;" />';
    echo '</div>';
}

function custom_portfolio_save_archive_meta($post_id) {
    if (!isset($_POST['archive_meta_box_nonce']) || !wp_verify_nonce($_POST['archive_meta_box_nonce'], 'save_archive_meta_box')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['archive_url'])) {
        update_post_meta($post_id, '_archive_url', sanitize_url($_POST['archive_url']));
    }
}
add_action('save_post_archive', 'custom_portfolio_save_archive_meta');

/**
 * --------------------------------------------------------
 * CUSTOM META BOXES FOR CASE STUDY PAGE TEMPLATE
 * --------------------------------------------------------
 */
function custom_portfolio_add_case_study_meta_box() {
    add_meta_box(
        'case_study_meta_box', // ID
        'Case Study Details', // Title
        'custom_portfolio_render_case_study_meta_box', // Callback
        'archive', // Post type
        'normal', // Context
        'high' // Priority
    );
}
add_action('add_meta_boxes', 'custom_portfolio_add_case_study_meta_box');

function custom_portfolio_render_case_study_meta_box($post) {
    wp_nonce_field('save_case_study_meta', 'case_study_meta_nonce');
    
    $small_desc = get_post_meta($post->ID, '_cs_small_desc', true);
    $client = get_post_meta($post->ID, '_cs_client', true);
    $scope = get_post_meta($post->ID, '_cs_scope', true);
    $timeline = get_post_meta($post->ID, '_cs_timeline', true);
    $leads = get_post_meta($post->ID, '_cs_leads', true);
    
    echo '<div id="case-study-meta-wrapper">';
    
    echo '<div class="project-meta-row" style="margin-bottom: 15px;">';
    echo '<label for="cs_small_desc" style="font-weight: bold; display: block; margin-bottom: 5px;">Small Description</label>';
    echo '<textarea id="cs_small_desc" name="cs_small_desc" style="width: 100%; max-width: 600px; height: 80px;">' . esc_textarea($small_desc) . '</textarea>';
    echo '</div>';
    
    echo '<div class="project-meta-row" style="margin-bottom: 15px;">';
    echo '<label for="cs_client" style="font-weight: bold; display: block; margin-bottom: 5px;">Client</label>';
    echo '<input type="text" id="cs_client" name="cs_client" value="' . esc_attr($client) . '" style="width: 100%; max-width: 600px;" />';
    echo '</div>';
    
    echo '<div class="project-meta-row" style="margin-bottom: 15px;">';
    echo '<label for="cs_scope" style="font-weight: bold; display: block; margin-bottom: 5px;">Scope</label>';
    echo '<input type="text" id="cs_scope" name="cs_scope" value="' . esc_attr($scope) . '" style="width: 100%; max-width: 600px;" />';
    echo '</div>';
    
    echo '<div class="project-meta-row" style="margin-bottom: 15px;">';
    echo '<label for="cs_timeline" style="font-weight: bold; display: block; margin-bottom: 5px;">Timeline</label>';
    echo '<input type="text" id="cs_timeline" name="cs_timeline" value="' . esc_attr($timeline) . '" style="width: 100%; max-width: 600px;" />';
    echo '</div>';
    
    echo '<div class="project-meta-row" style="margin-bottom: 15px;">';
    echo '<label for="cs_leads" style="font-weight: bold; display: block; margin-bottom: 5px;">Leads / Month</label>';
    echo '<input type="text" id="cs_leads" name="cs_leads" value="' . esc_attr($leads) . '" style="width: 100%; max-width: 600px;" />';
    echo '</div>';

    // Add Context Description
    $context_desc = get_post_meta($post->ID, '_cs_context_desc', true);
    echo '<hr style="margin: 20px 0;">';
    echo '<div class="project-meta-row" style="margin-bottom: 15px;">';
    echo '<label for="cs_context_desc" style="font-weight: bold; display: block; margin-bottom: 5px;">Context Description</label>';
    echo '<textarea id="cs_context_desc" name="cs_context_desc" style="width: 100%; max-width: 600px; height: 100px;">' . esc_textarea($context_desc) . '</textarea>';
    echo '</div>';

    // Add Context Steps Repeater
    $context_steps = get_post_meta($post->ID, '_cs_context_steps', true);
    if (!is_array($context_steps)) $context_steps = array();
    
    echo '<div class="project-meta-row" style="margin-bottom: 15px;">';
    echo '<label style="font-weight: bold; display: block; margin-bottom: 5px;">Context Steps</label>';
    echo '<div id="context-steps-container">';
    foreach ($context_steps as $i => $step) {
        $label = isset($step['label']) ? esc_attr($step['label']) : '';
        $title = isset($step['title']) ? esc_attr($step['title']) : '';
        $is_problem = isset($step['is_problem']) && $step['is_problem'] ? 'checked' : '';
        
        echo '<div class="context-step-row" style="background: #f9f9f9; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc;">';
        echo '<input type="text" name="cs_context_steps['.$i.'][label]" value="'.$label.'" placeholder="Step Label (e.g. Step 1)" style="width: 30%; margin-right: 2%;" />';
        echo '<input type="text" name="cs_context_steps['.$i.'][title]" value="'.$title.'" placeholder="Step Title (e.g. Paper form)" style="width: 40%; margin-right: 2%;" />';
        echo '<label><input type="checkbox" name="cs_context_steps['.$i.'][is_problem]" value="1" '.$is_problem.' /> Is Problem?</label>';
        echo '<button type="button" class="button remove-step" style="float: right;">Remove</button>';
        echo '</div>';
    }
    echo '</div>';
    echo '<button type="button" class="button" id="add-context-step">Add Step</button>';
    echo '</div>';

    // Add Challenge Cards Repeater
    $challenge_cards = get_post_meta($post->ID, '_cs_challenge_cards', true);
    if (!is_array($challenge_cards)) $challenge_cards = array();
    
    echo '<hr style="margin: 20px 0;">';
    echo '<div class="project-meta-row" style="margin-bottom: 15px;">';
    echo '<label style="font-weight: bold; display: block; margin-bottom: 5px;">Challenge Cards</label>';
    echo '<div id="challenge-cards-container">';
    foreach ($challenge_cards as $i => $card) {
        $icon = isset($card['icon']) ? esc_url($card['icon']) : '';
        $text = isset($card['text']) ? esc_attr($card['text']) : '';
        
        echo '<div class="challenge-card-row" style="background: #f9f9f9; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; display: flex; align-items: center; gap: 10px;">';
        echo '<div><img src="'.$icon.'" class="challenge-icon-preview" style="width: 30px; height: 30px; object-fit: contain; display: '.($icon ? 'block' : 'none').';" /></div>';
        echo '<input type="hidden" name="cs_challenge_cards['.$i.'][icon]" class="challenge-icon-input" value="'.$icon.'" />';
        echo '<button type="button" class="button upload-icon-btn">Upload Icon</button>';
        echo '<input type="text" name="cs_challenge_cards['.$i.'][text]" value="'.$text.'" placeholder="Challenge Text" style="flex: 1;" />';
        echo '<button type="button" class="button remove-challenge">Remove</button>';
        echo '</div>';
    }
    echo '</div>';
    echo '<button type="button" class="button" id="add-challenge-card">Add Challenge Card</button>';
    echo '</div>';
    
    // Add Solution Section
    $solution_desc = get_post_meta($post->ID, '_cs_solution_desc', true);
    echo '<hr style="margin: 20px 0;">';
    echo '<div class="project-meta-row" style="margin-bottom: 15px;">';
    echo '<label for="cs_solution_desc" style="font-weight: bold; display: block; margin-bottom: 5px;">Solution Description</label>';
    echo '<textarea id="cs_solution_desc" name="cs_solution_desc" style="width: 100%; max-width: 600px; height: 100px;">' . esc_textarea($solution_desc) . '</textarea>';
    echo '</div>';

    // Add Solution Images Repeater
    $solution_images = get_post_meta($post->ID, '_cs_solution_images', true);
    if (!is_array($solution_images)) $solution_images = array();
    
    echo '<div class="project-meta-row" style="margin-bottom: 15px;">';
    echo '<label style="font-weight: bold; display: block; margin-bottom: 5px;">Solution Images</label>';
    echo '<div id="solution-images-container">';
    foreach ($solution_images as $i => $image) {
        $layout_type = isset($image['layout_type']) ? $image['layout_type'] : '1';
        $top_caption = isset($image['top_caption']) ? esc_attr($image['top_caption']) : '';
        
        $img_url = isset($image['url']) ? esc_url($image['url']) : '';
        $bottom_caption = isset($image['bottom_caption']) ? esc_attr($image['bottom_caption']) : '';
        
        $img_url2 = isset($image['url2']) ? esc_url($image['url2']) : '';
        $bottom_caption2 = isset($image['bottom_caption2']) ? esc_attr($image['bottom_caption2']) : '';
        
        echo '<div class="solution-image-row" style="background: #f9f9f9; padding: 15px; margin-bottom: 15px; border: 1px solid #ccc; position: relative;">';
        echo '<button type="button" class="button remove-solution-image" style="position: absolute; top: 10px; right: 10px;">Remove Row</button>';
        
        echo '<div style="margin-bottom: 10px;">';
        echo '<label style="font-weight: bold; margin-right: 10px;">Layout Type:</label>';
        echo '<select name="cs_solution_images['.$i.'][layout_type]" class="solution-layout-select">';
        echo '<option value="1" '.selected($layout_type, '1', false).'>Single Image</option>';
        echo '<option value="2" '.selected($layout_type, '2', false).'>Two Images</option>';
        echo '</select>';
        echo '</div>';
        
        echo '<div style="margin-bottom: 15px;">';
        echo '<label style="display:block; font-size:12px; color:#666;">Top Caption (Shared)</label>';
        echo '<input type="text" name="cs_solution_images['.$i.'][top_caption]" value="'.$top_caption.'" placeholder="Top Caption (e.g. Image 2 - Dashboard)" style="width: 100%;" />';
        echo '</div>';

        echo '<div style="display: flex; gap: 20px;">';
        
        // Image 1
        echo '<div class="solution-img-1-col" style="flex: 1;">';
        echo '<strong style="display:block; margin-bottom:5px;">Image 1</strong>';
        echo '<img src="'.$img_url.'" class="solution-img-preview" style="max-width: 100%; max-height: 150px; display: '.($img_url ? 'block' : 'none').'; margin-bottom: 5px;" />';
        echo '<input type="hidden" name="cs_solution_images['.$i.'][url]" class="solution-img-input" value="'.$img_url.'" />';
        echo '<button type="button" class="button upload-solution-img-btn" style="margin-bottom:10px;">Upload Image 1</button>';
        echo '<input type="text" name="cs_solution_images['.$i.'][bottom_caption]" value="'.$bottom_caption.'" placeholder="Bottom Description 1" style="width: 100%;" />';
        echo '</div>';
        
        // Image 2
        echo '<div class="solution-img-2-col" style="flex: 1; display: '.($layout_type == '2' ? 'block' : 'none').';">';
        echo '<strong style="display:block; margin-bottom:5px;">Image 2</strong>';
        echo '<img src="'.$img_url2.'" class="solution-img-preview" style="max-width: 100%; max-height: 150px; display: '.($img_url2 ? 'block' : 'none').'; margin-bottom: 5px;" />';
        echo '<input type="hidden" name="cs_solution_images['.$i.'][url2]" class="solution-img-input" value="'.$img_url2.'" />';
        echo '<button type="button" class="button upload-solution-img-btn" style="margin-bottom:10px;">Upload Image 2</button>';
        echo '<input type="text" name="cs_solution_images['.$i.'][bottom_caption2]" value="'.$bottom_caption2.'" placeholder="Bottom Description 2" style="width: 100%;" />';
        echo '</div>';
        
        echo '</div>'; // End Flex
        echo '</div>'; // End Row
    }
    echo '</div>';
    echo '<button type="button" class="button" id="add-solution-image">Add Image Row</button>';
    echo '</div>';

    // Add Role Cards Repeater
    $role_cards = get_post_meta($post->ID, '_cs_role_cards', true);
    if (!is_array($role_cards)) $role_cards = array();
    
    echo '<div class="project-meta-row" style="margin-bottom: 15px;">';
    echo '<label style="font-weight: bold; display: block; margin-bottom: 5px;">Role Cards (The Solution)</label>';
    echo '<div id="role-cards-container">';
    foreach ($role_cards as $i => $card) {
        $icon = isset($card['icon']) ? esc_url($card['icon']) : '';
        $title = isset($card['title']) ? esc_attr($card['title']) : '';
        $bullets = isset($card['bullets']) ? esc_textarea($card['bullets']) : '';
        
        echo '<div class="role-card-row" style="background: #f9f9f9; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; display: flex; flex-direction: column; gap: 10px;">';
        echo '<div style="display: flex; align-items: center; gap: 10px;">';
        echo '<div><img src="'.$icon.'" class="role-icon-preview" style="width: 30px; height: 30px; object-fit: contain; display: '.($icon ? 'block' : 'none').';" /></div>';
        echo '<input type="hidden" name="cs_role_cards['.$i.'][icon]" class="role-icon-input" value="'.$icon.'" />';
        echo '<button type="button" class="button upload-role-icon-btn">Upload Icon</button>';
        echo '<input type="text" name="cs_role_cards['.$i.'][title]" value="'.$title.'" placeholder="Role Title (e.g. Closing Manager)" style="flex: 1;" />';
        echo '<button type="button" class="button remove-role-card">Remove</button>';
        echo '</div>';
        echo '<textarea name="cs_role_cards['.$i.'][bullets]" placeholder="Bullet points (put each bullet on a new line)" style="width: 100%; height: 80px;">'.$bullets.'</textarea>';
        echo '</div>';
    }
    echo '</div>';
    echo '<button type="button" class="button" id="add-role-card">Add Role Card</button>';
    echo '</div>';
    
    // Add Solution Callout
    $solution_callout = get_post_meta($post->ID, '_cs_solution_callout', true);
    echo '<hr style="margin: 20px 0;">';
    echo '<div class="project-meta-row" style="margin-bottom: 15px;">';
    echo '<label for="cs_solution_callout" style="font-weight: bold; display: block; margin-bottom: 5px;">Solution Callout Box (Green Highlight at Bottom)</label>';
    echo '<textarea id="cs_solution_callout" name="cs_solution_callout" style="width: 100%; max-width: 600px; height: 80px;">' . esc_textarea($solution_callout) . '</textarea>';
    echo '</div>';

    echo '</div>'; // End callout wrapper

    // --- RESULTS & HIGHLIGHTS SECTION ---
    echo '<hr style="margin: 30px 0; border: 0; border-top: 2px solid #ccc;">';
    echo '<h3 style="margin-top:0;">Results & Highlights</h3>';

    // 1. Technical Highlights Repeater
    $tech_highlights = get_post_meta($post->ID, '_cs_tech_highlights', true);
    if (!is_array($tech_highlights)) $tech_highlights = array();
    
    echo '<div class="project-meta-row" style="margin-bottom: 25px;">';
    echo '<label style="font-weight: bold; display: block; margin-bottom: 5px;">Technical Highlights (Cards with Icons)</label>';
    echo '<div id="tech-highlights-container">';
    foreach ($tech_highlights as $i => $card) {
        $icon = isset($card['icon']) ? esc_url($card['icon']) : '';
        $title = isset($card['title']) ? esc_attr($card['title']) : '';
        
        echo '<div class="tech-highlight-row" style="background: #f9f9f9; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; display: flex; align-items: center; gap: 10px;">';
        echo '<div><img src="'.$icon.'" class="tech-icon-preview" style="width: 30px; height: 30px; object-fit: contain; display: '.($icon ? 'block' : 'none').';" /></div>';
        echo '<input type="hidden" name="cs_tech_highlights['.$i.'][icon]" class="tech-icon-input" value="'.$icon.'" />';
        echo '<button type="button" class="button upload-tech-icon-btn">Upload Icon</button>';
        echo '<input type="text" name="cs_tech_highlights['.$i.'][title]" value="'.$title.'" placeholder="Highlight Title (e.g. Role-based access)" style="flex: 1;" />';
        echo '<button type="button" class="button remove-tech-highlight">Remove</button>';
        echo '</div>';
    }
    echo '</div>';
    echo '<button type="button" class="button" id="add-tech-highlight">Add Technical Highlight</button>';
    echo '</div>';

    // 2. Result Stat Cards Repeater
    $result_stats = get_post_meta($post->ID, '_cs_result_stats', true);
    if (!is_array($result_stats)) $result_stats = array();
    
    echo '<div class="project-meta-row" style="margin-bottom: 25px;">';
    echo '<label style="font-weight: bold; display: block; margin-bottom: 5px;">Result Stat Cards</label>';
    echo '<div id="result-stats-container">';
    foreach ($result_stats as $i => $stat) {
        $large_stat = isset($stat['large_stat']) ? esc_attr($stat['large_stat']) : '';
        $subtitle = isset($stat['subtitle']) ? esc_attr($stat['subtitle']) : '';
        
        echo '<div class="result-stat-row" style="background: #f9f9f9; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; display: flex; align-items: center; gap: 10px;">';
        echo '<input type="text" name="cs_result_stats['.$i.'][large_stat]" value="'.$large_stat.'" placeholder="Large Stat (e.g. 150+)" style="width: 20%;" />';
        echo '<input type="text" name="cs_result_stats['.$i.'][subtitle]" value="'.$subtitle.'" placeholder="Subtitle (e.g. leads managed monthly)" style="flex: 1;" />';
        echo '<button type="button" class="button remove-result-stat">Remove</button>';
        echo '</div>';
    }
    echo '</div>';
    echo '<button type="button" class="button" id="add-result-stat">Add Result Stat</button>';
    echo '</div>';

    // 3. Results Bullet Points Textarea
    $result_bullets = get_post_meta($post->ID, '_cs_result_bullets', true);
    echo '<div class="project-meta-row" style="margin-bottom: 15px;">';
    echo '<label for="cs_result_bullets" style="font-weight: bold; display: block; margin-bottom: 5px;">Results Bullet Points (Checkmarks)</label>';
    echo '<p style="font-size: 12px; color: #666; margin-top: 0;">Put each bullet point on a new line. The green checkmark will be added automatically.</p>';
    echo '<textarea id="cs_result_bullets" name="cs_result_bullets" style="width: 100%; max-width: 800px; height: 120px;">' . esc_textarea($result_bullets) . '</textarea>';
    echo '</div>';

    echo '</div>'; // End Meta Box

    // Inline JS to handle media upload and toggle visibility based on template
    ?>
    <script>
    jQuery(document).ready(function($){
        var hideShowMetaBox = function() {
            if (typeof wp !== 'undefined' && wp.data && wp.data.select('core/editor')) {
                var template = wp.data.select('core/editor').getEditedPostAttribute('template');
                if (template === 'template-case-study.php') {
                    $('#case_study_meta_box').show();
                } else {
                    $('#case_study_meta_box').hide();
                }
            } else if ($('#page_template').length) {
                var template = $('#page_template').val();
                if (template === 'template-case-study.php') {
                    $('#case_study_meta_box').show();
                } else {
                    $('#case_study_meta_box').hide();
                }
            }
        };

        // Initial check with polling to ensure Gutenberg is fully loaded
        var checkInterval = setInterval(function() {
            if (typeof wp !== 'undefined' && wp.data && wp.data.select('core/editor')) {
                clearInterval(checkInterval);
                hideShowMetaBox();
                
                // Subscribe to changes
                wp.data.subscribe(function() {
                    hideShowMetaBox();
                });
            } else if ($('#page_template').length) {
                clearInterval(checkInterval);
                hideShowMetaBox();
                $('#page_template').on('change', hideShowMetaBox);
            }
        }, 500);
        
        // Timeout after 10 seconds to stop polling if wp.data is not found
        // Timeout after 10 seconds to stop polling if wp.data is not found
        setTimeout(function() { clearInterval(checkInterval); }, 10000);

        function createUploader(button, containerClass, inputClass, previewClass) {
            var container = button.closest(containerClass);
            if (!container.length) container = button.parent(); // fallback for solution layout
            
            var uploader = wp.media({
                title: 'Choose Image/Icon',
                button: { text: 'Choose File' },
                multiple: false
            });

            uploader.on('select', function() {
                var attachment = uploader.state().get('selection').first().toJSON();
                container.find(inputClass).val(attachment.url);
                container.find(previewClass).attr('src', attachment.url).show();
            });

            uploader.open();
        }

        $('body').on('click', '.upload-icon-btn', function(e) {
            e.preventDefault();
            createUploader($(this), '.challenge-card-row', '.challenge-icon-input', '.challenge-icon-preview');
        });

        $('body').on('click', '.upload-solution-img-btn', function(e) {
            e.preventDefault();
            createUploader($(this), '.solution-img-1-col, .solution-img-2-col', '.solution-img-input', '.solution-img-preview');
        });

        $('body').on('click', '.upload-role-icon-btn', function(e) {
            e.preventDefault();
            createUploader($(this), '.role-card-row', '.role-icon-input', '.role-icon-preview');
        });

        $('body').on('click', '.upload-tech-icon-btn', function(e) {
            e.preventDefault();
            createUploader($(this), '.tech-highlight-row', '.tech-icon-input', '.tech-icon-preview');
        });

        // Add Context Step
        var stepIndex = $('.context-step-row').length;
        $('#add-context-step').on('click', function() {
            var html = '<div class="context-step-row" style="background: #f9f9f9; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc;">' +
                '<input type="text" name="cs_context_steps['+stepIndex+'][label]" placeholder="Step Label (e.g. Step 1)" style="width: 30%; margin-right: 2%;" />' +
                '<input type="text" name="cs_context_steps['+stepIndex+'][title]" placeholder="Step Title (e.g. Paper form)" style="width: 40%; margin-right: 2%;" />' +
                '<label><input type="checkbox" name="cs_context_steps['+stepIndex+'][is_problem]" value="1" /> Is Problem?</label>' +
                '<button type="button" class="button remove-step" style="float: right;">Remove</button>' +
                '</div>';
            $('#context-steps-container').append(html);
            stepIndex++;
        });

        // Add Challenge Card
        var cardIndex = $('.challenge-card-row').length;
        $('#add-challenge-card').on('click', function() {
            var html = '<div class="challenge-card-row" style="background: #f9f9f9; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; display: flex; align-items: center; gap: 10px;">' +
                '<div><img src="" class="challenge-icon-preview" style="width: 30px; height: 30px; object-fit: contain; display: none;" /></div>' +
                '<input type="hidden" name="cs_challenge_cards['+cardIndex+'][icon]" class="challenge-icon-input" value="" />' +
                '<button type="button" class="button upload-icon-btn">Upload Icon</button>' +
                '<input type="text" name="cs_challenge_cards['+cardIndex+'][text]" placeholder="Challenge Text" style="flex: 1;" />' +
                '<button type="button" class="button remove-challenge">Remove</button>' +
                '</div>';
            $('#challenge-cards-container').append(html);
            cardIndex++;
        });

        // Toggle Solution Image Layout
        $('body').on('change', '.solution-layout-select', function() {
            var val = $(this).val();
            var row = $(this).closest('.solution-image-row');
            if (val == '2') {
                row.find('.solution-img-2-col').show();
            } else {
                row.find('.solution-img-2-col').hide();
                row.find('.solution-img-2-col .solution-img-input').val('');
                row.find('.solution-img-2-col .solution-img-preview').hide().attr('src', '');
                row.find('.solution-img-2-col input[type="text"]').val('');
            }
        });

        // Add Solution Image
        var solImgIndex = $('.solution-image-row').length;
        $('#add-solution-image').on('click', function() {
            var html = '<div class="solution-image-row" style="background: #f9f9f9; padding: 15px; margin-bottom: 15px; border: 1px solid #ccc; position: relative;">' +
                '<button type="button" class="button remove-solution-image" style="position: absolute; top: 10px; right: 10px;">Remove Row</button>' +
                
                '<div style="margin-bottom: 10px;">' +
                '<label style="font-weight: bold; margin-right: 10px;">Layout Type:</label>' +
                '<select name="cs_solution_images['+solImgIndex+'][layout_type]" class="solution-layout-select">' +
                '<option value="1">Single Image</option>' +
                '<option value="2">Two Images</option>' +
                '</select>' +
                '</div>' +
                
                '<div style="margin-bottom: 15px;">' +
                '<label style="display:block; font-size:12px; color:#666;">Top Caption (Shared)</label>' +
                '<input type="text" name="cs_solution_images['+solImgIndex+'][top_caption]" placeholder="Top Caption (e.g. Image 2 - Dashboard)" style="width: 100%;" />' +
                '</div>' +

                '<div style="display: flex; gap: 20px;">' +
                
                '<div class="solution-img-1-col" style="flex: 1;">' +
                '<strong style="display:block; margin-bottom:5px;">Image 1</strong>' +
                '<img src="" class="solution-img-preview" style="max-width: 100%; max-height: 150px; display: none; margin-bottom: 5px;" />' +
                '<input type="hidden" name="cs_solution_images['+solImgIndex+'][url]" class="solution-img-input" value="" />' +
                '<button type="button" class="button upload-solution-img-btn" style="margin-bottom:10px;">Upload Image 1</button>' +
                '<input type="text" name="cs_solution_images['+solImgIndex+'][bottom_caption]" placeholder="Bottom Description 1" style="width: 100%;" />' +
                '</div>' +
                
                '<div class="solution-img-2-col" style="flex: 1; display: none;">' +
                '<strong style="display:block; margin-bottom:5px;">Image 2</strong>' +
                '<img src="" class="solution-img-preview" style="max-width: 100%; max-height: 150px; display: none; margin-bottom: 5px;" />' +
                '<input type="hidden" name="cs_solution_images['+solImgIndex+'][url2]" class="solution-img-input" value="" />' +
                '<button type="button" class="button upload-solution-img-btn" style="margin-bottom:10px;">Upload Image 2</button>' +
                '<input type="text" name="cs_solution_images['+solImgIndex+'][bottom_caption2]" placeholder="Bottom Description 2" style="width: 100%;" />' +
                '</div>' +
                
                '</div>' + // End flex
                '</div>'; // End Row
            $('#solution-images-container').append(html);
            solImgIndex++;
        });

        // Add Role Card
        var roleCardIndex = $('.role-card-row').length;
        $('#add-role-card').on('click', function() {
            var html = '<div class="role-card-row" style="background: #f9f9f9; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; display: flex; flex-direction: column; gap: 10px;">' +
                '<div style="display: flex; align-items: center; gap: 10px;">' +
                '<div><img src="" class="role-icon-preview" style="width: 30px; height: 30px; object-fit: contain; display: none;" /></div>' +
                '<input type="hidden" name="cs_role_cards['+roleCardIndex+'][icon]" class="role-icon-input" value="" />' +
                '<button type="button" class="button upload-role-icon-btn">Upload Icon</button>' +
                '<input type="text" name="cs_role_cards['+roleCardIndex+'][title]" placeholder="Role Title (e.g. Closing Manager)" style="flex: 1;" />' +
                '<button type="button" class="button remove-role-card">Remove</button>' +
                '</div>' +
                '<textarea name="cs_role_cards['+roleCardIndex+'][bullets]" placeholder="Bullet points (put each bullet on a new line)" style="width: 100%; height: 80px;"></textarea>' +
                '</div>';
            $('#role-cards-container').append(html);
            roleCardIndex++;
        });

        // Add Technical Highlight
        var techIndex = $('.tech-highlight-row').length;
        $('#add-tech-highlight').on('click', function() {
            var html = '<div class="tech-highlight-row" style="background: #f9f9f9; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; display: flex; align-items: center; gap: 10px;">' +
                '<div><img src="" class="tech-icon-preview" style="width: 30px; height: 30px; object-fit: contain; display: none;" /></div>' +
                '<input type="hidden" name="cs_tech_highlights['+techIndex+'][icon]" class="tech-icon-input" value="" />' +
                '<button type="button" class="button upload-tech-icon-btn">Upload Icon</button>' +
                '<input type="text" name="cs_tech_highlights['+techIndex+'][title]" placeholder="Highlight Title (e.g. Role-based access)" style="flex: 1;" />' +
                '<button type="button" class="button remove-tech-highlight">Remove</button>' +
                '</div>';
            $('#tech-highlights-container').append(html);
            techIndex++;
        });

        // Add Result Stat
        var statIndex = $('.result-stat-row').length;
        $('#add-result-stat').on('click', function() {
            var html = '<div class="result-stat-row" style="background: #f9f9f9; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; display: flex; align-items: center; gap: 10px;">' +
                '<input type="text" name="cs_result_stats['+statIndex+'][large_stat]" placeholder="Large Stat (e.g. 150+)" style="width: 20%;" />' +
                '<input type="text" name="cs_result_stats['+statIndex+'][subtitle]" placeholder="Subtitle (e.g. leads managed monthly)" style="flex: 1;" />' +
                '<button type="button" class="button remove-result-stat">Remove</button>' +
                '</div>';
            $('#result-stats-container').append(html);
            statIndex++;
        });

        // Generic remove buttons
        $('body').on('click', '.remove-step', function() { $(this).closest('.context-step-row').remove(); });
        $('body').on('click', '.remove-challenge', function() { $(this).closest('.challenge-card-row').remove(); });
        $('body').on('click', '.remove-solution-image', function() { $(this).closest('.solution-image-row').remove(); });
        $('body').on('click', '.remove-role-card', function() { $(this).closest('.role-card-row').remove(); });
        $('body').on('click', '.remove-tech-highlight', function() { $(this).closest('.tech-highlight-row').remove(); });
        $('body').on('click', '.remove-result-stat', function() { $(this).closest('.result-stat-row').remove(); });

    });
    </script>
    <?php
}

function custom_portfolio_save_case_study_meta($post_id) {
    if (!isset($_POST['case_study_meta_nonce']) || !wp_verify_nonce($_POST['case_study_meta_nonce'], 'save_case_study_meta')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['cs_small_desc'])) update_post_meta($post_id, '_cs_small_desc', sanitize_textarea_field($_POST['cs_small_desc']));
    if (isset($_POST['cs_client'])) update_post_meta($post_id, '_cs_client', sanitize_text_field($_POST['cs_client']));
    if (isset($_POST['cs_scope'])) update_post_meta($post_id, '_cs_scope', sanitize_text_field($_POST['cs_scope']));
    if (isset($_POST['cs_timeline'])) update_post_meta($post_id, '_cs_timeline', sanitize_text_field($_POST['cs_timeline']));
    if (isset($_POST['cs_leads'])) update_post_meta($post_id, '_cs_leads', sanitize_text_field($_POST['cs_leads']));

    if (isset($_POST['cs_context_desc'])) update_post_meta($post_id, '_cs_context_desc', sanitize_textarea_field($_POST['cs_context_desc']));
    
    if (isset($_POST['cs_context_steps']) && is_array($_POST['cs_context_steps'])) {
        $clean_steps = array();
        foreach ($_POST['cs_context_steps'] as $step) {
            $clean_steps[] = array(
                'label' => sanitize_text_field($step['label']),
                'title' => sanitize_text_field($step['title']),
                'is_problem' => isset($step['is_problem']) ? 1 : 0
            );
        }
        update_post_meta($post_id, '_cs_context_steps', $clean_steps);
    } else {
        delete_post_meta($post_id, '_cs_context_steps');
    }

    if (isset($_POST['cs_challenge_cards']) && is_array($_POST['cs_challenge_cards'])) {
        $clean_cards = array();
        foreach ($_POST['cs_challenge_cards'] as $card) {
            $clean_cards[] = array(
                'icon' => sanitize_text_field($card['icon']),
                'text' => sanitize_text_field($card['text'])
            );
        }
        update_post_meta($post_id, '_cs_challenge_cards', $clean_cards);
    } else {
        delete_post_meta($post_id, '_cs_challenge_cards');
    }

    if (isset($_POST['cs_solution_desc'])) update_post_meta($post_id, '_cs_solution_desc', sanitize_textarea_field($_POST['cs_solution_desc']));

    if (isset($_POST['cs_solution_images']) && is_array($_POST['cs_solution_images'])) {
        $clean_images = array();
        foreach ($_POST['cs_solution_images'] as $img) {
            $clean_images[] = array(
                'layout_type' => isset($img['layout_type']) ? sanitize_text_field($img['layout_type']) : '1',
                'top_caption' => isset($img['top_caption']) ? sanitize_text_field($img['top_caption']) : '',
                'url' => isset($img['url']) ? sanitize_text_field($img['url']) : '',
                'bottom_caption' => isset($img['bottom_caption']) ? sanitize_text_field($img['bottom_caption']) : '',
                'url2' => isset($img['url2']) ? sanitize_text_field($img['url2']) : '',
                'bottom_caption2' => isset($img['bottom_caption2']) ? sanitize_text_field($img['bottom_caption2']) : ''
            );
        }
        update_post_meta($post_id, '_cs_solution_images', $clean_images);
    } else {
        delete_post_meta($post_id, '_cs_solution_images');
    }

    if (isset($_POST['cs_role_cards']) && is_array($_POST['cs_role_cards'])) {
        $clean_roles = array();
        foreach ($_POST['cs_role_cards'] as $role) {
            $clean_roles[] = array(
                'icon' => sanitize_text_field($role['icon']),
                'title' => sanitize_text_field($role['title']),
                'bullets' => sanitize_textarea_field($role['bullets']) // textarea preserves newlines
            );
        }
        update_post_meta($post_id, '_cs_role_cards', $clean_roles);
    } else {
        delete_post_meta($post_id, '_cs_role_cards');
    }

    if (isset($_POST['cs_solution_callout'])) update_post_meta($post_id, '_cs_solution_callout', sanitize_textarea_field($_POST['cs_solution_callout']));

    // Save Results & Highlights
    if (isset($_POST['cs_tech_highlights']) && is_array($_POST['cs_tech_highlights'])) {
        $clean_tech = array();
        foreach ($_POST['cs_tech_highlights'] as $tech) {
            $clean_tech[] = array(
                'icon' => esc_url_raw($tech['icon']),
                'title' => sanitize_text_field($tech['title'])
            );
        }
        update_post_meta($post_id, '_cs_tech_highlights', $clean_tech);
    } else {
        delete_post_meta($post_id, '_cs_tech_highlights');
    }

    if (isset($_POST['cs_result_stats']) && is_array($_POST['cs_result_stats'])) {
        $clean_stats = array();
        foreach ($_POST['cs_result_stats'] as $stat) {
            $clean_stats[] = array(
                'large_stat' => sanitize_text_field($stat['large_stat']),
                'subtitle' => sanitize_text_field($stat['subtitle'])
            );
        }
        update_post_meta($post_id, '_cs_result_stats', $clean_stats);
    } else {
        delete_post_meta($post_id, '_cs_result_stats');
    }

    if (isset($_POST['cs_result_bullets'])) {
        update_post_meta($post_id, '_cs_result_bullets', sanitize_textarea_field($_POST['cs_result_bullets']));
    }
}
add_action('save_post_archive', 'custom_portfolio_save_case_study_meta');

// Allow SVG Uploads
function custom_portfolio_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'custom_portfolio_mime_types');
