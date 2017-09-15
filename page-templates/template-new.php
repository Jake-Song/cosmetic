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
            'posts_per_page' => 10,
        );
          $query = new WP_Query( $args );

        ?>
      <div class="content-box">

        <?php include( locate_template( '/module/product-menu.php', false, false ) ); ?>

        <div class="wrapper-for-ajax">

          <div class="template-title">
            <h4 class="cosmetic-brand">By Brand</h4>
            <h2>Best Goods - Top 5</h2>
          </div>

          <article class="post new clearfix">

            <h4 class="cosmetic-title">New Arrival.</h2>

            <?php include( locate_template( '/module/modified_date.php', false, false ) ); ?>

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

       </div>

     </div>


<?php get_footer(); ?>
