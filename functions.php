<?php
function dev_enqueue_scripts(){
    wp_enqueue_style( 'style', get_stylesheet_uri() );
    wp_enqueue_style( 'bootstrap-css', get_template_directory_uri() . '/css/bootstrap.min.css' );
    wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), true );
    wp_enqueue_script( 'custom', get_template_directory_uri() . '/js/custom.js', array('jquery') );
}
add_action('wp_enqueue_scripts', 'dev_enqueue_scripts');

// 메뉴 등록하기
register_nav_menus(array(
  'primary' => __( 'Primary Menu' ),
  'footer' => __( 'Footer Menu' )
));

// 상위 페이지 아이디 가져오기
function get_top_parent_id(){
    global $post;
    if( $post->post_parent ){
        $ancestors = array_reverse( get_post_ancestors( $post->ID ) );
        return $ancestors[0];
    }
    return $post->ID;
}

// 테마 셋업
function my_theme_setup(){

    // 포스트 썸네일 등록하기
    add_theme_support( 'post-thumbnails' );
    add_image_size( 'custom', 320, 200, true );
    add_image_size( 'single', 880, 400, true );
}
add_action( 'after_setup_theme', 'my_theme_setup' );

// 부트스트랩 메뉴 적용
require_once('wp_bootstrap_navwalker.php');
