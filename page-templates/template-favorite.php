<?php
/*
Template Name: User Favorite
*/
?>
<?php
  global $current_user;
 ?>
<?php get_header(); ?>

      <article class="post">
          <?php
            $favorite_posts = get_user_meta( $current_user->ID, 'user-favorite', true );

            $favorite_posts = array_map( 'intval', $favorite_posts );
              $args = array(
                'post__in' => $favorite_posts,
                'post_type' => 'cosmetic',
              );

            $query = new WP_Query( $args );
            if( $query->have_posts() ) :

              $ranking_count = 1;

              while( $query->have_posts() ) : $query-> the_post();

                include( locate_template( '/module/grid.php', false, false ) );

                $ranking_count++;

              endwhile;

              wp_reset_postdata();
              else :
                echo 'You could try to add products.';
            endif;
           ?>
      </article>

<?php get_footer(); ?>