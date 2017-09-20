<?php
/*
Template Name: Archive Brand
*/
?>
<?php get_header(); ?>


    <div class="content-box">

    <?php include( locate_template( '/module/product-menu.php', false, false ) ); ?>

    <?php get_template_part( '/module/ajax-navigation' ); ?>

    <div class="ajax-container">
      
      <div class="wrapper-for-ajax">

        <div class="template-title">
          <h4>By Brand</h4>
          <h2>Best Goods - Top 5</h2>
        </div>

      <?php get_template_part( '/module/ajax_preloader' ); ?>

      <?php

        $terms = get_terms(
          array(
            'taxonomy' => 'cosmetic_brand',
            'hide_empty' => 0,
            'orderby' => 'ID',
          ));
      ?>

      <?php
        foreach( $terms as $key => $term ) :

            $args[$key] = array(
              'post_type' => 'cosmetic',
              'tax_query' => array(
                array(
                  'taxonomy' => 'cosmetic_brand',
                  'field' => 'slug',
                  'terms' => $term->slug,
                ),
              ),
              'orderby'   => 'meta_value_num',
      	      'meta_key'  => 'product_brand_order',
              'order' => 'ASC',
            );
            $query[$key] = new WP_Query( $args[$key] );

          ?>

            <article class="post brand clearfix" data-slug="<?php echo esc_attr($term->slug); ?>">

              <h4 class="cosmetic-title"><?php echo strtoupper($term->name) . ' - TOP 5'; ?></h4>

              <?php

                include( locate_template( '/module/modified_date.php', false, false ) );

                if( $query[$key]->have_posts() ) :

                    $max_num_pages = $query[$key]->max_num_pages;

                    $hidden_info = "<div class='hidden max-num-pages'>{$max_num_pages}</div>";

                    echo $hidden_info;
              ?>
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

              else :
                  echo '포스트가 존재하지 않습니다.';
              endif;
           ?>

           <?php if( $max_num_pages > 1) : ?>
              <div class="pagination-arrow-down"></div>
              <a class="loadmore" name="loadmore" data-template="brand" data-action="brand_pagination">
                More
              </a>
           <?php endif; ?>

           </article>

      <?php endforeach; ?>

        </div>
      </div>
    </div>

<?php get_footer(); ?>
