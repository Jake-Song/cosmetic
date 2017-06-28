<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta name="viewport" content="width=device-width">
        <meta charset="<?php bloginfo('charset'); ?>">
        <title><?php bloginfo('name'); ?></title>
        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>
        <div class="container">
            <header class="site-header">
                <h2><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></h2>
                <h5><?php bloginfo('description'); ?></h5>
                <nav class="site-nav">

                    <?php
                      $args = array(
                        'theme_location' => 'primary'
                      );
                     ?>

                    <?php wp_nav_menu( $args ); ?>
                </nav>
            </header>
