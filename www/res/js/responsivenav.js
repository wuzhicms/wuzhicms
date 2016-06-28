/*
    像素格工作室 Pixel grid studio www.pxgrids.com
*/
jQuery(function($){
var PXGRIDS = window.PXGRIDS || {};
PXGRIDS.subMenu = function(){
	$('#top_menu').supersubs({
		minWidth: 12,
		maxWidth: 27,
		extraWidth: 0 // set to 1 if lines turn over
	}).superfish({
		delay: 0,
		animation: {opacity:'show'},
		speed: 'fast',
		autoArrows: false,
		dropShadows: false
	});	
}

var mobileMenuClone = $('#menu').clone().attr('id', 'navigation-mobile');
PXGRIDS.mobileNav = function(){
	var windowWidth = $(window).width();
	// Show Menu or Hide the Menu
	if( windowWidth <= 986 ) {
		if( $('#mobile-nav').length > 0 ) {
			mobileMenuClone.insertAfter('header');
			$('#navigation-mobile #top_menu').attr('id', 'menu-nav-mobile').wrap('<div class="container"><div class="row"><div class="col-sm-12" />');
		}
	} else {
		$('#navigation-mobile').css('display', 'none');
		if ($('#mobile-nav').hasClass('open')) {
			$('#mobile-nav').removeClass('open');	
		}
	}
}
PXGRIDS.listenerMenu = function(){
	$('#mobile-nav,#navigation-mobile li a').on('click', function(e){
		$(this).toggleClass('open');
		
		$('#navigation-mobile').stop().slideToggle(350, 'easeOutExpo');
		
		e.preventDefault();
	});
}
$(document).ready(function(){
	PXGRIDS.mobileNav();
	PXGRIDS.listenerMenu();

});
$(window).resize(function(){

	PXGRIDS.mobileNav();
});
});
