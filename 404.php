<?php
/*
 * The template for displaying 404 pages (Not Found)
 *
 */
get_header(); ?>

 <div class="content-box">

   <div class="title-box">
     <h2>404 Page </h2>
   </div>

       <article class="post not-found clearfix">
           <h3>Something Wrong!</h3>
           <h4>
              Please checkout the page what you want to go.
              or Go back to
             <a href="<?php echo esc_url( home_url() ); ?>">
               our home.
             </a>
           </h4>
       </article>

  </div>

 <?php get_footer(); ?>
