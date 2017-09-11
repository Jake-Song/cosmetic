<div class="col-sm-12 col-md-4 col-lg-4 post-id-<?php echo esc_attr( get_the_ID() ); ?>">

  <div class="thumbnail">

    <?php if( has_post_thumbnail() ) : ?>

      <div class="thumbnail-image">

        <div class="thumbnail-header">

          <?php

            if( !is_page_template( 'page-templates/template-favorite.php' )
                && !is_page_template( 'page-templates/template-new.php' )
                && !is_search() ) :

          ?>

          <div class="ranking-icon">

            <?php
            $test = 0;
            global $pagename;

            switch ($pagename) {

              case '':

                  $ranking_count = get_post_meta( get_the_ID(), 'product_ranking_order', true );

                break;

              case 'top-30':

                  $ranking_count = get_post_meta( get_the_ID(), 'product_featured_order', true );

                break;

              case 'descendant':

                $ranking_count = get_post_meta( get_the_ID(), 'product_descendant_order', true );

                break;

              case 'sort-by-brand':

                $ranking_count = get_post_meta( get_the_ID(), 'product_brand_order', true );

                break;

            }

                switch ($ranking_count) {
                  case 1 : ?>
                    <i class="icon-trophy-3 first"></i>
              <?php break;
                  case 2 : ?>
               <i class="icon-trophy-3 second"></i>
              <?php break;
                  case 3 : ?>
                    <i class="icon-trophy-3 third"></i>
              <?php break;
                  default: ?>
                    <i class="icon-trophy-3 empty"></i>
              <?php break;
                }
              ?>

          </div>

          <div class="ranking-index">

      <?php echo $ranking_count; ?>

            <div class="ranking-changed">

              <?php cosmetic_ranking_index(); ?>

            </div>

          </div>

        <?php endif; ?>

          <div class="favorite-save-button">
            <?php cosmetic_favorite_save_button(); ?>
          </div>
      </div>

        <a href="<?php the_permalink(); ?>">
          <?php the_post_thumbnail( 'custom' ); ?>
        </a>
      </div>
    <?php endif; ?>

      <div class="caption clearfix">
        <div class="thumbnail-content">

          <?php the_title(); ?>

        </div>
        <div class="thumbnail-footer">

            <div class="price-and-favorite">
              <div class="product-price">
                <?php
                  $product_price = get_post_meta( get_the_ID(), 'product_price', true );
                  if( !empty( $product_price ) ) echo '$' . $product_price;
                ?>
              </div>
              <div class="favorite">
                <span class="favorite-icon">

                    <img src="<?php echo site_url(); ?>/wp-content/themes/cosmetic/img/wishlist-icon.svg" alt="">

                </span>
                <span class="favorite-count post-id-<?php the_ID(); ?>">
                  <?php
                    $favorite_count = !empty(get_post_meta( $post->ID, 'favorite_count', true )) ?
                    get_post_meta( $post->ID, 'favorite_count', true ) : 0;
                    echo $favorite_count . ' Saves';
                  ?>
                </span>
              </div>
            </div>

            <div class="check-out-button">
              <?php
                $checkout_url = !empty( get_post_meta( $post->ID, 'checkout_url', true ) )
                ? get_post_meta( $post->ID, 'checkout_url', true ) : '';
               ?>
              <a href="<?php echo esc_url($checkout_url); ?>" target="_blank" class="btn btn-primary" role="button">
                 Check It Out
              </a>
            </div>
        </div>
      </div>
  </div>
</div>
