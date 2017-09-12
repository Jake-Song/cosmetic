<?php get_header(); ?>
  <div class="content-box">
    <?php
      if(have_posts()) :
          while(have_posts()) : the_post(); ?>

              <article class="post tips clearfix">

                  <div class="post-image">

                      <?php if( has_post_thumbnail() ) : ?>
                          <?php the_post_thumbnail( 'custom' ); ?>
                      <?php endif; ?>

                  </div>
                  <div class="post-content">

                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

                    <?php the_excerpt(); ?>
                  </div>
                  <div class="post-meta-box">
                    <p class="post-info">By
                      <a href="<?php echo get_author_posts_url( get_the_author_meta('ID') ); ?>"><?php the_author(); ?></a> | <?php the_time('F jS, Y'); ?> | 카테고리

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
                    <a href="<?php echo esc_url( the_permalink() ); ?>">
                      <span class="read-more">Read More &gt;</span>
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
