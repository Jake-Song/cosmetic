<?php get_header(); ?>

    <div class="content-box">

      <div class="title-box">
        <h2><?php echo ucfirst( the_title() ); ?></h2>
      </div>

    <?php
        if(have_posts()) :
            while(have_posts()) : the_post(); ?>

                <article class="post page about-us">
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
            echo 'There is no post here.';
        endif;

     ?>

   </div>

 <?php get_footer(); ?>
