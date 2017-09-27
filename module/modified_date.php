<div class="post-modified">
  <?php

    if( is_front_page() ) :

      $args = array(
          'post_type' => 'cosmetic',
          'post_status' => 'publish',
          'posts_per_page' => 1,
          'tax_query' => array(
            array(
              'taxonomy' => 'cosmetic_category',
              'field' => 'slug',
              'terms' => $term->slug,
            ),
          ),
          'meta_query' => array(
            array(
              'key' => 'ranking_update_date',
            ),
          ),
          'orderby' => 'meta_value_date',
          'order' => 'DESC'
      );

    endif;

    if( is_page_template( 'page-templates/template-top30.php' ) ) :

      $args = array(
        'post_type' => 'cosmetic',
        'post_status' => 'publish',
        'posts_per_page' => 1,
        'meta_query' => array(
          array(
            'key' => 'product_featured',
            'value' => 'featured',
          ),
          array(
            'key' => 'featured_update_date',
            ),
        ),
        'orderby'   => 'meta_value_date',
        'order' => 'DESC',
      );

    endif;

    if( is_page_template( 'page-templates/template-new.php' ) ) :

      $args = array(
        'post_type' => 'cosmetic',
        'post_status' => 'publish',
        'posts_per_page' => 1,
        'orderby'   => 'modified',
        'order' => 'DESC',
      );

    endif;

    if( is_page_template( 'page-templates/template-brand.php' ) ) :

      $args = array(
        'post_type' => 'cosmetic',
        'post_status' => 'publish',
        'posts_per_page' => 1,
        'tax_query' => array(
          array(
            'taxonomy' => 'cosmetic_brand',
            'field' => 'slug',
            'terms' => $term->slug,
          ),
        ),
        'meta_query' => array(
            array(
              'key' => 'brand_update_date',
            ),
          ),
        'orderby'   => 'meta_value_date',
        'order' => 'DESC',
      );

    endif;

    if( is_tax() ) :

      $args = array(
        'post_type' => 'cosmetic',
        'post_status' => 'publish',
        'posts_per_page' => 1,
        'tax_query' => array(
          array(
            'taxonomy' => $taxonomy,
            'field' => 'slug',
            'terms' => $term,
          ),
        ),
        'meta_query' => array(
          'relation' => 'OR',
            array(
              'key' => 'descendant_update_date',
            ),
            array(
              'key' => 'ranking_update_date',
            ),
          ),
        'orderby'   => 'meta_value_date',
        'order' => 'DESC',
      );

    endif;

    $latest = new WP_Query( $args );
    
    if($latest->have_posts()) :

      if( is_front_page() ) :

        $updated_time = get_post_meta( $latest->post->ID, 'ranking_update_date', true );

      endif;

      if( is_page_template( 'page-templates/template-top30.php' ) ) :

        $updated_time = get_post_meta( $latest->post->ID, 'featured_update_date', true );

      endif;

      if( is_page_template( 'page-templates/template-new.php' ) ) :

        $updated_time = get_the_modified_date( ('m/d/Y'), $latest->post->ID );

      endif;

      if( is_page_template( 'page-templates/template-brand.php' ) ) :

        $updated_time = get_post_meta( $latest->post->ID, 'brand_update_date', true );

      endif;

      if( is_tax() ) :
        $get_term = get_term_by( 'slug', $term, $taxonomy );
        $test = 0;
        if( $get_term->parent === 0 ){
          $updated_time = get_post_meta( $latest->post->ID, 'ranking_update_date', true );
        } else {
          $updated_time = get_post_meta( $latest->post->ID, 'descendant_update_date', true );
        }

      endif;

      if( $updated_time )
        echo 'Last updated: ' . $updated_time;

    endif;

  ?>
</div>
