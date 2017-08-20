<?php
/*
Template Name: Archive New Arrival
*/
 ?>

<?php get_header(); ?>
    <?php

        $args = array(
            'post_type' => 'cosmetic',
            'orderby' => 'ID',
            'posts_per_page' => -1,
          );
          $query = new WP_Query( $args );

        ?>
        <article class="post clearfix">

          <h2>New Arrival.</h2>

          <?php

          if( $query->have_posts() ) :

              $ranking_count = 1;

              while( $query->have_posts()) : $query->the_post();

                include( locate_template( './module/grid.php', false, false ) );
                $ranking_count++;

              endwhile;

          wp_reset_postdata();

          else :
              echo '포스트가 존재하지 않습니다.';
          endif;
       ?>
       </article>



<?php get_footer(); ?>
