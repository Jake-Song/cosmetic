<?php
/*
Template Name: Reset Form
*/
?>

<?php get_header(); ?>
	<div class="content-box">

		<?php include( locate_template( '/module/product-menu.php', false, false ) ); ?>

			<article class="post reset-page">
				<div class="content-box">
					<?php echo custom_reset_shortcode(); ?>
				</div>
			</article>
			
	</div>
<?php get_footer(); ?>
