(function($){

  $(function(){
    $('.flexslider').flexslider();  
    $('.latest-posts').flexslider({
      controlNav: false,
      slideshow: false
    });
    
    var prevImage = $('.post-wrapper .slides .list-box:last-child').find('.latest-post-thumb img').attr('srcset');
    var previmagelink = $('.post-wrapper .slides .list-box:last-child').find('.latest-post-thumb img').attr('link');
    $('.previous-latest-post a').attr('href',previmagelink);
    $('.previous-latest-post a').html(prevImage);
    var nextImage = $('.post-wrapper .slides .list-box:nth-child(2)').find('.latest-post-thumb img').attr('srcset');
    var nextimagelink = $('.post-wrapper .slides .list-box:nth-child(2)').find('.latest-post-thumb img').attr('link');
    $('.next-latest-post a').attr('href',nextimagelink);
    $('.next-latest-post a').html(nextImage);
      
    $(".post-wrapper .flex-direction-nav a").click(function(){ 
       //var fullImage = $('.post-wrapper .slides .flex-active-slide .latest-post-thumb img').attr('src');
      var prevImage = $('.post-wrapper .slides .flex-active-slide:not(:first-child)').prev('.list-box').find('.latest-post-thumb img').attr('srcset');
      var previmagelink = $('.post-wrapper .slides .flex-active-slide:not(:first-child)').prev('.list-box').find('.latest-post-thumb img').attr('link');
      $('.previous-latest-post a').attr('href',previmagelink);
      $('.previous-latest-post a').html(prevImage);
      var nextImage = $('.post-wrapper .slides .flex-active-slide:not(:last-child)').next('.list-box').find('.latest-post-thumb img').attr('srcset');
      var nextimagelink = $('.post-wrapper .slides .flex-active-slide:not(:last-child)').next('.list-box').find('.latest-post-thumb img').attr('link');
      $('.next-latest-post a').attr('href',nextimagelink);
      $('.next-latest-post a').html(nextImage);

      if($('.post-wrapper .slides .flex-active-slide').is(":first-child")){
        var prevImage = $('.post-wrapper .slides .list-box:last-child').find('.latest-post-thumb img').attr('srcset');
        var previmagelink = $('.post-wrapper .slides .list-box:last-child').find('.latest-post-thumb img').attr('link');
        $('.previous-latest-post a').attr('href',previmagelink);
        $('.previous-latest-post a').html(prevImage);
      }
      if($('.post-wrapper .slides .flex-active-slide').is(":last-child")){
        var nextImage = $('.post-wrapper .slides .list-box:first-child').find('.latest-post-thumb img').attr('srcset');
        var nextimagelink = $('.post-wrapper .slides .list-box:first-child').find('.latest-post-thumb img').attr('link');
        $('.next-latest-post a').attr('href',nextimagelink);
        $('.next-latest-post a').html(nextImage);
      }
    }); 
  });


})(jQuery);

// jQuery powered scroll to top

jQuery(document).ready(function(){

	//Check to see if the window is top if not then display button
	jQuery(window).scroll(function(){ 
		if (jQuery(this).scrollTop() > 100) {
			jQuery('.scroll-to-top').fadeIn();
		} else {
			jQuery('.scroll-to-top').fadeOut();  
		}
	});

	//Click event to scroll to top
	jQuery('.scroll-to-top').click(function(){
		jQuery('html, body').animate({scrollTop : 0},800);
		return false;
	});
	

});
