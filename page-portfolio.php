<?php get_header(); ?>
    <?php
        if(have_posts()) :
            while(have_posts()) : the_post(); ?>
                <article class="post page clearfix">
                    <div class="title-column">
                        <h2><?php the_title(); ?></h2>
                    </div>
                    <div class="content-column">
                        <?php the_content(); ?>
                    </div>
                </article>
      <?php endwhile;
        else :
            echo '포스트가 존재하지 않습니다.';
        endif;

     ?>
 <?php get_footer(); ?>
