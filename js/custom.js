jQuery( document ).ready( function($){

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

  $('body').on('click', '.page-numbers', function(e){
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

  function changePage(url, bool) {
    isLoading = true;
    loadContent(url, bool);
    newLocation = url;
  }

  function loadContent( url, bool ){

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

    var isLoading = false;

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
  }
  loginSpan.onclick = function() {
      loginModal.style.display = "none";
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
    success: function( data ){
      var test = 0;

      console.log(data);
      form.append(data);

    },
  });
}

})
