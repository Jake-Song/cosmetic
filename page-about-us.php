<?php get_header(); ?>
    <?php
        if(have_posts()) :
            while(have_posts()) : the_post(); ?>
                <article class="post page">
                    <h2><?php the_title(); ?> - 회사소개 페이지입니다.</h2>
                    <?php the_content(); ?>
                </article>
      <?php endwhile;
        else :
            echo '포스트가 존재하지 않습니다.';
        endif;

     ?>
 <?php get_footer(); ?>
