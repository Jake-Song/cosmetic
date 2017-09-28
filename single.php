<?php get_header(); ?>

    <div class="content-box">

      <div class="title-box">
        <h2><?php echo ucfirst( the_title() ); ?></h2>
      </div>

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

                  <p class="post-info"><?php the_time('Y년 n월 j일 a g:i'); ?> | 글쓴이
                    <a href="<?php echo get_author_posts_url( get_the_author_meta('ID') ); ?>"><?php the_author(); ?></a> | 카테고리

                    <?php
                        $categories = get_the_category();
                        $separator = ", ";
                        $output = '';

                        if( $categories ) :
                            foreach( $categories as $category ) :
                                $output .= '<a href="' . get_category_link( $category->term_id ) . '">' . $category->cat_name . '</a>' . $separator;
                            endforeach;
                            echo trim( $output, $separator );
                        endif;
                     ?>
                  </p>

                  <?php the_content(); ?>
              </article>
              <div class="social-wrapper">
                <div id="shareIcons"></div>
                <div class="text">Share This Story. Choose the platform what you want.</div>
              </div>

    <?php endwhile;
      else :
          echo 'There is no post here.';
      endif;
   ?>

   </div>

<?php get_footer(); ?>
