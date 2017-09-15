<?php get_header(); ?>

    <?php
      $taxonomy_terms = get_terms(
        array(
          'taxonomy' => 'cosmetic_category',
          'hide_empty' => 0,
          'orderby' => 'ID',

        ));
    ?>
     <div class="content-box">

         <div class="product">
           <ul>
             <?php foreach ($taxonomy_terms as $key => $taxonomy_term) : ?>
               <?php if($taxonomy_term->parent === 0) : ?>
                 <li>
                   <a href="<?php echo esc_url( home_url( '/' ) . $taxonomy_term->taxonomy . '/' . $taxonomy_term->slug); ?>">
                     <div class="product-image">
                       <img src="<?php echo esc_url( home_url( '/' ) . 'wp-content/themes/cosmetic/img/' . $taxonomy_term->slug . '.svg' ); ?>">
                     </div>
                     <div class="product-name">
                       <?php echo $taxonomy_term->name; ?>
                     </div>
                   </a>
                   <div class="arrow-down"></div>
                </li>

              <?php endif; ?>
             <?php endforeach; ?>
           </ul>
         </div>
         <div class="sub-product product">
           <ul>

             <?php
               //$custom_term = get_term_by( 'slug', $term, $taxonomy );
               $get_term_id = get_term_parent_id();
             ?>
               <li class="sub-product-list">
                 <a href="<?php echo esc_url( get_term_link( $get_term_id ) ); ?>">Overall</a>
               </li>
             <?php
             $test = 0;
               foreach( $taxonomy_terms as $taxonomy_term ) :

                if( $taxonomy_term->parent !== 0 && $taxonomy_term->parent === $get_term_id ) : ?>

                 <li class="sub-product-list">
                   <a href="<?php echo esc_url(get_term_link( $taxonomy_term )); ?>">
                     <?php echo $taxonomy_term->name;
              ?>
                 </a>
               </li>
             <?php
              endif;

             endforeach; ?>

           </ul>
         </div>

       <div class="ajax-container">

          <article class="post tax clearfix">

             <h4><?php echo 'By Category - ' . str_replace( '-', ' ', strtoupper($term) ); ?></h4>

             <?php include( locate_template( '/module/modified_date.php', false, false ) ); ?>

             <?php

             $args = array(
               'post_type' => 'cosmetic',
               'tax_query' => array(
                 array(
                   'taxonomy' => $taxonomy,
                   'field' => 'slug',
                   'terms' => $term,
                 ),
               ),
               'orderby'   => 'meta_value_num',
               'meta_key'  => 'product_ranking_order',
               'order' => 'ASC',
               'posts_per_page' => -1
             );

             $query = new WP_Query( $args );

             if( $query->have_posts() ) :

                 $ranking_count = 1;

                 while( $query->have_posts()) : $query->the_post();

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
   </div>
 <?php get_footer(); ?>
