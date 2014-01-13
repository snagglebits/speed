jQuery(function(){

	if ( typeof tinypass == 'undefined') {
		tinypass = {}
	}

	tinypass.showAppeal = function() {
		jQuery("#tinypass-appeal-dialog").dialog({
			minWidth:480,
			modal: true,
			closeOnEscape: true,
			closeText: "x",
			zIndex: 50000,
			dialogClass: 'tp-appeal-dialog'
		});
	}

})