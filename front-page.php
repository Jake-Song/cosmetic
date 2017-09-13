<?php
  /*
  Template Name: Front Page
  */
  get_header();
?>

    <div class="content-box">

    <?php include( locate_template( '/module/product-menu.php', false, false ) ); ?>

        <div class="filter">
          <ul>
            <li>
              <a href="./top-30">
                <img src="./wp-content/themes/cosmetic/img/top30.png" alt="">
                <div class="">
                  Top 30
                </div>
              </a>
            </li>
            <li>
              <a href="./sort-by-brand">
                <img src="./wp-content/themes/cosmetic/img/brand-flat-icons.svg" alt="">
                <div>
                  Sort By Brand
                </div>
              </a>
            </li>
            <li>
              <a href="./new-arrival">
                <img src="./wp-content/themes/cosmetic/img/new-icon.png" alt="">
                <div>
                  New Arrival
                </div>
              </a>
            </li>
          </ul>
        </div>

      <div class="ajax-container">

        <div class="category-title">
          <h4>By Category</h4>
          <h2>Best Goods - Top 5</h2>
        </div>

        <?php

          $paged = array();

          foreach( $terms as $key => $term ) :

           if( $term->parent === 0) : // only top level

              $paged[$key] = isset( $_GET['page'.$key] ) ? (int) $_GET['page'.$key] : 1;

                $args[$key] = array(
                  'post_type' => 'cosmetic',
                  'tax_query' => array(
                    array(
                      'taxonomy' => 'cosmetic_category',
                      'field' => 'slug',
                      'terms' => $term->slug,
                    ),
                  ),
                  'orderby'   => 'meta_value_num',
          	      'meta_key'  => 'product_ranking_order',
                  'order' => 'ASC',
                  'posts_per_page' => 5,
                  'paged' => $paged[$key],

                );
                $query[$key] = new WP_Query( $args[$key] );

          ?>

              <article class="post clearfix" data-slug="<?php echo esc_attr($term->slug); ?>">

              <?php if( $query[$key]->have_posts() ) :

                $max_num_pages = $query[$key]->max_num_pages;

                $hidden_info = "<div class='hidden max-num-pages'>{$max_num_pages}</div>";

                echo $hidden_info;
              ?>
                    <h4 class="cosmetic-category"><?php echo strtoupper($term->name); ?></h4>

                    <div class="post-modified">
                      <?php
                        $latest = new WP_Query(
                            array(
                                'post_type' => 'cosmetic',
                                'post_status' => 'publish',
                                'posts_per_page' => 1,
                                'tax_query' => array(
                                  array(
                                    'taxonomy' => 'cosmetic_category',
                                    'field' => 'slug',
                                    'terms' => $term->slug,
                                  ),
                                ),
                                'orderby' => 'modified',
                                'order' => 'DESC'
                            )
                        );

                        if($latest->have_posts()){
                            $modified_date = get_the_modified_date(('m/d/Y'), $latest->post->ID);
                        }
                        echo 'Last updated: ' . $modified_date;
                      ?>
                    </div>

                    <div class="product-row" data-page="1">

                      <?php

                        while( $query[$key]->have_posts()) : $query[$key]->the_post();

                            include( locate_template( '/module/grid.php', false, false ) );

                        endwhile;

                        $test = 0;

                        if( count( $query[$key]->posts ) % 5 !== 0 ) :
                          for( $i = 0; $i < 5 - (count( $query[$key]->posts ) % 5); $i++ ) :
                        ?>
                            <div class="col-sm-12 col-md-4 col-lg-4 spare"></div>
                      <?php
                          endfor;
                        endif;
                      ?>

                  </div>

            <?php

                  wp_reset_postdata();

              endif;
            ?>
            <?php if( $max_num_pages > 1) : ?>
               <div class="pagination-arrow-down"></div>
               <a class="loadmore" name="loadmore">
                 More
               </a>
            <?php endif; ?>
             </article>

         <?php endif; // only top level end ?>

        <?php endforeach; ?>
      </div>
  </div>
<?php get_footer(); ?>
