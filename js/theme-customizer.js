jQuery(document).ready(function($){

  // 로고
  wp.customize( 'logo_settings', function( a,b,c ) {
    console.log(a,b,c);
    value.bind( function( newval ) {
      var imgID = JSON.stringify( newval );
      $('.site-header .title a').append( imgID );
    } );
  } );
  // 소셜 아이콘
  wp.customize( 'cosmetic_footer_social_icon_1', function( value ) {
    value.bind( function( newval ) {
      $( '.social a' ).eq(0).find('i').removeClass().addClass( newval );
    } );
  } );

  wp.customize( 'cosmetic_footer_social_url_1', function( value ) {
		value.bind( function( newval ) {
			$( '.social a' ).eq(0).attr( 'href', newval );
		} );
	} );

  wp.customize( 'cosmetic_footer_social_icon_2', function( value ) {
    value.bind( function( newval ) {
      $( '.social a' ).eq(1).find('i').removeClass().addClass( newval );
    } );
  } );

  wp.customize( 'cosmetic_footer_social_url_2', function( value ) {
		value.bind( function( newval ) {
			$( '.social a' ).eq(1).attr( 'href', newval );
		} );
	} );

  wp.customize( 'cosmetic_footer_social_icon_3', function( value ) {
    value.bind( function( newval ) {
      $( '.social a' ).eq(2).find('i').removeClass().addClass( newval );
    } );
  } );

  wp.customize( 'cosmetic_footer_social_url_3', function( value ) {
		value.bind( function( newval ) {
			$( '.social a' ).eq(2).attr( 'href', newval );
		} );
	} );

});
