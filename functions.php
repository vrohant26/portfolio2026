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
        'supports'           => array( 'title', 'thumbnail', 'excerpt', 'custom-fields' ),
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
