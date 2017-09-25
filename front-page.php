<?php
  /*
  Template Name: Front Page
  */
  get_header();
?>

    <div class="content-box">

    <?php include( locate_template( '/module/product-menu.php', false, false ) ); ?>

      <?php get_template_part( '/module/ajax-navigation' ); ?>

      <div class="ajax-container">

        <div class="wrapper-for-ajax">

          <div class="template-title">
            <h4>By Category</h4>
            <h2>Best Goods - Top 5</h2>
          </div>

          <?php get_template_part( '/module/ajax_preloader' ); ?>

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
                      <h4 class="cosmetic-title"><?php echo strtoupper($term->name); ?></h4>

                      <?php include( locate_template( '/module/modified_date.php', false, false ) ); ?>

                      <div class="product-row" data-page="1">

                        <?php

                          while( $query[$key]->have_posts()) : $query[$key]->the_post();

                              include( locate_template( '/module/grid.php', false, false ) );

                          endwhile;

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
              <?php if( $max_num_pages > 1 && $max_num_pages ) : ?>
                 <div class="pagination-arrow-down"></div>
                 <a class="loadmore" name="loadmore" data-action="front_page_pagination" data-template="front-page">
                   More
                 </a>
              <?php endif; ?>
               </article>

           <?php endif; // only top level end ?>

          <?php endforeach; ?>
        </div>

    </div>

  </div>

<?php get_footer(); ?>
