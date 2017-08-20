jQuery( document ).ready( function($){

  // ajax

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

  // registration
  $(".tab_content_login").hide();
		$("ul.tabs_login li:first").addClass("active_login").show();
		$(".tab_content_login:first").show();
		$("ul.tabs_login li").click(function() {
			$("ul.tabs_login li").removeClass("active_login");
			$(this).addClass("active_login");
			$(".tab_content_login").hide();
			var activeTab = $(this).find("a").attr("href");
			if ($.browser.msie) {$(activeTab).show();}
			else {$(activeTab).show();}
			return false;
		});

  // Favorite Ajax

  $('.favorite-button').on('click', function(e){
    e.preventDefault();

    var favoritePostId = $(this).attr("data-post-id");
    var favorite = $(this).hasClass('saved') ? 'remove' : 'add';

    $.ajax({
      url: ajaxHandler.adminAjax,
      type: 'POST',
      dataType: 'json',
      data: {
        action: 'process_favorite',
        favoritePostId: favoritePostId,
        security: ajaxHandler.security,
        favorite: favorite,
      },
      success: function( response ){
        $('.favorite-count.post-id-' + favoritePostId).text( response.data.favorite_count );
        if( !$(".favorite-button[data-post-id='" + favoritePostId + "']").hasClass('saved') ){
          $(".favorite-button[data-post-id='" + favoritePostId +"']")
          .text('SAVED')
          .addClass('saved');
        } else {
          $(".favorite-button[data-post-id='" + favoritePostId +"']")
          .text('SAVE')
          .removeClass('saved');
        }

      },
    });
  })
  $('.is-not-logged').on('click', function(){
    $(this).addClass('onclick');
  })

})
