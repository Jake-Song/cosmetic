<?php
/*
Template Name: Archive New Arrival
*/
 ?>

<?php get_header(); ?>
    <?php

        $args = array(
            'post_type' => 'cosmetic',
            'post_status' => 'publish',
            'order-by' => 'ID',
            
        );
          $query = new WP_Query( $args );

        ?>
      <div class="content-box">

        <?php include( locate_template( '/module/product-menu.php', false, false ) ); ?>

        <div class="wrapper-for-ajax">

          <div class="template-title">
            <h4>By Brand</h4>
            <h2>Best Goods - Top 5</h2>
          </div>

          <?php get_template_part( '/module/ajax_preloader' ); ?>

          <article class="post new clearfix">

            <h4 class="cosmetic-title">New Arrival.</h2>

            <?php include( locate_template( '/module/modified_date.php', false, false ) ); ?>

            <?php

            if( $query->have_posts() ) :

                $max_num_pages = $query->max_num_pages;

                $hidden_info = "<div class='hidden max-num-pages'>{$max_num_pages}</div>";

                echo $hidden_info;
              ?>

              <div class="product-row" data-page="1">

              <?php
                while( $query->have_posts()) : $query->the_post();

                  include( locate_template( './module/grid.php', false, false ) );

                endwhile;

                if( count( $query->posts ) % 5 !== 0 ) :
                  for( $i = 0; $i < 5 - (count( $query->posts ) % 5); $i++ ) :
                ?>
                    <div class="col-sm-12 col-md-4 col-lg-4 spare"></div>
                <?php
                  endfor;

                endif;
                 ?>

               </div>

          <?php
            wp_reset_postdata();

            else :
                echo '포스트가 존재하지 않습니다.';
            endif;
         ?>

         <?php if( $max_num_pages > 1) : ?>
            <div class="pagination-arrow-down"></div>
            <a class="loadmore" name="loadmore" data-action="new_pagination" data-template="new">
              More
            </a>
         <?php endif; ?>

         </article>

       </div>

     </div>


<?php get_footer(); ?>
