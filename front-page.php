<?php get_header(); ?>

    <div class="content-box">

        <div class="filter">
          <ul>
            <li><a href="./top-30">Top 30</a></li>
            <li><a href="./sort-by-brand">Sort By Brand</a></li>
            <li><a href="./new-arrival">New Arrival</a></li>
          </ul>
        </div>

      <div class="ajax-container">

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
              <div class="bd"></div>

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

      </div>
  </div>
<?php get_footer(); ?>
