<?php
/*
Template Name: Archive Brand
*/
?>
<?php get_header(); ?>
    <?php

      $terms = get_terms(
        array(
          'taxonomy' => 'cosmetic_brand',
          'hide_empty' => 0,
          'orderby' => 'ID',
        ));

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
    	      'meta_key'  => 'product_ranking_order',
            'order' => 'ASC',
          );
          $query[$key] = new WP_Query( $args[$key] );

        ?>
        <article class="post clearfix">

          <h2><?php echo 'TOP 3 - ' . strtoupper($term->name); ?></h2>

          <?php

          if( $query[$key]->have_posts() ) :

              while( $query[$key]->have_posts()) : $query[$key]->the_post(); ?>

                  <div class="col-sm-12 col-md-2 col-lg-2">
                    <div class="thumbnail">
                      <?php if( has_post_thumbnail() ) : ?>
                        <div class="thumbnail-image">
                          <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail( 'custom' ); ?>
                          </a>
                        </div>
                      <?php endif; ?>
                        <div class="caption clearfix">
                          <div class="thumbnail-content">
                            <h3><?php the_title(); ?></h3>
                            <?php the_excerpt(); ?>
                          </div>
                          <p class="thumbnail-footer">
                              <span class="product-price">
                                <?php
                                  $product_price = get_post_meta( get_the_ID(), 'product_price', true );
                                  if( !empty( $product_price ) ) echo '$' . $product_price;
                                ?>
                              </span>
                              <a href="#" target="_blank" class="btn btn-primary" role="button">Check Out</a>
                          </p>
                        </div>
                    </div>
                  </div>

        <?php endwhile;

          wp_reset_postdata();

          else :
              echo '포스트가 존재하지 않습니다.';
          endif;
       ?>
       </article>

    <?php endforeach; ?>

<?php get_footer(); ?>