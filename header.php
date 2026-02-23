<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head> 
<body id="grained-container" <?php body_class(); ?> data-barba="wrapper">
<?php wp_body_open(); ?>

<header   class="site-header p-sm  w-full flex justify-between">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo fit-content">
     <svg  viewBox="0 0 55 39" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M28 10C28 11.1046 28.8954 12 30 12H39C40.1046 12 41 11.1046 41 10V2C41 0.895431 41.8954 0 43 0H53C54.1046 0 55 0.895431 55 2V12C55 13.1046 54.1046 14 53 14H43C41.8954 14 41 14.8954 41 16V23C41 24.1046 41.8954 25 43 25H53C54.1046 25 55 25.8954 55 27V37C55 38.1046 54.1046 39 53 39H43C41.8954 39 41 38.1046 41 37V28C41 26.8954 40.1046 26 39 26H29C27.8954 26 27 25.1046 27 24V16C27 14.8954 26.1046 14 25 14H16C14.8954 14 14 14.8954 14 16V37C14 38.1046 13.1046 39 12 39H2C0.89543 39 0 38.1046 0 37V2C0 0.89543 0.895431 0 2 0H26C27.1046 0 28 0.895431 28 2V10Z" />
</svg>
    </a>
      <nav class="fs-xs text-gray-500">
        <ul class="flex direction-column">
            <li><a class="scramble" href="<?php echo esc_url( home_url( '/' ) ); ?>">Work</a></li>
            <li><a class="scramble" href="<?php echo esc_url( home_url( '/about' ) ); ?>">About</a></li>
            <li><a class="scramble" href="<?php echo esc_url( home_url( '/archive' ) ); ?>">Archive</a></li>
            <li><a class="scramble" href="<?php echo esc_url( home_url( '/insights' ) ); ?>">Insights</a></li>
        </ul>
      </nav>

      <div id="theme-toggle" class="mood fit-content flex direction-column fs-xs" >
        <span class="text-light">mood</span>
          <span id="theme-status" class="cursor-pointer  text-gray-500"></span>
      </div>

    <div class="cta fit-content flex align-center gap-xs mobile-hide  corner-border">
      <div class="blinking"></div>
      <a class="fs-xs scramble" href="<?php echo esc_url( home_url( '/contact' ) ); ?>">Hire me, I swear im good</a>
    </div>
</header>

<main 
 
  data-barba="container" 
  data-barba-namespace="<?php echo is_front_page() ? 'work' : esc_attr( get_post_field( 'post_name', get_post() ) ); ?>">

