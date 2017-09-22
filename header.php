<!DOCTYPE html>
<html <?php language_attributes(); ?> class="my-theme">
    <head>
        <meta name="viewport" content="width=device-width">
        <meta charset="<?php bloginfo('charset'); ?>">
        <title><?php bloginfo('name'); ?></title>
        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>

        <div class="container">
            <header class="site-header">

                <div class="title">
                  <?php
                    $test = 0;
                    if( get_theme_mod('logo_settings', '') !== '' ){
                      $logo_id = get_theme_mod('logo_settings');
                  ?>
                      <a href="<?php echo home_url(); ?>">
                        <?php echo wp_get_attachment_image( $logo_id, array( '270', '45' ) ); ?>
                      </a>

                  <?php  } else { ?>
                      <a href="<?php echo home_url(); ?>">
                        <h2>This Is What She Got.</h2>
                      </a>
                      <h4>Real Korean Cosmetic</h4>
                <?php  } ?>

                </div>
                <nav class="navbar navbar-default top-menu">
                  <?php
                    $args = array(
                      'theme_location' => 'top',
                      'depth' => 3,
                      'container' => 'div',
                      'container_class'   => 'collapse navbar-collapse',
                      'container_id'      => 'top-menu',
                      'menu_class'        => 'nav navbar-nav',
                      'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
                      //'walker'            => new WP_Bootstrap_Navwalker(),
                    );
                   ?>

                  <?php wp_nav_menu( $args ); ?>
                </nav>
                <nav class="navbar navbar-default">

                      <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#primary-menu" aria-expanded="false">
                          <span class="sr-only">Toggle navigation</span>
                          <div class="hamburger-menu">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                          </div>
                        </button>
                      </div>

                            <?php
                              $args = array(
                                'theme_location' => 'primary',
                                'depth' => 3,
                                'container' => 'div',
                                'container_class'   => 'collapse navbar-collapse',
                                'container_id'      => 'primary-menu',
                                'menu_class'        => 'nav navbar-nav',
                                'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
                                'walker'            => new WP_Bootstrap_Navwalker(),
                              );
                             ?>

                            <?php wp_nav_menu( $args ); ?>
                            
                  <div class="mobile-close">X</div>

              </nav>

                <!-- Registration The Modal -->
                <div id="register" class="modal">

                  <!-- Modal content -->
                  <div class="modal-content">
                    <span class="close">&times;</span>
                    <div class="modal-title">
                      <h2>Create Account</h2>
                    </div>

                    <?php echo custom_registration_shortcode(); ?>

                  </div>

                </div>

                <!-- Log in The Modal -->
                <div id="signin" class="modal">

                  <!-- Modal content -->
                  <div class="modal-content">
                    <span class="close">&times;</span>
                    <div class="modal-title">
                      <h2>Log In</h2>
                    </div>

                    <?php echo custom_login_shortcode(); ?>

                  </div>

                </div>

                <?php get_search_form(); ?>

          </header>
