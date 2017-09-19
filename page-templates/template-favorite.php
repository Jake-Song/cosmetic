<?php
/*
Template Name: User Favorite
*/
?>
<?php get_header(); ?>

    <div class="content-box">

      <?php include( locate_template( '/module/product-menu.php', false, false ) ); ?>

      <article class="post favorite">
        <?php
          global $current_user;

            $favorite_posts = get_user_meta( $current_user->ID, 'user-favorite', true );

          if( !empty( $favorite_posts ) ){

            if( is_array($favorite_posts) ){
              $favorite_posts = array_map( 'intval', $favorite_posts );
            }

              $args = array(
                'post__in' => $favorite_posts,
                'post_type' => 'cosmetic',
                'posts_per_page' => -1,
              );

            $query = new WP_Query( $args );
            if( $query->have_posts() ) :

              while( $query->have_posts() ) : $query-> the_post();

                include( locate_template( '/module/grid.php', false, false ) );

              endwhile;

              wp_reset_postdata();

            endif;
          } else {
            echo 'You could try to add products.';
          }
           ?>
      </article>
    </div>
<?php get_footer(); ?>
