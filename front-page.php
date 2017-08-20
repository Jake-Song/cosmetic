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
            <?php $icon = $term->slug; ?>
                <li>
                  <a href="<?php echo esc_url( home_url( '/' ) . $term->taxonomy . '/' . $term->slug); ?>">
                    <div class="product-image">
                      <?php
                        $product_image_html = "<img src='./wp-content/themes/cosmetic/img/{$term->slug}.svg'>";
                        echo $product_image_html;
                      ?>
                    </div>
                    <div class="product-name">
                      <?php echo $term->name; ?>
                    </div>
                  </a>
                </li>
            <?php endforeach; ?>
          </ul>
        </div>

        <div class="filter">
          <ul>
            <li><a href="./top-30">Top 30</a></li>
            <li><a href="./sort-by-brand">Sort By Brand</a></li>
            <li><a href="./new-arrival">New Arrival</a></li>
          </ul>
        </div>

      <div class="ajax-container">

        <?php
          foreach( $terms as $key => $term ) :

              $args[$key] = array(
                'post_type' => 'cosmetic',
                'tax_query' => array(
                  array(
                    'taxonomy' => 'cosmetic_category',
                    'field' => 'slug',
                    'terms' => $term->slug,
                  ),
                ),
                'orderby'   => 'meta_value_num',
        	      'meta_key'  => 'product_ranking_order',
                'order' => 'ASC',
              );
              $query[$key] = new WP_Query( $args[$key] );

        ?>
            <article class="post clearfix">

              <h2><?php echo 'TOP 3 - ' . strtoupper($term->name); ?></h2>

              <?php

              if( $query[$key]->have_posts() ) :

                  $ranking_count = 1;

                  while( $query[$key]->have_posts()) : $query[$key]->the_post(); ?>
                      <div class="ranking"><?php echo $ranking_count; ?></div>
                      <?php

                        if( is_user_logged_in() ) :

                          $user_favorite = !empty(get_user_meta( $user_ID, 'user-favorite', true))
                          ? get_user_meta( $user_ID, 'user-favorite', true) : array();

                          if( (array_search( get_the_ID(), $user_favorite) !== false ) ) :
                        ?>
                            <button type="button" name="favorite" class="favorite-button saved" data-post-id="<?php echo get_the_ID(); ?>">SAVED</button>

                        <?php else : ?>

                            <button type="button" name="favorite" class="favorite-button" data-post-id="<?php echo get_the_ID(); ?>">SAVE</button>

                        <?php endif; ?>

                      <?php else : ?>

                        <button type="button" name="favorite" class="is-not-logged" data-post-id="<?php echo get_the_ID(); ?>">SAVE</button>

                      <?php endif; ?>

                      <div class="favorite-count post-id-<?php the_ID(); ?>"><?php echo get_post_meta( $post->ID, 'favorite_count', true ) ?></div>

                      <div class="ranking-changed">

                        <?php
                           $product_ranking_changed = get_post_meta( get_the_ID(), 'product_ranking_changed', true );
                           $featured_ranking_changed = get_post_meta( get_the_ID(), 'featured_ranking_changed', true );

                           $content = '';

                           switch ( true ) {
                             case $product_ranking_changed > 0:
                              $content .= '상승' . $product_ranking_changed;
                              echo $content;
                             break;

                             case $product_ranking_changed < 0:
                              $content .= '하락' . $product_ranking_changed;
                              echo $content;
                             break;

                             case $product_ranking_changed == 0:
                              $content .= '변동없음' . $product_ranking_changed;
                              echo $content;
                             break;
                           }
                         ?>
                      </div>
                      <div class="col-sm-12 col-md-2 col-lg-2">

                        <div class="thumbnail">
                          <?php if( has_post_thumbnail() ) : ?>
                            <div class="thumbnail-image">
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
                              <p class="thumbnail-footer">
                                  <span class="product-price">
                                    <?php
                                      $product_price = get_post_meta( get_the_ID(), 'product_price', true );
                                      if( !empty( $product_price ) ) echo '$' . $product_price;
                                    ?>
                                  </span>
                                  <a href="#" target="_blank" class="btn btn-primary" role="button">Check Out</a>
                              </p>
                            </div>
                        </div>
                      </div>

          <?php

                    $ranking_count++;

                  endwhile;

              wp_reset_postdata();

              else :
                  echo '포스트가 존재하지 않습니다.';
              endif;
           ?>
           </article>

        <?php endforeach; ?>
      </div>
  </div>
<?php get_footer(); ?>
