<?php
function dev_enqueue_scripts(){
    wp_enqueue_style( 'style', get_stylesheet_uri() );
    wp_enqueue_style( 'bootstrap-css', get_template_directory_uri() . '/css/bootstrap.min.css' );
    wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), true );
    wp_enqueue_script( 'custom', get_template_directory_uri() . '/js/custom.js', array('jquery') );
}
add_action('wp_enqueue_scripts', 'dev_enqueue_scripts');

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
    add_image_size( 'custom', 300, 250, true );
    add_image_size( 'single', 880, 400, true );

    // 메뉴 등록하기
    register_nav_menus(array(
      'primary' => __( 'Primary Menu' ),
      'footer' => __( 'Footer Menu' ),
    ));
}
add_action( 'after_setup_theme', 'my_theme_setup' );

// 부트스트랩 메뉴 적용
require_once('wp_bootstrap_navwalker.php');

add_theme_support( 'featured-content', array(
  'featured_content_filter' => 'mytheme_get_featured_content',
));

// 화장품 포스트 타입 등록
function cosmetic_register_post_type(){

  $name = '화장품';
  $slug = 'cosmetic';

  $labels = array(
    'name' 			          => $name,
		'name_name' 	    => $name,
		'add_new' 		        => '새로 추가하기',
		'add_new_item'  	    => $name . ' 추가하기',
		'edit'		            => '편집하기',
  	'edit_item'	          => $name . ' 편집하기',
  	'new_item'	          => '새 ' . $name,
		'view' 			          => $name . ' 목록보기',
		'view_item' 		      => $name . ' 목록보기',
		'search_term'   	    => $name . ' 검색하기',
	  'parent' 		          => $name . ' 부모 페이지',
		'not_found' 		      => $name . ' 이 없습니다.',
		'not_found_in_trash' 	=> $name . ' 이 휴지통에 없습니다.'
  );

  $args = array(
    'labels'              => $labels,
    'public'              => true,
    'publicly_queryable'  => true,
    'exclude_from_search' => false,
    'show_in_nav_menus'   => true,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'show_in_admin_bar'   => true,
    'menu_position'       => 10,
    'menu_icon'           => 'dashicons-businessman',
    'can_export'          => true,
    'delete_with_user'    => false,
    'hierarchical'        => false,
    'has_archive'         => true,
    'query_var'           => true,
    'capability_type'     => 'post',
    'map_meta_cap'        => true,
    // 'capabilities' => array(),
    'rewrite'             => array(
    	'slug' => $slug,
    	'with_front' => true,
    	'pages' => true,
    	'feeds' => true,
    ),
    'supports'            => array(
    	'title',
    	'editor',
    	'thumbnail'
    )
  );
  register_post_type( 'cosmetic', $args );
}
add_action( 'init', 'cosmetic_register_post_type' );

// 화장품 카테고리 등록하기
function cosmetic_register_taxonomy(){
  $names = [
    '상품 카테고리' => 'cosmetic category',
    '브랜드명' => 'cosmetic brand',
  ];

  foreach ($names as $name=>$slug_name) :

      $slug = str_replace( ' ', '_', strtolower( $slug_name ) );
      $labels = array(
        'name' => $name,
        'name_name' => $name,
        'search_items' => 'Search ' . $name,
        'popular_items' => 'Popular ' . $name,
        'all_items' => 'All ' . $name,
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' => 'Edit ' . $name,
        'update_item' => 'Update ' . $name,
        'add_new_item' => 'Add New ' . $name,
        'new_item_name' => 'New ' . $name . ' Name',
        'separate_items_with_commas' => 'Separate ' . $name . ' with commas',
        'add_or_remove_items' => 'Add or remove ' . $name,
        'choose_from_most_used' => 'Choose from the most used ' . $name,
        'not_found' => 'No ' . $name . ' found.',
        'menu_name' => $name,
      );
      $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var' => true,
        'rewrite' => array( 'slug' => $slug ),
      );
      register_taxonomy( $slug, 'cosmetic', $args );

  endforeach;
}
add_action( 'init', 'cosmetic_register_taxonomy' );

// 화장품 커스텀 필드 추가
function product_ranking_order() {
    add_meta_box(
        'product_ranking_order',
        __( '부가 정보', 'cosmetic' ),
        'product_ranking_order_content',
        'cosmetic',
        'normal',
        'low'
    );
}
add_action( 'add_meta_boxes', 'product_ranking_order' );

function product_ranking_order_content( $post ){
  wp_nonce_field( basename( __FILE__ ), 'product_ranking_order_content_nonce' );
  $content = '';
  
  $product_ranking_order = get_post_meta( get_the_ID(), 'product_ranking_order', true );
  $product_featured = get_post_meta( get_the_ID(), 'product_featured', true );
  $product_featured_order = get_post_meta( get_the_ID(), 'product_featured_order', true );
  $product_price = get_post_meta( get_the_ID(), 'product_price', true );

  $product_ranking_order_val = !empty( $product_ranking_order ) ? $product_ranking_order : '';
  $product_featured_val = !empty( $product_featured ) ? 'checked' : '';
  $product_featured_order_val = (!empty( $product_featured ) && !empty( $product_featured_order ))
  ? $product_featured_order : '';
  $product_price_val = !empty( $product_price ) ? $product_price : '';

  $content .= "<label for='product_price'>가격</label>";
  $content .= "<input type='text' id='product_price'
              name='product_price' placeholder='가격을 입력하세요.'
              value='{$product_price_val}' /><br>";

  $content .= "<label for='product_ranking_order'>카테고리별 순위</label>";

  $content .= "<input type='text' id='product_ranking_order'
              name='product_ranking_order' placeholder='순위를 입력하세요.'
              value='{$product_ranking_order_val}' /><br>";

  $content .= '<label for="product_featured">종합랭킹등록하기</label>';

  $content .= "<input type='checkbox' id='product_featured' name='product_featured' value='featured'
  {$product_featured_val} />Featured?<br>";

  $content .= '<label for="product_featured_order"></label>';

  $content .= "<input type='text' id='product_featured_order' name='product_featured_order' placeholder='순위를 입력하세요.' value='{$product_featured_order_val}' />";

  echo $content;
}

function product_rank_box_save( $post_id ){
  $test = 0;
  $post_type = get_post_type( $post_id );

  if( $post_type !== 'cosmetic' ) return;

  if( !isset( $_POST['post_author'] ) ) return;

  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
  return;

  if ( !wp_verify_nonce( $_POST['product_ranking_order_content_nonce'], basename( __FILE__ ) ) )
  return;

  if ( 'page' == $_POST['post_type'] ) {
    if ( !current_user_can( 'edit_page', $post_id ) )
    return;
  } else {
    if ( !current_user_can( 'edit_post', $post_id ) )
    return;
  }

  $product_ranking_order = (!empty($_POST['product_ranking_order'])) ? $_POST['product_ranking_order'] : '';
  $product_featured = (!empty($_POST['product_featured'])) ? $_POST['product_featured'] : '';
  $product_featured_order = (!empty($_POST['product_featured_order'])) ? $_POST['product_featured_order'] : '';
  $product_price = (!empty($_POST['product_price'])) ? $_POST['product_price'] : '';

  update_post_meta( $post_id, 'product_ranking_order', $product_ranking_order );
  update_post_meta( $post_id, 'product_featured', $product_featured );
  update_post_meta( $post_id, 'product_featured_order', $product_featured_order );
  update_post_meta( $post_id, 'product_price', $product_price );
}
add_action( 'save_post', 'product_rank_box_save' );
