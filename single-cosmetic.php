<?php get_header(); ?>

  <div class="content-box">

  <?php include( locate_template( '/module/product-menu.php', false, false ) ); ?>

    <?php
        if(have_posts()) :
          while(have_posts()) : the_post(); ?>

              <article class="post single clearfix">

                  <div class="single-post-image">

                      <?php if( has_post_thumbnail() ) : ?>
                          <?php the_post_thumbnail( 'single' ); ?>
                      <?php else : ?>
                          <img class="not-found" src="../wp-content/uploads/2017/07/image-not-found.png" alt="">
                      <?php endif; ?>

                  </div>

                  <h2><?php the_title(); ?></h2>

                  <?php the_content(); ?>

                  <div class="price-container">
                    <?php
                      $product_price = get_post_meta( get_the_ID(), 'product_price', true );
                      if( !empty( $product_price ) ) echo '$' . $product_price;
                     ?>
                  </div>
                  <div class="check-out-container">
                    <a href="#" target="_blank" class="btn btn-primary" role="button">
                      Check Out
                    </a>
                  </div>
              </article>
              
    <?php endwhile;
      else :
          echo '포스트가 존재하지 않습니다.';
      endif;
   ?>
 </div>
<?php get_footer(); ?>
