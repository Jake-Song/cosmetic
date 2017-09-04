<?php
// 스타일 시트, 스크립트 로드
function cosmetic_enqueue_scripts(){
    wp_enqueue_style( 'style', get_stylesheet_uri() );
    wp_enqueue_style( 'bootstrap-css', get_template_directory_uri() . '/css/bootstrap.min.css' );
    wp_enqueue_style( 'fontello', get_template_directory_uri() . '/fontello/css/fontello.css' );
    wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), true );
    wp_enqueue_script( 'custom', get_template_directory_uri() . '/js/custom.js', array('jquery') );

    wp_localize_script( 'custom', 'ajaxHandler', array(
      'adminAjax' => admin_url( 'admin-ajax.php' ),
      'securityFavorite' => wp_create_nonce( 'user-favorite' ),
      'securityLoadmore' => wp_create_nonce( 'loadmore' ),
    ) );
}
add_action('wp_enqueue_scripts', 'cosmetic_enqueue_scripts');

// 부트스트랩 메뉴 적용
require_once('inc/wp_bootstrap_navwalker.php');

// 테마 셋업
function my_theme_setup(){

    // 포스트 썸네일 등록하기
    add_theme_support( 'post-thumbnails' );
    add_image_size( 'custom', 300, 250, true );
    add_image_size( 'single', 880, 400, true );

    // 메뉴 등록하기
    register_nav_menus(array(
      'top' => __( 'Top Menu' ),
      'primary' => __( 'Primary Menu' ),
      'footer' => __( 'Footer Menu' ),
    ));

    add_theme_support( 'html5', array( 'search-form' ) );

}
add_action( 'after_setup_theme', 'my_theme_setup' );

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
    'show_in_rest'        => true,
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

// Favorite Ajax
function process_favorite_callback(){

  global $current_user, $post;

  if ( ! check_ajax_referer( 'user-favorite', 'security' ) ) {
    wp_send_json_error( 'Security Check failed' );
  }
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $current_favorite_posts = get_user_meta( $current_user->ID, 'user-favorite', true );
    $favorite_post = sanitize_text_field($_POST['favoritePostId']);

    $current_favorite_count = get_post_meta( intval($favorite_post), 'favorite_count', true );

    if( $_POST['favorite'] === 'remove' ){

        if( ($key = array_search( $favorite_post, $current_favorite_posts )) !== false ){
          unset( $current_favorite_posts[$key] );
        }

      update_user_meta( $current_user->ID, 'user-favorite', $current_favorite_posts );

      $update_favorite_count = $current_favorite_count - 1;

    } elseif( $_POST['favorite'] === 'add' ) {

      $update_favorite_count = $current_favorite_count + 1;
      $current_favorite_posts[] = $favorite_post;
      $current_favorite_posts = array_unique( $current_favorite_posts );
      update_user_meta( $current_user->ID, 'user-favorite', $current_favorite_posts );
    }

    update_post_meta( intval($favorite_post), 'favorite_count', $update_favorite_count );

    $response = array(
      'favorite_count' => $update_favorite_count,
    );
    wp_send_json_success( $response );
  } else {
    wp_send_json_error("정상적인 방법이 아닙니다.");
  }
}
add_action('wp_ajax_process_favorite', 'process_favorite_callback');
add_action('wp_ajax_nopriv_process_favorite', 'process_favorite_callback');

// 상위 페이지 아이디 가져오기
function get_top_parent_id(){
    global $post;
    if( $post->post_parent ){
        $ancestors = array_reverse( get_post_ancestors( $post->ID ) );
        return $ancestors[0];
    }
    return $post->ID;
}

// 상위 텀 아이디 가져오기
function get_term_parent_id(){
    global $term, $taxonomy;
    $get_term = get_term_by( 'slug', $term, $taxonomy );
    if( $get_term->parent !== 0 ){
        return $get_term->parent;
    }
    return $get_term->term_id;
}

// 랭킹 순위 변동 나타내기
function cosmetic_ranking_index(){
     global $pagename;

     switch ($pagename) {

       case '':

         $ranking_changed = get_post_meta( get_the_ID(), 'product_ranking_changed', true );

         break;

       case 'top-30':

         $ranking_changed = get_post_meta( get_the_ID(), 'featured_ranking_changed', true );

         break;

       case 'descendant':

         $ranking_changed = get_post_meta( get_the_ID(), 'descendant_ranking_changed', true );

         break;

       case 'sort-by-brand':

         $ranking_changed = get_post_meta( get_the_ID(), 'brand_ranking_changed', true );

         break;

     }

     $content = '';
     if( isset( $ranking_changed ) ) :
         switch ( true ) {
           case $ranking_changed > 0:
            $content = '<span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span>'
            . ' ' . $ranking_changed;
            echo $content;
           break;

           case $ranking_changed < 0:
            $content = '<span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span>'
             . ' ' . abs($ranking_changed);
            echo $content;
           break;

           case $ranking_changed == 0:
            $content = '<span class="glyphicon glyphicon-minus" aria-hidden="true"></span>';
            echo $content;
           break;
         }
     endif;
}

// 로그인 후 favorite 버튼 사용하기
function cosmetic_favorite_save_button(){

    global $current_user;

    if( is_user_logged_in() ) :

      $user_favorite = !empty(get_user_meta( $current_user->ID, 'user-favorite', true))
      ? get_user_meta( $current_user->ID, 'user-favorite', true) : array();

      if( (array_search( get_the_ID(), $user_favorite) !== false ) ) :
    ?>
        <button type="button" name="favorite" class="favorite-button saved" data-post-id="<?php echo get_the_ID(); ?>">
          <i class="icon-floppy"></i> Saved
        </button>

    <?php else : ?>

        <button type="button" name="favorite" class="favorite-button" data-post-id="<?php echo get_the_ID(); ?>">
          <i class="icon-floppy"></i>Save
        </button>

    <?php endif; ?>

  <?php else : ?>

    <button type="button" name="favorite" class="is-not-logged" data-post-id="<?php echo get_the_ID(); ?>">
      <i class="icon-floppy"></i>Save
    </button>

  <?php endif;
}

// filter for cosmetic post type edit list
add_action('restrict_manage_posts','restrict_cosmetic_by_cosmetic_category');
function restrict_cosmetic_by_cosmetic_category() {
    $test = 0;
    global $typenow;
    global $wp_query;
    $cosmetic_taxonomies = get_object_taxonomies( 'cosmetic', 'objects' );

    if ($typenow=='cosmetic') {
        foreach ($cosmetic_taxonomies as $key => $cosmetic_taxonomy) {

          $cosmetic_term_slug = !empty($wp_query->query[$cosmetic_taxonomy->name]) ?
            $wp_query->query[$cosmetic_taxonomy->name] : false;

          wp_dropdown_categories(array(
              'show_option_all' =>  __("Show All {$cosmetic_taxonomy->label}"),
              'taxonomy'        =>  $cosmetic_taxonomy->name,
              'name'            =>  $cosmetic_taxonomy->name,
              'orderby'         =>  'name',
              'selected'        =>  $cosmetic_term_slug,
              'hierarchical'    =>  true,
              'depth'           =>  3,
              'show_count'      =>  true, // Show # items in parenthesis
              'hide_empty'      =>  true, // Don't show cosmetic_category w/o listings
              'value_field'     => 'slug',
          ));
        }
    }
}

// Load more ajax handler
/*
function process_load_more_callback(){
  $test = 0;
  $args = array(
    'post_type' => 'cosmetic',
    'tax_query' => array(
      array(
        'taxonomy' => 'cosmetic_category',
        'field' => 'slug',
        'terms' => $term->slug,
      ),
    ),
    'orderby'   => 'meta_value_num',
    'meta_key'  => 'product_ranking_order',
    'order' => 'ASC',
    'posts_per_page' => 4,
    'paged' => $paged,
  );
  $query = new WP_Query( $args );
}
*/
// add_action( 'wp_ajax_process_load_more_callback', 'process_load_more_callback' );
// add_action( 'wp_ajax_nopriv_process_load_more_callback', 'process_load_more_callback' );
