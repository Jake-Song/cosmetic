<?php get_header(); ?>

    <?php
      $terms = get_terms(
        array(
          'taxonomy' => 'cosmetic_category',
          'hide_empty' => 0,
          'orderby' => 'ID',
        ));
        $test = 0;
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
                        $product_image_html = "<img src='./wp-content/themes/cosmetic/img/{$term->slug}.svg'>";
                        echo $product_image_html;
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

              <h4><?php echo 'TOP 3 - ' . strtoupper($term->name); ?></h4>

              <?php

              if( $query[$key]->have_posts() ) :

                  $ranking_count = 1;

                  while( $query[$key]->have_posts()) : $query[$key]->the_post();

                      include( locate_template( '/module/grid.php', false, false ) );

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
