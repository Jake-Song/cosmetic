<?php
/*
Template Name: Archive Top 30
*/
?>
<?php get_header(); ?>
    <?php
    
          $args = array(
            'post_type' => 'cosmetic',
            'meta_query' => array(
              array(
                'key' => 'product_featured',
                'value' => 'featured',
              ),
              array(
                'key' => 'product_featured_order',
                'value_num' => '30',
                'compare' => '=<',
              ),
            ),
            'orderby'   => 'meta_value_num',
            'meta_key'  => 'product_featured_order',
            'order' => 'ASC',
          );
          $query = new WP_Query( $args );

        ?>
        <article class="post clearfix">

          <h2>Top 30</h2>

          <?php

          if( $query->have_posts() ) :

              $ranking_count = 1;

              while( $query->have_posts()) : $query->the_post();

                  include( locate_template( '/module/grid.php', false, false ) );

                $ranking_count++;

              endwhile;

          wp_reset_postdata();

          else :
              echo '포스트가 존재하지 않습니다.';
          endif;
       ?>
       </article>

<?php get_footer(); ?>
