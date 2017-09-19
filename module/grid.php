<div class="col-sm-12 col-md-4 col-lg-4 post-id-<?php echo esc_attr( get_the_ID() ); ?>">

  <div class="thumbnail">

    <?php if( has_post_thumbnail() ) : ?>

      <div class="thumbnail-image">

        <div class="thumbnail-header">

        <?php
          $test = 0;
          if( !isset( $template_for_ajax ) ){
            $template_for_ajax = '';
          }

          if( !is_page_template( 'page-templates/template-favorite.php' )
              && !is_page_template( 'page-templates/template-new.php' )
              && !is_search() ) :

              if( $template_for_ajax !== "new" ) :
          ?>

          <div class="ranking-icon">

            <?php
              global $term, $taxonomy, $pagename;

              if( $term && $taxonomy ){
                $this_term = get_term_by( 'slug', $term, $taxonomy );
              }

              $test = 0;

              $is_front_page = $is_top30 =
              $is_tax_parent = $is_tax_descendant =
              $is_brand = false;

              if( !empty( $template_for_ajax ) ){
                switch ( $template_for_ajax ) {
                  case 'front-page':
                    $is_front_page = true;
                    break;
                  case 'top30':
                    $is_top30 = true;
                    break;
                  case 'brand':
                    $is_brand = true;
                    break;
                }
              } else {
                $is_front_page = ( is_front_page() ) && ( $pagename === '' ) ? true : false;
                $is_top30 = ( is_page_template( '/page-templates/template-top30.php' ) )
                            || ( $pagename === 'top-30' ) ? true : false;
                $is_tax_parent = ( is_tax() ) && ( !$this_term->parent ) ? true : false;
                $is_tax_descendant = ( is_tax() ) && ( $this_term->parent ) ? true : false;
                $is_brand =( is_page_template( '/page-templates/template-brand.php' ) )
                             || ( $pagename === 'sort-by-brand' ) ? true : false;;
              }

              switch ( true ) {

                case $is_front_page :

                    $ranking_count = get_post_meta( get_the_ID(), 'product_ranking_order', true );

                  break;

                case $is_top30 :

                    $ranking_count = get_post_meta( get_the_ID(), 'product_featured_order', true );

                  break;

                case $is_tax_parent :

                  $ranking_count = get_post_meta( get_the_ID(), 'product_ranking_order', true );

                  break;

                case $is_tax_descendant :

                  $ranking_count = get_post_meta( get_the_ID(), 'product_descendant_order', true );

                  break;

                case $is_brand :

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

              <?php
                if( isset( $template_for_ajax ) ){
                  cosmetic_ranking_index( $template_for_ajax );
                } else {
                    cosmetic_ranking_index();
                }

              ?>

            </div>

          </div>

        <?php
            endif;

          endif;

          global $post;
        ?>
          <div class="favorite-save-button">
            <?php cosmetic_favorite_save_button(); ?>
          </div>

          <div class="loading-pulse"></div>

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
