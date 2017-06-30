<?php get_header(); ?>
    <?php
      if(have_posts()) :
          while(have_posts()) : the_post(); ?>
              <article class="post">
                  <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

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
    <?php endwhile;
      else :
          echo '포스트가 존재하지 않습니다.';
      endif;
   ?>
<?php get_footer(); ?>
