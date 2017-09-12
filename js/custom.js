jQuery( document ).ready( function($){

  // Product menu active

    $('.product > ul > li > a').each( function(){
      var href = $(this).attr('href');
      var location = window.location.href.replace(/\/$/, "");

      if( href == location ){
        $(this).parent().addClass('active');
      } else {
        $(this).parent().removeClass('active');
      }
  } );

  $('.sub-product > ul > li > a').each( function(){
    var childHref = $(this).attr('href');
    var childLocation = window.location.href;
    var parentLocation = window.location.href.replace(/\/[a-z0-9_.-]*\/$/, "");

    if( childHref == childLocation ){
      $(this).parent().addClass('active');
      $(".product > ul > li > a[href='"+ parentLocation +"']").parent().addClass('active');
    } else {
      $(this).parent().removeClass('active');
    }
  } );

  // Load Contents with ajax

  var newLocation = '',
  firstLoad = false;
  isLoading = false;

  $('.filter').on('click', 'ul li a', function(e){
    e.preventDefault();
    var newPage = $(this).attr('href');

    if(!isLoading) changePage( newPage, true );
    firstLoad = true;
  });

  $(window).on('popstate', function() {
    if( firstLoad ) {
      /*
      Safari emits a popstate event on page load - check if firstLoad is true before animating
      if it's false - the page has just been loaded
      */
      var newPage = location.href;

      if( !isLoading  &&  newLocation != newPage ) changePage(newPage, false);

    }
    firstLoad = true;
  });

  function changePage( url, bool ) {
    isLoading = true;
    loadContent( url, bool);
    newLocation = url;
  }

  function loadContent( url, bool ){
    var test = 0;
    $.ajaxSetup({ cache: false });

        var section = $('<article class="post clearfix"></article>');

        section.load(url+' article.post > *', function(event){
          // load new content and replace <main> content with the new one
          $('.ajax-container').html(section);
          isLoading = false;

          if(url!=window.location && bool){
            //add the new page to the window.history
            //if the new page was triggered by a 'popstate' event, don't add it
            window.history.pushState({path: url},'',url);
          }
        });
  }

  // Favorite Ajax

  $('body').on('click', '.favorite-button', function(event){
    event.preventDefault();

    //var isLoading = false;

    var favoritePostId = $(this).attr("data-post-id");
    var favorite = $(this).hasClass('saved') ? 'remove' : 'add';

    if(!isLoading){
      loadFavoriteAjax( favoritePostId, favorite, event );
    }
  });

  function loadFavoriteAjax( favoritePostId, favorite, event ){

    isLoading = true;

    if( !$(event.target).hasClass('remove') ){
      favoriteAjax( favoritePostId, favorite );
    } else {
      removeFavoriteAjax( favoritePostId, favorite );
    }
  }

  function favoriteAjax( favoritePostId, favorite ){

    $.ajax({
      url: ajaxHandler.adminAjax,
      type: 'POST',
      dataType: 'json',
      data: {
        action: 'process_favorite',
        favoritePostId: favoritePostId,
        security: ajaxHandler.securityFavorite,
        favorite: favorite,
      },
      success: function( response ){
        $('.favorite-count.post-id-' + favoritePostId).text( response.data.favorite_count +' Saves' );
        if( !$(".favorite-button[data-post-id='" + favoritePostId + "']").hasClass('saved') ){
          $(".favorite-button[data-post-id='" + favoritePostId +"']")
          .text('SAVED')
          .addClass('saved');
        } else {
          $(".favorite-button[data-post-id='" + favoritePostId +"']")
          .text('SAVE')
          .removeClass('saved');
        }
        isLoading = false;
      },
    });
  }

  // Wishlist Favorite Remove
  function removeFavoriteAjax( favoritePostId, favorite ){

      $.ajax({
        url: ajaxHandler.adminAjax,
        type: 'POST',
        dataType: 'json',
        data: {
          action: 'process_favorite',
          favoritePostId: favoritePostId,
          favorite: favorite,
          security: ajaxHandler.securityFavorite,
        },
        success: function( data ){
          $('.post-id-' + favoritePostId).css('display', 'none');
          isLoading = false;
        }
      });
  }

  $('.is-not-logged').on('click', function(){
    $(this).addClass('onclick');
  });

// Pagination with ajax
$('.loadmore').on( 'click', function(){

  loadMoreAjax( this );

});

function loadMoreAjax( target ){
  var lastPage = $(target).siblings('.product-row').last();
  var pageNum = lastPage.attr('data-page');
  var pageNum = parseInt(pageNum);

  var max_num_pages = $(target).siblings('.max-num-pages').text();
  if( max_num_pages && (parseInt(max_num_pages) == pageNum) ){
    return false;
  }

  var slug = $(target).parent().attr('data-slug');
  var that = target;

  $.ajax({
    url: ajaxHandler.adminAjax,
    type: 'POST',
    data: {
      action: 'process_pagination',
      security: ajaxHandler.securityLoadmore,
      page: pageNum,
      slug: slug,
    },
    success: function(response){

      var container = $('<div class="product-row"></div>');
      container.attr('data-page', pageNum + 1).html(response);
      container.insertAfter( lastPage );
      if( parseInt(max_num_pages) == (pageNum + 1) ){
        $(that).text('Close').unbind().on('click', function(){
          $(this).parent().find(".product-row").not( $(".product-row")[0] ).remove();
          $(this).text('Load More').unbind().on('click', function(){
            loadMoreAjax(this);
          });
        });
      }
    },
    error: function(){

    },
  });
}

// Modal

if( document.querySelector(".register-modal") ){

  // Get the modal
  var modal = document.getElementById('register');
  var loginModal = document.getElementById('signin');

  // Get the button that opens the modal

  var btn = document.querySelector(".register-modal");
  var loginBtn = document.querySelector(".login-modal");

  // Get the <span> element that closes the modal
  var span = document.getElementsByClassName("close")[0];
  var loginSpan = document.getElementsByClassName("close")[1];

  // When the user clicks on the button, open the modal
  btn.onclick = function(e) {
      e.preventDefault();
      modal.style.display = "block";
  }
  loginBtn.onclick = function(e) {
      e.preventDefault();
      loginModal.style.display = "block";
  }
  // When the user clicks on <span> (x), close the modal
  span.onclick = function() {
      modal.style.display = "none";
      var errorMsg = document.getElementsByClassName('error')[0];
      errorMsg.parentNode.removeChild(errorMsg);
  }
  loginSpan.onclick = function() {
      loginModal.style.display = "none";
      var errorMsg = document.getElementsByClassName('error')[0];
      errorMsg.parentNode.removeChild(errorMsg);
  }
  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
      if (event.target == modal) {
          modal.style.display = "none";
          loginModal.style.display = "none";
      }
  }
}
// Registration and Login with Ajax
var regiForm = $('#registration-form');
var loginForm = $('#loginform');

regiForm.on('submit', function( e ){

  e.preventDefault();

  var action = 'user_regi_validation';

  userFormAjax( regiForm, action );

});

loginForm.on('submit', function(e){

  e.preventDefault();

  var action = 'user_login_validation';

  userFormAjax( loginForm, action );

});

function userFormAjax( form, action ){
  var formData = form.serialize();
  var test = 0;
  $.ajax({
    url: ajaxHandler.adminAjax,
    type: 'POST',
    dataType: 'json',
    data: {
      action: action,
      security: ajaxHandler.securityLogin,
      formData: formData,
    },
    beforeSend: function(){

    },
    success: function( response ){
      if( true === response.success ){

          if( action == 'user_regi_validation' ){
            form.html(response.data);
          } else if ( action == 'user_login_validation' ) {
            window.location.reload();
          }

      } else if ( false === response.success ) {

          form.find('input').not('input[type="submit"]').val('');
          var errorMsg = $('<div class="error"></div>');
          errorMsg.html( response.data );
          if( form.siblings('.error') ){
            form.siblings('.error').remove();
          }
          errorMsg.insertBefore(form);
      }
    },
  });
}

})
