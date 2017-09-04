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

        <div class="filter">
          <ul>
            <li>
              <a href="./top-30">
                <i class="icon-award"></i>
                Top 30
              </a>
            </li>
            <li>
              <a href="./sort-by-brand">
                <i class="icon-award"></i>
                Sort By Brand
              </a>
            </li>
            <li>
              <a href="./new-arrival">
                <i class="icon-award"></i>
                New Arrival
              </a>
            </li>
          </ul>
        </div>

      <div class="ajax-container">

        <?php

          $paged = array();

          foreach( $terms as $key => $term ) :

            $paged[$key] = isset( $_GET['page'.$key] ) ? (int) $_GET['page'.$key] : 1;

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
                'posts_per_page' => 4,
                'paged' => $paged[$key],
              );
              $query[$key] = new WP_Query( $args[$key] );

        ?>
            <article class="post clearfix">

              <h4 class="cosmetic-category"><?php echo 'TOP 3 - ' . strtoupper($term->name); ?></h4>

              <?php

              if( $query[$key]->have_posts() ) :

                  $ranking_count = 1;

                  while( $query[$key]->have_posts()) : $query[$key]->the_post();

                      include( locate_template( '/module/grid.php', false, false ) );

                    $ranking_count++;

                  endwhile;
                  $test = 0;
                  $pag_args[$key] = array(
                     'format'  => '?page'. $key .'=%#%',
                     'current' => $paged[$key],
                     'total'   => $query[$key]->max_num_pages,

                 );
           echo paginate_links( $pag_args[$key] );

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
