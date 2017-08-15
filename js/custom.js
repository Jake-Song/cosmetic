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

})
