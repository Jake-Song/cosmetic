<?php get_header(); ?>
    <?php
      $args = array(
        'post_type' => 'cosmetic',
        'tax_query' => array(
          array(
            'taxonomy' => 'category',
            'field' => 'slug',
            'terms' => 'skin-care',
          ),
        ),
        'orderby'   => 'meta_value_num',
	      'meta_key'  => 'product_ranking_order',
        'order' => 'ASC',
      );
      $query1 = new WP_Query( $args );
      
    ?>
    <article class="post clearfix">
      <?php

      if( $query1->have_posts() ) :

          while( $query1->have_posts()) : $query1->the_post(); ?>

              <div class="col-sm-12 col-md-4 col-lg-4">
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
<?php get_footer(); ?>
