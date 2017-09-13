<?php
/*
Template Name: Archive Brand
*/
?>
<?php get_header(); ?>


    <div class="content-box">

    <?php include( locate_template( '/module/product-menu.php', false, false ) ); ?>

    <?php

      $terms = get_terms(
        array(
          'taxonomy' => 'cosmetic_brand',
          'hide_empty' => 0,
          'orderby' => 'ID',
        ));
    ?>

    <?php
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

        <article class="post brand clearfix">
          <h4 class="cosmetic-brand">By Brand</h4>
          <h2><?php echo strtoupper($term->name) . ' - TOP 5'; ?></h2>

          <?php

          if( $query[$key]->have_posts() ) :

              $ranking_count = 1;

              while( $query[$key]->have_posts()) : $query[$key]->the_post();

                  include( locate_template( '/module/grid.php', false, false ) );

               $ranking_count++;

             endwhile;

             if( count( $query[$key]->posts ) % 5 !== 0 ) :
               for( $i = 0; $i < 5 - (count( $query[$key]->posts ) % 5); $i++ ) :
             ?>
                 <div class="col-sm-12 col-md-4 col-lg-4 spare"></div>
             <?php
               endfor;

             endif;
          wp_reset_postdata();

          else :
              echo '포스트가 존재하지 않습니다.';
          endif;
       ?>
       </article>

    <?php endforeach; ?>

    </div>

<?php get_footer(); ?>
