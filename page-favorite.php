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
            $test = 0;
            if( empty( $favorite_posts ) ){
              echo '추가된 상품이 없습니다.';
              return;
            }

            $favorite_posts = array_map( 'intval', $favorite_posts );
              $args = array(
                'post__in' => $favorite_posts,
                'post_type' => 'cosmetic',
              );

            $query = new WP_Query( $args );
            if( $query->have_posts() ) :
              while( $query->have_posts() ) : $query-> the_post();
              ?>
              <h2><?php the_title(); ?></h2>
              <?php
              endwhile;

              wp_reset_postdata();

            endif;
           ?>
      </article>

<?php get_footer(); ?>
