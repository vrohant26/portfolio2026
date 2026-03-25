<?php
/**
 * Template Name: Coming Soon
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Coming Soon | <?php bloginfo( 'name' ); ?></title>
    <?php wp_head(); ?>
    <style>
        body, html {
            height: 100vh;
            margin: 0;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: var(--dark);
            color: var(--light);
            font-family: 'Nippo', sans-serif;
        }
        .coming-soon-container {
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: var(--xs-spacing);
        }
        .coming-soon-container h1 {
            font-size: var(--fs-sm);
            font-weight: 300;
            margin: 0;
            letter-spacing: 0.05em;
        }
        .coming-soon-container a {
            font-size: var(--fs-xs);
            color: var(--gray-500);
            transition: color 0.3s ease;
        }
        .coming-soon-container a:hover {
            color: var(--light);
        }
    </style>
</head>
<body id="grained-container" <?php body_class(); ?>>
    
    <div class="coming-soon-container">
        <h1>Coming Soon.</h1>
        <a class="scramble" href="mailto:hello@rohantvillarosa.in">hello@rohantvillarosa.in</a>
    </div>

    <?php wp_footer(); ?>
</body>
</html>
