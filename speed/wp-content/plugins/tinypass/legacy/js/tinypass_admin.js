var tinypass = {

	addPriceOption: function(){
		if(typeof scope == 'undefined')
			scope = null;
		var count = jQuery(".option_form:visible", scope).size();
		if(count <= 3){
			var opt = count+1;
			jQuery("#po_en" + opt, scope).val(1);
			jQuery(".option_form" + opt, scope).show('fast');
			jQuery(".option_form" + opt, scope).find("input, select").removeAttr("disabled");
		}
	},
	removePriceOption: function(){
		if(typeof scope == 'undefined')
			scope = null;
		var count = jQuery(".option_form:visible", scope).size();
		if(count > 1){
			var opt = count;
			jQuery("#po_en" + opt, scope).val(0);
			jQuery(".option_form" + opt, scope).hide('fast');
			jQuery(".option_form" + opt, scope).find("input, select").attr("disabled", "disabled");
		}
	},

	showTinyPassPopup: function(type, termId){

		var self = this;

		if(termId){
			data = 'tagPopup=t&action=tp_showEditPopup&tp_type=' + type + "&term_id=" + termId;
		}else{
			var data = jQuery('form').serialize();
			data += '&action=tp_showEditPopup&tp_type=' + type;
		}

		jQuery.post(ajaxurl, data, function(response) {
			jQuery("#tp_dialog").html(response);
			jQuery("#tp_dialog").dialog({
				minWidth:700
			});
		});

	},
	deleteTagOption:function(termId){
		data = 'tagPopup=t&action=tp_deleteTagOption&tp_type=tag&term_id=' + termId;

		data += "&tinypass_nonce=" + jQuery("#tinypass_nonce").val();

		jQuery.post(ajaxurl, data, function(response) {
			jQuery("#tp_hidden_options").html(response);
			jQuery("#tp_dialog").dialog('close');
		});
	},

	doError:function(fieldName, msg){
		jQuery("#tp-error").append("<p> &bull; " + msg + "</p>");
		jQuery('*[name*="'+fieldName+'"]').addClass("form-invalid tp-error");
	},

	clearError:function(fieldName, msg){
		jQuery(".form-invalid").removeClass("form-invalid");
		jQuery(".tp-error").removeClass("tp-error");
		jQuery("#tp-error").html("");
	},

	saveTinyPassPopup:function(){
		var data = jQuery('#tp_dialog *').serialize();
		data += '&action=tp_saveEditPopup';

		// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
		jQuery.post(ajaxurl, data, function(response) {
			if(response.indexOf("var a;") >= 0)
				eval(response);
			else {
				jQuery("#tp_hidden_options").html(response);
				jQuery("#tp_dialog").dialog('close');
			}
		});
	},

	closeTinyPassPopup:function(){
		jQuery("#tp_dialog").dialog('close');
	},

	showMeteredOptions: function(elem){
		var elem = jQuery(elem);
		var type = elem.val()

		jQuery(".tp-metered-options").hide();
		jQuery(".tp-metered-options :input").attr('disabled', 'disabled')
		jQuery("#tp-metered-" + type).show();
		jQuery("#tp-metered-" + type + " :input").removeAttr('disabled');
	},

	log:function(msg){
		if(console && console.log)
			console.log(msg);
	},
	fullHide:function(selector, scope){
		jQuery(selector).hide();
	//jQuery("input, textarea, select", selector).attr("disabled", "disabled");
	},
	fullShow:function(selector){
		jQuery(selector).show();
	//jQuery("input, textarea, select", selector).removeAttr("disabled");
	},

	enablePaywall:function(form){
		var data = jQuery(form).serialize();
		data += '&action=tp_enablePaywall';
		jQuery.post(ajaxurl, data, function(response) {
			});
	},

	showEditRIDPopup:function(rid){
		jQuery("#tp-edit-rid-dialog #rid").val(rid);
		jQuery("#tp-edit-rid-dialog #value").val(rid);
		jQuery("#tp-edit-rid-dialog").dialog({
			title:'Modify your Resource ID (RID) ',
			modal: true,
		})

	},

	closeEditRIDPopup:function() {
		jQuery(".ui-dialog-content").dialog("close");
	},

	updateRID:function(elem){
		var form = jQuery(elem).parents("form");
		var data = jQuery(form).serialize();
		data += '&action=tp_updateRID';
		alert(data);
		jQuery.post(ajaxurl, data, function(response) {
			location.reload();
		});
	}





}