<?php
function dev_enqueue_scripts(){
    wp_enqueue_style( 'style', get_stylesheet_uri() );
}
add_action('wp_enqueue_scripts', 'dev_enqueue_scripts');

// 메뉴 등록하기
register_nav_menus(array(
  'primary' => __( 'Primary Menu' ),
  'footer' => __( 'Footer Menu' )
));
