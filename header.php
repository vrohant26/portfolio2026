<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body  <?php body_class(); ?> data-barba="wrapper">
<?php wp_body_open(); ?>

<header   class="site-header p-sm  w-full flex justify-between">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo fit-content">
      <svg  viewBox="0 0 56 42"  xmlns="http://www.w3.org/2000/svg">
        <path d="M0 0H14V42H0V0Z" />
        <path d="M0 0H28V14H0V0Z" />
        <path d="M42 0H56V14H42V0Z" />
        <path d="M28 14H42V28H28V14Z" />
        <path d="M42 28H56V42H42V28Z" />
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

<div id="grained-container"></div>