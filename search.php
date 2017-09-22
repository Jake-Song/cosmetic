<?php get_header(); ?>

    <div class="content-box">

      <?php include( locate_template( '/module/product-menu.php', false, false ) ); ?>

      <div class="ajax-container">

          <article class="post search clearfix">

              <?php

              if( have_posts() ) :

                  while( have_posts()) : the_post();

                      include( locate_template( '/module/grid.php', false, false ) );

                  endwhile;
                  $paged = get_query_var('paged', 1);

                  $pag_args = array(
                     'format'  => '?paged=%#%',
                     'current' => $paged,
                     'total'   => $wp_query->max_num_pages,
                 );
           echo paginate_links( $pag_args );

              else :
                  echo 'There is no result to match up.';
              endif;
           ?>
           </article>

      </div>
  </div>
<?php get_footer(); ?>
