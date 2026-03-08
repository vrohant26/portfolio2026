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

    $to = 'hey@rohantvillarosa.in';
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

