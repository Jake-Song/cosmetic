<?php get_header(); ?>
  <div class="content-box">
    <?php
        if(have_posts()) :
          while(have_posts()) : the_post(); ?>

              <article class="post clearfix">

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
                      <i class="icon-export"></i> Check Out
                    </a>
                  </div>
              </article>

              <div class="author-info">
                  <div class="author-name">
                      <h2>About the Author: <?php the_author_meta( 'display_name' ); ?></h2><div class="sep-double"></div>
                  </div>
                  <div class="author-desc">
                      <div class="avatar">
                          <?php echo get_avatar( get_the_author_meta( 'ID' ) ); ?>
                      </div>
                      <div class="description">
                          <?php echo wpautop( the_author_meta( 'description' ) ); ?>
                      </div>
                  </div>
              </div>

    <?php endwhile;
      else :
          echo '포스트가 존재하지 않습니다.';
      endif;
   ?>
 </div>
<?php get_footer(); ?>
