<?php get_header(); ?>

  <div class="content-box">

  <?php include( locate_template( '/module/product-menu.php', false, false ) ); ?>

    <?php

        if(have_posts()) :

          while(have_posts()) : the_post(); ?>

              <article class="post single clearfix">

                <div class="image-wrapper">

                  <div class="single-post-images">

                    <?php
                      if( has_post_thumbnail() ){
                          the_post_thumbnail( 'full', array( 'class' => 'single-image current' ) );
                      }

                      $single_post_images = get_post_meta( get_the_ID(), 'custom_image_data', true );

                      if( !empty($single_post_images) ) :

                          foreach ($single_post_images as $key => $image) {
                     ?>
                            <img class="single-image" src="<?php echo esc_url($image['url']); ?>" alt="">
                     <?php
                          }
                      endif;
                     ?>

                  </div>

                  <div class="additional-image-wrapper">
                      <?php

                        $single_post_images = get_post_meta( get_the_ID(), 'custom_image_data', true );
                        if( !empty($single_post_images) ) :

                            if( has_post_thumbnail() ){
                              the_post_thumbnail( 'full', array( 'class' => 'additional-image order-0' ) );
                            }

                            foreach ($single_post_images as $key => $image) {
                          ?>

                            <div class="additional-image order-<?php echo (int)$key + 1 ?>">
                              <img src="<?php echo esc_url($image['url']); ?>" alt="">
                            </div>

                          <?php
                            }
                        endif;
                       ?>
                   </div>
                </div>
                <div class="text-wrapper">
                  <h2><?php the_title(); ?></h2>

                  <?php the_content(); ?>

                  <div class="price-container">
                    <?php
                      $product_price = get_post_meta( get_the_ID(), 'product_price', true );
                      if( !empty( $product_price ) ) echo '$' . $product_price;
                      $checkout_url = get_post_meta( get_the_ID(), 'checkout_url', true );
                   ?>
                  </div>
                  <div class="check-out-container">
                    <a href="<?php echo esc_url($checkout_url); ?>" target="_blank" class="btn btn-primary" role="button">
                      Check It Out
                    </a>
                  </div>
                </div>
              </article>

    <?php endwhile;
      else :
          echo '포스트가 존재하지 않습니다.';
      endif;
   ?>
 </div>
<?php get_footer(); ?>
