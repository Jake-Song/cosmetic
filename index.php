<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta name="viewport" content="width=device-width">
        <meta charset="<?php bloginfo('charset'); ?>">
        <title><?php bloginfo('name'); ?></title>
        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>

        <header class="site-header">
            <h2><?php bloginfo('name'); ?></h2>
            <h5><?php bloginfo('description'); ?></h5>
        </header>

        <?php
            if(have_posts()) :
                while(have_posts()) : the_post(); ?>
                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <?php the_content(); ?>
          <?php endwhile;
            else :
                echo '포스트가 존재하지 않습니다.';
            endif;
         ?>
         <footer class="site-footer">
            <p><?php bloginfo('name') ?> - &copy; <?php echo date('Y'); ?></p>
         </footer>
         <?php wp_footer(); ?>
   </body>
</html>
