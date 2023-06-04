jQuery(function($){
 	"use strict";
   	jQuery('.main-menu-navigation > ul').superfish({
		delay:       0,
		animation:   {opacity:'show',height:'show'},  
		speed:       'fast'
   	});
});

// scroll
jQuery(document).ready(function () {
  jQuery(window).scroll(function () {
    if (jQuery(this).scrollTop() > 0) {
      jQuery('#scroll-top').fadeIn();
    } else {
      jQuery('#scroll-top').fadeOut();
    }
  });
  jQuery(window).on("scroll", function () {
    document.getElementById("scroll-top").style.display = "block";
  });
  jQuery('#scroll-top').click(function () {
    jQuery("html, body").animate({
      scrollTop: 0
    }, 600);
    return false;
  });
  educator_education_MobileMenuInit();
});

// preloader
jQuery(function($){
  setTimeout(function(){
    $("#loader-wrapper").delay(1000).fadeOut("slow");
  });
});

function educator_education_MobileMenuInit() {

  /* First and last elements in the menu */
  var educator_education_firstTab = jQuery('.responsive-menu ul:first li:first a');
  var educator_education_lastTab  = jQuery('a.closebtn'); /* Cancel button will always be last */

  jQuery(".responsive-toggle").click(function(e){
    e.preventDefault();
    e.stopPropagation();
    jQuery('body').addClass("noscroll");
    educator_education_firstTab.focus();
  });

  jQuery("a.closebtn").click(function(e){
    e.preventDefault();
    e.stopPropagation();
    jQuery('body').removeClass("noscroll");
    jQuery(".responsive-toggle").focus();
  });

  /* Redirect last tab to first input */
  educator_education_lastTab.on('keydown', function (e) {
    if (jQuery('body').hasClass('noscroll'))
    if ((e.which === 9 && !e.shiftKey)) {
      e.preventDefault();
      educator_education_firstTab.focus();
    }
  });

  /* Redirect first shift+tab to last input*/
  educator_education_firstTab.on('keydown', function (e) {
    if (jQuery('body').hasClass('noscroll'))
    if ((e.which === 9 && e.shiftKey)) {
      e.preventDefault();
      educator_education_lastTab.focus();
    }
  });

  /* Allow escape key to close menu */
  jQuery('.sidebar-responsive').on('keyup', function(e){
    if (jQuery('body').hasClass('noscroll'))
    if (e.keyCode === 27 ) {
      jQuery('body').removeClass('noscroll');
      educator_education_lastTab.focus();
    };
  });
}

jQuery(document).ready(function() {
  var owl = jQuery('#courses-section .owl-carousel');
    owl.owlCarousel({
      nav: true,
      autoplay:false,
      autoplayTimeout:2000,
      autoplayHoverPause:true,
      loop: true,
      navText : ['<i class="fas fa-chevron-left"></i>','<i class="fas fa-chevron-right"></i>'],
      responsive: {
        0: {
          items: 1
        },
        600: {
          items: 2
        },
        1000: {
          items: 3
      }
    }
  })
});