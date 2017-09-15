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
      <div class="content-box">

        <?php include( locate_template( '/module/product-menu.php', false, false ) ); ?>

        <div class="wrapper-for-ajax">

          <div class="template-title">
            <h4>Overall Category</h4>
            <h2>Top 30</h2>
          </div>
          <h4 class="cosmetic-title">All Goods</h4>

          <article class="post clearfix">

            <?php include( locate_template( '/module/modified_date.php', false, false ) ); ?>

            <?php

            if( $query->have_posts() ) :

                while( $query->have_posts()) : $query->the_post();

                    include( locate_template( '/module/grid.php', false, false ) );

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
