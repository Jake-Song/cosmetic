<?php get_header(); ?>
    <?php
        if(have_posts()) :
            while(have_posts()) : the_post(); ?>
                <article class="post page">
                   <h2><?php echo get_the_title( get_top_parent_id() ); ?></h2>
                   <div class="content-box">
                        <nav class="site-nav sub-nav">
                            <ul>
                            <?php
                                $args = array(
                                    'child_of' => get_top_parent_id(),
                                    'title_li' => '',
                                );
                             ?>
                            <?php wp_list_pages( $args ); ?>
                            </ul>
                        </nav>
                        <?php the_content(); ?>
                    </div>
                </article>
      <?php endwhile;
        else :
            echo '포스트가 존재하지 않습니다.';
        endif;

     ?>
 <?php get_footer(); ?>
