<?php
// 스타일 시트, 스크립트 로드
function cosmetic_enqueue_scripts(){
    wp_enqueue_style( 'style', get_stylesheet_uri() );
    wp_enqueue_style( 'bootstrap-css', get_template_directory_uri() . '/css/bootstrap.min.css' );
    wp_enqueue_style( 'fontello', get_template_directory_uri() . '/fontello/css/fontello.css' );
    wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), true );
    wp_enqueue_script( 'custom', get_template_directory_uri() . '/js/custom.js', array('jquery', 'social') );
    wp_enqueue_script( 'social', get_template_directory_uri() . '/js/jsSocials/jssocials.min.js', array('jquery') );
    wp_enqueue_style( 'social-css', get_template_directory_uri() . '/js/jsSocials/jssocials-theme-plain.css' );
    wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/font-awesome/css/font-awesome.min.css' );

    wp_localize_script( 'custom', 'ajaxHandler', array(
      'adminAjax' => admin_url( 'admin-ajax.php' ),
      'securityFavorite' => wp_create_nonce( 'user-favorite' ),
      'securityLoadmore' => wp_create_nonce( 'loadmore' ),
      'securityLogin' => wp_create_nonce( 'login' ),
    ) );
}
add_action('wp_enqueue_scripts', 'cosmetic_enqueue_scripts');

// 사용자 정의하기
function themeslug_customize_register( $wp_customize ) {

  // 사이트 로고
  $wp_customize->add_setting(
     'logo_settings', //give it an ID
     array(
       'type' => 'theme_mod',
       'default' => '', // Give it a default

     )
   );
   $wp_customize->add_control( new WP_Customize_Cropped_Image_Control( $wp_customize, 'logo', array(
     'section'     => 'title_tagline',
     'settings'    => 'logo_settings',
     'label'       => __( '로고', 'cosmetic' ),
     'description' => __( '화면 상단의 로고 이미지로 사용됩니다. 권장크기는 270 x 45 입니다.' ),
     'flex_width'  => true, // Allow any width, making the specified value recommended. False by default.
     'flex_height' => false, // Require the resulting image to be exactly as tall as the height attribute (default).
     'width'       => 270,
     'height'      => 45,
   ) ) );

  // 푸터 소셜 편집
  $wp_customize->add_section( 'footer', array(
    'title' => __( '푸터 소셜아이콘', 'cosmetic' ),
    'description' => __( '푸터 소셜아이콘 편집', 'cosmetic' ),
    'priority' => 160,
    'capability' => 'edit_theme_options',
  ) );
  $wp_customize->add_setting(
     'cosmetic_footer_social_url_1', //give it an ID
     array(
       'type' => 'theme_mod',
       'default' => '', // Give it a default

     )
   );
   $wp_customize->add_setting(
      'cosmetic_footer_social_url_2', //give it an ID
      array(
        'type' => 'theme_mod',
        'default' => '', // Give it a default

      )
    );
  $wp_customize->add_setting(
     'cosmetic_footer_social_url_3', //give it an ID
     array(
       'type' => 'theme_mod',
       'default' => '', // Give it a default

     )
   );
   $wp_customize->add_setting(
      'cosmetic_footer_social_icon_1', //give it an ID
      array(
        'type' => 'theme_mod',
        'default' => '', // Give it a default

      )
    );
    $wp_customize->add_setting(
       'cosmetic_footer_social_icon_2', //give it an ID
       array(
         'type' => 'theme_mod',
         'default' => '', // Give it a default

       )
     );
     $wp_customize->add_setting(
        'cosmetic_footer_social_icon_3', //give it an ID
        array(
          'type' => 'theme_mod',
          'default' => '', // Give it a default

        )
      );

    $wp_customize->get_setting( 'cosmetic_footer_social_icon_1' )->transport = 'postMessage';
    $wp_customize->get_setting( 'cosmetic_footer_social_icon_2' )->transport = 'postMessage';
    $wp_customize->get_setting( 'cosmetic_footer_social_icon_3' )->transport = 'postMessage';
    $wp_customize->get_setting( 'cosmetic_footer_social_url_1' )->transport = 'postMessage';
    $wp_customize->get_setting( 'cosmetic_footer_social_url_2' )->transport = 'postMessage';
    $wp_customize->get_setting( 'cosmetic_footer_social_url_3' )->transport = 'postMessage';


    $wp_customize->add_control( 'footer_social_icon_1',
        array(
          'label' => __( '푸터 소셜 아이콘 #1', 'cosmetic' ), //set the label to appear in the Customizer
          'section' => 'footer', //select the section for it to appear under
          'settings' => 'cosmetic_footer_social_icon_1', //pick the setting it applies to
          'type' => 'text',
          'priority' => 31,
        )
     );
   $wp_customize->add_control( 'footer_social_url_1',
       array(
         'label' => __( '푸터 소셜 URL #1', 'cosmetic' ), //set the label to appear in the Customizer
         'section' => 'footer', //select the section for it to appear under
         'settings' => 'cosmetic_footer_social_url_1', //pick the setting it applies to
         'type' => 'text',
         'priority' => 32,
       )
    );
    $wp_customize->add_control( 'footer_social_icon_2',
        array(
          'label' => __( '푸터 소셜 아이콘 #2', 'cosmetic' ), //set the label to appear in the Customizer
          'section' => 'footer', //select the section for it to appear under
          'settings' => 'cosmetic_footer_social_icon_2', //pick the setting it applies to
          'type' => 'text',
          'priority' => 33,
        )
     );
    $wp_customize->add_control( 'footer_social_url_2',
        array(
          'label' => __( '푸터 소셜 URL #2', 'cosmetic' ), //set the label to appear in the Customizer
          'section' => 'footer', //select the section for it to appear under
          'settings' => 'cosmetic_footer_social_url_2', //pick the setting it applies to
          'type' => 'text',
          'priority' => 34,
        )
     );
     $wp_customize->add_control( 'footer_social_icon_3',
         array(
           'label' => __( '푸터 소셜 아이콘 #3', 'cosmetic' ), //set the label to appear in the Customizer
           'section' => 'footer', //select the section for it to appear under
           'settings' => 'cosmetic_footer_social_icon_3', //pick the setting it applies to
           'type' => 'text',
           'priority' => 35,
         )
      );
     $wp_customize->add_control( 'footer_social_url_3',
         array(
           'label' => __( '푸터 소셜 URL #3', 'cosmetic' ), //set the label to appear in the Customizer
           'section' => 'footer', //select the section for it to appear under
           'settings' => 'cosmetic_footer_social_url_3', //pick the setting it applies to
           'type' => 'text',
           'priority' => 36,
         )
      );
}
add_action( 'customize_register', 'themeslug_customize_register' );

// 사용자 정의하기 프리뷰 자바스크립트 파일 로드
function cosmetic_customizer_live_preview()
{
	wp_enqueue_script(
		  'cosmetic-themecustomizer',			//Give the script an ID
		  get_template_directory_uri().'/js/theme-customizer.js',//Point to file
		  array( 'jquery','customize-preview' ),	//Define dependencies
		  '',						//Define a version (optional)
		  true						//Put script in footer?
	);
}
add_action( 'customize_preview_init', 'cosmetic_customizer_live_preview' );

// 어드민 페이지 스타일 시트 적용
add_action( 'admin_enqueue_scripts', 'load_admin_styles' );

function load_admin_styles() {
 wp_enqueue_style( 'admin_css', get_template_directory_uri() . '/admin.css', false, '1.0.0' );

}

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

// 메뉴 아이템 클래스 픽스
function custom_special_nav_class( $classes, $item ) {
  $test = 0;
    global $taxonomy, $post;
    $test = 0;
    $front_page_id  = (int) get_option( 'page_on_front' );

    if( isset( $taxonomy ) && $taxonomy === "cosmetic_category" ){

        if ( $front_page_id === (int) $item->object_id ){

             $classes[] = "custom_for_taxonomy";

         } elseif( ( $key = array_search('current_page_parent', $classes )) !== false ) {

             unset($classes[$key]);

         }

    } elseif( isset( $post->post_type ) && $post->post_type === 'cosmetic' ){

        if( $front_page_id === (int) $item->object_id ){

              $classes[] = "custom_for_taxonomy";

        } elseif( ( $key = array_search('current_page_parent', $classes )) !== false ) {

            unset($classes[$key]);

        }

    }

    return $classes;

}
add_filter( 'nav_menu_css_class' , 'custom_special_nav_class' , 10, 2 );

// 일반 사용자 어드민 바 기능 끄기
add_action('after_setup_theme', 'remove_admin_bar');

function remove_admin_bar() {
  if (!current_user_can('administrator') && !is_admin()) {
    show_admin_bar(false);
  }
}
// 로그아웃 메뉴 추가하기
add_filter( 'wp_nav_menu_items', 'wti_loginout_menu_link', 10, 2 );

function wti_loginout_menu_link( $items, $args ) {
   if ($args->theme_location == 'top') {
      if (is_user_logged_in()) {
         $items .= '<li class="right"><a href="'. wp_logout_url() .'">'. "Log Out" .'</a></li>';
      }
   }
   if ($args->theme_location == 'primary') {
      if (is_user_logged_in()) {
         $items .= '<li class="right responsive"><a href="'. wp_logout_url() .'">'. "Log Out" .'</a></li>';
      }
   }
   return $items;
}

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
        'rewrite' => array( 'slug' => $slug, 'hierarchical' => true ),
      );
      register_taxonomy( $slug, 'cosmetic', $args );

  endforeach;
}
add_action( 'init', 'cosmetic_register_taxonomy' );

// 대시보드 접근 제한
add_action( 'init', 'blockusers_init' );

function blockusers_init() {
  if ( is_admin() && ! current_user_can( 'administrator' ) &&
    ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
    wp_redirect( home_url() );
    exit;
  }
}

// Favorite with Ajax
function process_favorite_callback(){

  global $current_user, $post;
  $test = 0;
  if ( ! check_ajax_referer( 'user-favorite', 'security' ) ) {
    wp_send_json_error( 'Security Check failed' );
  }
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $test = 0;
    $current_favorite_posts = array();
    $current_favorite_posts = get_user_meta( $current_user->ID, 'user-favorite', true ) === "" ? array() : get_user_meta( $current_user->ID, 'user-favorite', true );
    $favorite_post = sanitize_text_field($_POST['favoritePostId']);

    $current_favorite_count = get_post_meta( intval($favorite_post), 'favorite_count', true );

    if( $_POST['favorite'] === 'remove' ){

        if( ($key = array_search( $favorite_post, $current_favorite_posts )) !== false ){
          unset( $current_favorite_posts[$key] );
        }

      update_user_meta( $current_user->ID, 'user-favorite', $current_favorite_posts );

      $update_favorite_count = $current_favorite_count - 1;

    } elseif( $_POST['favorite'] === 'add' ) {

      $update_favorite_count = intval($current_favorite_count) + 1;
      $current_favorite_posts[] = $favorite_post;
      $current_favorite_posts = array_unique( $current_favorite_posts );
      $test = 0;
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

// 회원가입 ajax
function user_regi_validation_callback(){
  $test = 0;
  if ( ! check_ajax_referer( 'login', 'security' ) ) {
    wp_send_json_error( 'Security Check failed' );
  }
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $form_data = $_POST['formData'];
    $user_info = array();
    parse_str($form_data, $user_info);

    global $username, $password, $email;
    $username = sanitize_user( $user_info['username'] );
    $password = esc_attr( $user_info['password'] );
    $email = sanitize_email( $user_info['email'] );

    registration_validation( $username, $password, $email );

    // call @function complete_registration to create the user
    // only when no WP_error is found
    complete_registration(
      $username,
      $password,
      $email
    );
  }

}
add_action( 'wp_ajax_user_regi_validation', 'user_regi_validation_callback' );
add_action( 'wp_ajax_nopriv_user_regi_validation', 'user_regi_validation_callback' );

// Login validation with ajax
function user_login_validation_callback(){
  $test = 0;
  if ( ! check_ajax_referer( 'login', 'security' ) ) {
    wp_send_json_error( 'Security Check failed' );
  }
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $test = 0;
    $form_data = $_POST['formData'];
    $user_info = array();
    parse_str($form_data, $user_info);

    if( empty($user_info['log']) || empty($user_info['pwd']) ){
      wp_send_json_error( 'Please fill out the form.' );
    }

    $credentials['user_login'] = sanitize_user( $user_info['log'] );
    $credentials['user_password'] = sanitize_text_field( $user_info['pwd'] );

    $user_obj = get_user_by( 'login', $credentials['user_login'] );

    if( false == $user_obj ){
      wp_send_json_error('Invalid Username or Password.');
    } else {
      $check_password = wp_check_password( $credentials['user_password'], $user_obj->user_pass, $user_obj->ID );
      if( !$check_password ){
        wp_send_json_error('Invalid Username or Password.');
      }
    }

    $secure_cookie = '';
    if ( $user_obj ) {
      if ( get_user_option('use_ssl', $user_obj->ID) ) {
        $secure_cookie = true;
        force_ssl_admin(true);
      }
    }

    $user = wp_signon( $credentials, $secure_cookie );


    wp_send_json_success('Success');

   }
}
add_action( 'wp_ajax_user_login_validation', 'user_login_validation_callback' );
add_action( 'wp_ajax_nopriv_user_login_validation', 'user_login_validation_callback' );

// Front Page Pagination with ajax
function front_page_pagination_callback(){

  if ( ! check_ajax_referer( 'loadmore', 'security' ) ) {
    wp_send_json_error( 'Security Check failed' );
  }
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $page = sanitize_text_field($_POST['page']);
    $posts_per_page = 5;
    $slug = isset( $_POST['slug'] ) ? sanitize_text_field($_POST['slug']) : '';
    $offset = $posts_per_page * $page;
    $template_for_ajax = isset( $_POST['template'] ) ? sanitize_text_field($_POST['template']) : '';

    $args = array(
      'post_type' => 'cosmetic',
      'tax_query' => array(
        array(
          'taxonomy' => 'cosmetic_category',
          'field' => 'slug',
          'terms' => $slug,
        ),
      ),
      'orderby'   => 'meta_value_num',
      'meta_key'  => 'product_ranking_order',
      'order' => 'ASC',
      'paged' => $page,
      'posts_per_page' => $posts_per_page,
      'offset' => $offset,
    );

    $query = new WP_Query( $args );

    if( $query->have_posts() ):

      while( $query->have_posts() ) : $query->the_post();
        include( locate_template( '/module/grid.php', false, false ) );
      endwhile;

      if( count( $query->posts ) % 5 !== 0 ) :

        for( $i = 0; $i < 5 - (count( $query->posts ) % 5); $i++ ) :
      ?>
          <div class="col-sm-12 col-md-4 col-lg-4 spare"></div>
    <?php
        endfor;

      endif;

      wp_reset_postdata();
    endif;

    die();
  }
}
add_action( 'wp_ajax_front_page_pagination', 'front_page_pagination_callback' );
add_action( 'wp_ajax_nopriv_front_page_pagination', 'front_page_pagination_callback' );

// Top 30 Pagination with Ajax
function top30_pagination_callback(){

  if ( ! check_ajax_referer( 'loadmore', 'security' ) ) {
    wp_send_json_error( 'Security Check failed' );
  }
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $page = sanitize_text_field($_POST['page']);
    $posts_per_page = 5;
    $slug = isset( $_POST['slug'] ) ? sanitize_text_field($_POST['slug']) : '';
    $offset = $posts_per_page * $page;
    $template_for_ajax = isset( $_POST['template'] ) ? sanitize_text_field($_POST['template']) : '';

    $args = array(
      'post_type' => 'cosmetic',
      'meta_query' => array(
        array(
          'key' => 'product_featured',
          'value' => 'featured',
        ),
        array(
          'key' => 'product_featured_order',
          'value_num' => '30',
          'compare' => '=<',
        ),
      ),
      'orderby'   => 'meta_value_num',
      'meta_key'  => 'product_featured_order',
      'order' => 'ASC',
      'paged' => $page,
      'posts_per_page' => $posts_per_page,
      'offset' => $offset,
    );

    $query = new WP_Query( $args );

    if( $query->have_posts() ):

      while( $query->have_posts() ) : $query->the_post();
        include( locate_template( '/module/grid.php', false, false ) );
      endwhile;

      if( count( $query->posts ) % 5 !== 0 ) :

        for( $i = 0; $i < 5 - (count( $query->posts ) % 5); $i++ ) :
      ?>
          <div class="col-sm-12 col-md-4 col-lg-4 spare"></div>
    <?php
        endfor;

      endif;

      wp_reset_postdata();
    endif;

    die();
  }
}
add_action( 'wp_ajax_top30_pagination', 'top30_pagination_callback' );
add_action( 'wp_ajax_nopriv_top30_pagination', 'top30_pagination_callback' );

// Brand Pagination with Ajax
function brand_pagination_callback(){

  if ( ! check_ajax_referer( 'loadmore', 'security' ) ) {
    wp_send_json_error( 'Security Check failed' );
  }
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $page = sanitize_text_field($_POST['page']);
    $posts_per_page = 5;
    $slug = isset( $_POST['slug'] ) ? sanitize_text_field($_POST['slug']) : '';
    $offset = $posts_per_page * $page;
    $template_for_ajax = isset( $_POST['template'] ) ? sanitize_text_field($_POST['template']) : '';

    $args = array(
      'post_type' => 'cosmetic',
      'tax_query' => array(
        array(
          'taxonomy' => 'cosmetic_brand',
          'field' => 'slug',
          'terms' => $slug,
        ),
      ),
      'orderby'   => 'meta_value_num',
      'meta_key'  => 'product_brand_order',
      'order' => 'ASC',
      'paged' => $page,
      'posts_per_page' => $posts_per_page,
      'offset' => $offset,
    );

    $query = new WP_Query( $args );

    if( $query->have_posts() ):

      while( $query->have_posts() ) : $query->the_post();
        include( locate_template( '/module/grid.php', false, false ) );
      endwhile;

      if( count( $query->posts ) % 5 !== 0 ) :

        for( $i = 0; $i < 5 - (count( $query->posts ) % 5); $i++ ) :
      ?>
          <div class="col-sm-12 col-md-4 col-lg-4 spare"></div>
    <?php
        endfor;

      endif;

      wp_reset_postdata();
    endif;

    die();
  }
}
add_action( 'wp_ajax_brand_pagination', 'brand_pagination_callback' );
add_action( 'wp_ajax_nopriv_brand_pagination', 'brand_pagination_callback' );

// New Pagination with Ajax
function new_pagination_callback(){

  if ( ! check_ajax_referer( 'loadmore', 'security' ) ) {
    wp_send_json_error( 'Security Check failed' );
  }
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $page = sanitize_text_field($_POST['page']);
    $posts_per_page = 5;
    $slug = isset( $_POST['slug'] ) ? sanitize_text_field($_POST['slug']) : '';
    $offset = $posts_per_page * $page;
    $template_for_ajax = isset( $_POST['template'] ) ? sanitize_text_field($_POST['template']) : '';

    $args = array(
      'post_type' => 'cosmetic',
      'orderby'   => 'ID',
      'post_status' => 'publish',
      'paged' => $page,
      'posts_per_page' => $posts_per_page,
      'offset' => $offset,
    );

    $query = new WP_Query( $args );

    if( $query->have_posts() ):

      while( $query->have_posts() ) : $query->the_post();
        include( locate_template( '/module/grid.php', false, false ) );
      endwhile;

      if( count( $query->posts ) % 5 !== 0 ) :

        for( $i = 0; $i < 5 - (count( $query->posts ) % 5); $i++ ) :
      ?>
          <div class="col-sm-12 col-md-4 col-lg-4 spare"></div>
    <?php
        endfor;

      endif;

      wp_reset_postdata();
    endif;

    die();
  }
}
add_action( 'wp_ajax_new_pagination', 'new_pagination_callback' );
add_action( 'wp_ajax_nopriv_new_pagination', 'new_pagination_callback' );

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
function cosmetic_ranking_index( $template_for_ajax = null ){

  global $term, $taxonomy, $pagename;

  if( $term && $taxonomy ){
    $this_term = get_term_by( 'slug', $term, $taxonomy );
  }

  $test = 0;

  if( !empty( $template_for_ajax ) ){

    $is_front_page = $is_top30 =
    $is_tax_parent = $is_tax_descendant =
    $is_brand = false;

    switch ( $template_for_ajax ) {
      case 'front-page':
        $is_front_page = true;
        break;
      case 'top30':
        $is_top30 = true;
        break;
      case 'brand':
        $is_brand = true;
        break;
    }
  } else {
    $is_front_page = ( is_front_page() ) && ( $pagename === '' ) ? true : false;
    $is_top30 = ( is_page_template( '/page-templates/template-top30.php' ) )
                || ( $pagename === 'top-30' ) ? true : false;
    $is_tax_parent = ( is_tax() ) && ( !$this_term->parent ) ? true : false;
    $is_tax_descendant = ( is_tax() ) && ( $this_term->parent ) ? true : false;
    $is_brand =( is_page_template( '/page-templates/template-brand.php' ) )
                 || ( $pagename === 'sort-by-brand' ) ? true : false;;
  }

   switch ( true ) {

     case $is_front_page :

       $ranking_changed = get_post_meta( get_the_ID(), 'product_ranking_changed', true );

       break;

     case $is_top30 :

       $ranking_changed = get_post_meta( get_the_ID(), 'featured_ranking_changed', true );

       break;

     case $is_tax_parent:

       $ranking_changed = get_post_meta( get_the_ID(), 'product_ranking_changed', true );

       break;

     case $is_tax_descendant:

       $ranking_changed = get_post_meta( get_the_ID(), 'descendant_ranking_changed', true );

       break;

     case $is_brand :

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

      $user_favorite = !empty(get_user_meta( $current_user->ID, 'user-favorite',true))
      ? get_user_meta( $current_user->ID, 'user-favorite', true) : 0;

      if( is_array( $user_favorite ) ) {

        $search_in_user_meta = array_search( get_the_ID(), $user_favorite );

      } else {

        $search_in_user_meta = strpos( $user_favorite, get_the_ID() );

      }

      if( ($search_in_user_meta !== false ) ) :

          if( is_page_template( 'page-templates/template-favorite.php' ) ) :
            ?>
            <button type="button" name="favorite" class="favorite-button saved remove" data-post-id="<?php echo get_the_ID(); ?>">
               Remove
            </button>
      <?php else : ?>
            <button type="button" name="favorite" class="favorite-button saved" data-post-id="<?php echo get_the_ID(); ?>">
               Saved
            </button>
      <?php endif; ?>

<?php else : ?>

        <button type="button" name="favorite" class="favorite-button" data-post-id="<?php echo get_the_ID(); ?>">
          Save
        </button>

    <?php endif; ?>

  <?php else : ?>

    <button type="button" name="favorite" class="is-not-logged" data-post-id="<?php echo get_the_ID(); ?>">
      Save
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
