<div class="col-sm-12 col-md-4 col-lg-4">

  <div class="thumbnail">

    <?php if( has_post_thumbnail() ) : ?>
      <div class="thumbnail-image">

        <div class="ranking-index">
          <div class="ranking">
            <?php echo $ranking_count; ?>
          </div>
          <div class="ranking-changed">

          <?php cosmetic_ranking_index(); ?>

          </div>
        </div>

        <?php cosmetic_favorite_save_button(); ?>

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
        <div class="thumbnail-footer">
          <div class="favorite-and-price">
            <div class="product-price">
              <?php
                $product_price = get_post_meta( get_the_ID(), 'product_price', true );
                if( !empty( $product_price ) ) echo '$' . $product_price;
              ?>
            </div>
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
            <a href="#" target="_blank" class="btn btn-primary" role="button">Check Out</a>
        </div>
      </div>
  </div>
</div>
