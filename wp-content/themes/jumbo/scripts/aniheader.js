/**
 * cbpAnimatedHeader.js v1.0.0
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 *
 * Copyright 2013, Codrops
 * http://www.codrops.com
 */
var cbpAnimatedHeader = (function() {

	if( document.getElementById("widget-block")){
		containerposition = jQuery('#widget-block').offset();
		containertop = containerposition.top;
		scroll_line = containertop;
	} else {
		containerposition = jQuery('#content-container').offset();
		containertop = containerposition.top;
		containerpadding = jQuery('#content-container').css( 'paddingTop' ).toString().replace("px", "");
		scroll_line = ( parseInt(containertop)+parseInt(containerpadding) );
	}

	var docElem = document.documentElement,
		header = document.querySelector( '.wrapper-content' ),
		didScroll = false,
		changeHeaderOn = scroll_line;

	function init() {
		window.addEventListener( 'scroll', function( event ) {
			if( !didScroll ) {
				didScroll = true;
				setTimeout( scrollPage, 50 );
			}
		}, false );
	}

	function scrollPage() {
		var sy = scrollY();
		if ( sy >= changeHeaderOn ) {
			classie.add( header, 'header-shrink' );
		}
		else {
			classie.remove( header, 'header-shrink' );
		}
		didScroll = false;
	}

	function scrollY() {
		return window.pageYOffset || docElem.scrollTop;
	}

	init();

})();