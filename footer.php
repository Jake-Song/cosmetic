<footer class="site-footer">
  <div class="footer-content-box">
    <?php bloginfo('name') ?> - &copy; <?php echo date('Y'); ?>
    <div class="social">
      <a href="<?php echo esc_url( get_theme_mod( 'cosmetic_footer_social_url_1' ) ); ?>" target="_blank">
        <i class="<?php echo esc_attr( get_theme_mod( 'cosmetic_footer_social_icon_1' ) ); ?>" aria-hidden="true"></i>
      </a>
      <a href="<?php echo esc_url( get_theme_mod( 'cosmetic_footer_social_url_2' ) ); ?>" target="_blank">
        <i class="<?php echo esc_attr( get_theme_mod( 'cosmetic_footer_social_icon_2' ) ); ?>" aria-hidden="true"></i>
      </a>
      <a href="<?php echo esc_url( get_theme_mod( 'cosmetic_footer_social_url_3' ) ); ?>" target="_blank">
        <i class="<?php echo esc_attr( get_theme_mod( 'cosmetic_footer_social_icon_3' ) ); ?>" aria-hidden="true"></i>
      </a>
    </div>
  </div>

</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>
