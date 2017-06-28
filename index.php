<?php get_header(); ?>
      <div class="container">
          <header class="site-header">
              <h2><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></h2>
              <h5><?php bloginfo('description'); ?></h5>
          </header>

          <?php
              if(have_posts()) :
                  while(have_posts()) : the_post(); ?>
                      <article class="post">
                          <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                          <?php the_content(); ?>
                      </article>
            <?php endwhile;
              else :
                  echo '포스트가 존재하지 않습니다.';
              endif;
           ?>
<?php get_footer(); ?>           
