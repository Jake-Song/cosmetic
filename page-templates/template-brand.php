<?php
/*
Template Name: Archive Brand
*/
?>
<?php get_header(); ?>
    <?php

      $terms = get_terms(
        array(
          'taxonomy' => 'cosmetic_brand',
          'hide_empty' => 0,
          'orderby' => 'ID',
        ));

      foreach( $terms as $key => $term ) :

          $args[$key] = array(
            'post_type' => 'cosmetic',
            'tax_query' => array(
              array(
                'taxonomy' => 'cosmetic_brand',
                'field' => 'slug',
                'terms' => $term->slug,
              ),
            ),
            'orderby'   => 'meta_value_num',
    	      'meta_key'  => 'product_brand_order',
            'order' => 'ASC',
          );
          $query[$key] = new WP_Query( $args[$key] );

        ?>
      <div class="content-box">

        <article class="post clearfix">

          <h2><?php echo 'TOP 3 - ' . strtoupper($term->name); ?></h2>

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

  </div>
  
    <?php endforeach; ?>

<?php get_footer(); ?>
