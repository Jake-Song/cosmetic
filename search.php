<?php get_header(); ?>

    <?php
      $terms = get_terms(
        array(
          'taxonomy' => 'cosmetic_category',
          'hide_empty' => 0,
          'orderby' => 'ID',
        ));

    ?>
    <div class="content-box">

        <div class="product">
          <ul>
            <?php foreach ($terms as $key => $term) : ?>
              <?php if( !( $term->parent ) ) : ?>
            <?php $icon = $term->slug; ?>
                <li>
                  <a href="<?php echo esc_url( home_url( '/' ) . $term->taxonomy . '/' . $term->slug); ?>">
                    <div class="product-image">
                      <?php
                        //$product_image_html = "<img src='./wp-content/themes/cosmetic/img/{$term->slug}.svg'>";
                        //echo $product_image_html;
                      ?>
                    </div>
                    <div class="product-name">
                      <?php echo $term->name; ?>
                    </div>
                  </a>

                </li>

              <?php endif; ?>
            <?php endforeach; ?>
          </ul>
            <div class="search-field">
              <button type="button" name="search-trigger" id="search-trigger">
                <i class="icon-search"></i>
              </button>

              <?php get_search_form(); ?>
            </div>
        </div>

      <div class="ajax-container">

          <article class="post clearfix">

              <?php

              if( have_posts() ) :

                  while( have_posts()) : the_post();

                      include( locate_template( '/module/grid.php', false, false ) );



                  endwhile;
                  $paged = get_query_var('paged', 1);

                  $pag_args = array(
                     'format'  => '?paged=%#%',
                     'current' => $paged,
                     'total'   => $wp_query->max_num_pages,
                 );
           echo paginate_links( $pag_args );

              else :
                  echo '포스트가 존재하지 않습니다.';
              endif;
           ?>
           </article>

      </div>
  </div>
<?php get_footer(); ?>
