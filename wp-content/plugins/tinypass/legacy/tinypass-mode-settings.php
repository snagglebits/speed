<?php
/**
 * This file is responsbile for confiuring, displaying, and saving
 * individual paywall settings.
 */
function tinypass_mode_settings() {

	$storage = new TPStorage();
	$errors = array();

	$ps = null;

	//Delete the paywall
	if (isset($_POST['_Delete'])) {

		if (isset($_POST['tinypass']['resource_id'])) {
			$rid = $_POST['tinypass']['resource_id'];
			$ss = $storage->getSiteSettings();
			$ps = $storage->getPaywall($rid, true);

			$storage->deletePaywall($ps);

			$location = 'admin.php?page=tinypass.php&msg=' . urlencode(__('Your paywall has been deleted!.'));
			wp_redirect($location);
		}
	} else if (isset($_POST['_Submit'])) {

		//Save the paywall
		$ss = $storage->getSiteSettings();
		$ps = $ss->validatePaySettings($_POST['tinypass'], $errors);
		if (count($errors) == 0) {
			$storage->savePaywallSettings($ss, $ps);
			$location = 'admin.php?page=TinyPassEditPaywall&rid=' . $ps->getResourceId() . "&msg=" . urlencode(__('Your paywall has been saved!.'));
			wp_redirect($location);
		}

	}

	$edit = false;
	$many = false;
	if ($ps == null) {
		$rid = 'wp_bundle1';
		$pws = $storage->getPaywalls(true);
		$many = count($pws) > 0;

		if (isset($_GET['rid']) && $_GET['rid'] != '') {
			$edit = true;
			$rid = $_GET['rid'];
		} else if ($pws != null || count($pws) > 1) {
			$last = 0;
			foreach ($pws as $ps) {
				$last = max($last, preg_replace('/[^0-9]*/', '', $ps->getResourceId()));
			}
			$rid = 'wp_bundle' . ($last + 1);
		}

		$ps = $storage->getPaywall($rid, true);
	}
	?>

	<div id="poststuff">
		<div class="tp-settings">

			<?php if (!count($errors)): ?>
				<?php if (!empty($_REQUEST['msg'])) : ?>
					<div class="updated fade"><p><strong><?php echo $_REQUEST['msg'] ?></strong></p></div>
				<?php endif; ?>
			<?php else: ?>
				<div id="tp-error" class="error fade"></div>
			<?php endif; ?>


			<div class="tp-section">

				<?php if ($many): ?>
					<div class="tp-all-paywalls-crumb">
						<a href="<?php menu_page_url("tinypass.php") ?>"> &lsaquo; <?php _e("All my paywalls") ?> </a>
					</div>
				<?php endif; ?>
				<?php __tinypass_section_head($ps, 1, __("Paywall mode"), '<div id="tp-hide-paywalls">
          <span>Hide paywall details</span>
          <img src="' . TINYPASS_IMAGE_DIR . 'closer.png">
        </div>
        <div id="tp-show-paywalls">
          <span>Show paywall details</span>
          <img src="' . TINYPASS_IMAGE_DIR . 'opener.png">
        </div>');
				?>


				<div id="tp_mode_details">
					<div id="tp_mode1_details" class="choice" mode="<?php echo TPPaySettings::MODE_PPV ?>" >
						<div class="inner">
							<img src="<?php echo TINYPASS_IMAGE_DIR ?>/icon-ppv.png">
							<div class="name"><?php echo TPPaySettings::MODE_PPV_NAME ?></div>
							<div class="sub">Purchase individual items</div>
							<div class="info">Sell access to individual blog posts. Set some default price options or tweak them per post.</div>
							<!--<div class="example">Examples: <a href="http://www.djbooth.net">djbooth.net</a></div>-->
						</div>
					</div>
					<div id="tp_mode2_details" class="choice" mode="<?php echo TPPaySettings::MODE_METERED ?>" >
						<div class="inner">
							<img src="<?php echo TINYPASS_IMAGE_DIR ?>/icon-metered.png">
							<div class="name"><?php echo TPPaySettings::MODE_METERED_NAME ?></div>
							<div class="sub">Preview period</div>
							<div class="info">Users can look at your content for a certain number of views, or for a certain time period.</div>
							<!--<div class="example">Examples: <a href="http://www.nytimes.com">The New York Times</a></div>-->
						</div>
					</div>
					<div id="tp_mode3_details" class="choice" mode="<?php echo TPPaySettings::MODE_STRICT ?>" >
						<div class="inner">
							<img src="<?php echo TINYPASS_IMAGE_DIR  ?>/icon-hard.png">
							<div class="name"><?php echo TPPaySettings::MODE_STRICT_NAME ?></div>
							<div class="sub">No preview</div>
							<div class="info">All of your tagged content is restricted by the paywall right from the beginning.</div>
							<!--<div class="example">Examples: <a href="http://www.thebostonglobe.com">The Boston Globe</a></div>-->
						</div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
				<div id="tp_modes">
					<div id="tp_mode1" class="choice" mode="<?php echo TPPaySettings::MODE_PPV ?>" <?php checked($ps->getMode(), TPPaySettings::MODE_PPV) ?> ><?php echo TPPaySettings::MODE_PPV_NAME ?></div>
					<div id="tp_mode2" class="choice" mode="<?php echo TPPaySettings::MODE_METERED ?>" <?php checked($ps->getMode(), TPPaySettings::MODE_METERED) ?>><?php echo TPPaySettings::MODE_METERED_NAME ?></div>
					<div id="tp_mode3" class="choice" mode="<?php echo TPPaySettings::MODE_STRICT ?>" <?php checked($ps->getMode(), TPPaySettings::MODE_STRICT) ?>><?php echo TPPaySettings::MODE_STRICT_NAME ?></div>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
			</div>
			<div class="hr"></div>


			<div id="tp_mode1_panel" class="tp_mode_panel">
				<form action="" method="post" autocomplete="off">
					<input class="tp_mode" name="tinypass[mode]" type="hidden">
					<div style="float:right">
						<input type="hidden" readonly="true" name="tinypass[resource_id]" value="<?php echo $ps->getResourceId() ?>">
						<input type="hidden" readonly="true" name="tinypass[en]" value="<?php echo $ps->getEnabled() ?>">
						<input type="hidden" readonly="true" name="tinypass[resource_name]" value="Pay-per-view">
					</div>
					<?php $num = 1; ?>
					<?php __tinypass_section_head($ps, ++$num, __("Pick and price your content")) ?>
					<?php __tinypass_tag_display($ps) ?>
					<?php __tinypass_pricing_display($ps) ?>
					<?php __tinypass_section_head($ps, ++$num, __("Messaging & appearances")) ?>
					<?php __tinypass_purchase_option_table_display($ps) ?>
					<?php __tinypass_save_buttons($ps, $edit) ?>
				</form>
			</div>


			<div id="tp_mode2_panel" class="tp_mode_panel">
				<form action="" method="post" autocomplete="off">
					<input class="tp_mode" name="tinypass[mode]" type="hidden">
					<div style="float:right">
						<input type="hidden" readonly="true" name="tinypass[resource_id]" value="<?php echo $ps->getResourceId() ?>">
						<input type="hidden" readonly="true" name="tinypass[en]" value="<?php echo $ps->getEnabled() ?>">
					</div>
					<?php $num = 1; ?>
					<?php __tinypass_section_head($ps, ++$num, __("Pick and price your content")) ?>
					<?php __tinypass_name_display($ps) ?>
					<?php __tinypass_tag_display($ps) ?>
					<?php __tinypass_pricing_display($ps) ?>
					<?php __tinypass_section_head($ps, ++$num, __("Customize your preview period")) ?>
					<?php __tinypass_metered_display($ps) ?>
					<?php __tinypass_counter_display($ps) ?>
					<?php __tinypass_section_head($ps, ++$num, __("Messaging & appearances")) ?>
					<?php __tinypass_purchase_option_table_display($ps) ?>
					<?php __tinypass_purchase_page_display($ps) ?>
					<?php __tinypass_save_buttons($ps, $edit) ?>
				</form>
			</div>

			<div id="tp_mode3_panel" class="tp_mode_panel">
				<form action="" method="post" autocomplete="off">
					<input class="tp_mode" name="tinypass[mode]" type="hidden">
					<div style="float:right">
						<input type="hidden" readonly="true" name="tinypass[resource_id]" value="<?php echo $ps->getResourceId() ?>">
						<input type="hidden" readonly="true" name="tinypass[en]" value="<?php echo $ps->getEnabled() ?>">
					</div>
					<?php $num = 1; ?>
					<?php __tinypass_section_head($ps, ++$num, __("Pick and price your content")) ?>
					<?php __tinypass_name_display($ps) ?>
					<?php __tinypass_tag_display($ps) ?>
					<?php __tinypass_pricing_display($ps) ?>
					<?php __tinypass_section_head($ps, ++$num, __("Messaging & appearances")) ?>
					<?php __tinypass_purchase_option_table_display($ps) ?>
					<?php __tinypass_purchase_page_display($ps) ?>
					<?php __tinypass_save_buttons($ps, $edit) ?>
				</form>
			</div>
		</div>
	</div>

	<script>
		var scope = '';
		jQuery(function(){
			var $ = jQuery;

			//setup modes
			$('#tp_modes .choice').hover(
			function(){
				$(this).addClass("choice-on");
			}, 
			function(){
				$(this).removeClass("choice-on");
			});

			$('#tp_mode_details .choice').click(function(){
				var index = $(this).index();
				var elem = $('#tp_modes .choice').get(index);
				$(elem).trigger('click');
			})

			$('#tp_modes .choice').click(function(){
				$('#tp_mode_details .choice').removeClass("choice-selected");
				$('#tp_modes .choice').removeClass("choice-selected");
				$('#tp_modes .choice').removeAttr("checked");

				$(this).addClass("choice-selected");
				$(this).attr("checked", "checked");
	  	                                                                                        													
				var elem = $(".choice[checked=checked]");
				var id = elem.attr("id");

				scope = '#' + id + '_panel';

				$(".tp_mode").val(elem.attr('mode'));

				$('#tp_mode_details #' + id + "_details").addClass("choice-selected");

				tinypass.fullHide('.tp_mode_panel');
				tinypass.fullShow(scope);

			});
			$("#tp_modes .choice[checked=checked]").trigger('click');

			$(".tag-holder").click(function(event){
				if($(event.target).hasClass("remove"))
					$(event.target).parent().remove();
			})

			function addTag(){
				var tag = $(".premium_tags", scope).val();
				if(tag == "")
					return;

				$(".tag-holder", scope).append("<div class='tag'><div class='text'>" + tag + "</div><div class='remove'></div>" 
					+ "<input type='hidden' name='tinypass[tags][]' value='" + tag  + "'>" 
					+ "</div>"
			);
				$(".premium_tags", scope).val("");
				$(".premium_tags", scope).focus();
			}
			$(".tag-entry .add_tag").click(function(){
				addTag();
			});

			$(".tag-entry .premium_tags").keypress(function(event){
				if(event.which == 13){
					addTag();
					event.stopPropagation();
					return false;
				}
			});
	  	                                                                                        									
			//toggle access_period after recurring is changed
			$('.recurring-opts-off').bind('change', function(){
				var index = $(this).attr("opt");
				if($(this).is(":checked")){
					$(scope + " .po_ap_opts" + index).removeAttr("disabled");
				}
			});

			$('.recurring-opts-on').bind('change', function(){
				var index = $(this).attr("opt");
				if($(this).is(":checked")){
					$(scope + " .po_ap_opts" + index).attr("disabled", "disabled");
				} else {
					$(scope + " .po_ap_opts" + index).removeAttr("disabled");
				}
			})
			$('.recurring-opts-on').trigger('change');

			$('.premium_tags').suggest("admin-ajax.php?action=ajax-tag-search&tax=post_tag",{minchars:2,multiple:false,multipleSep:""})


			$('.tp-slider').bind('click', function(event){
				$('.choice-selected', this).removeClass("choice-selected");
				var choice = $(event.target);
				choice.addClass('choice-selected');
				$("input", this).val(choice.parent().attr('val'));
			})

			tinypass.showMeteredOptions(document.getElementsByName("tinypass[metered]")[0])

			$('#tp-hide-paywalls').bind('click', function(event){
				$('#tp_mode_details').hide();
				$(this).hide();
				$('#tp-show-paywalls').show();
			})

			$('#tp-show-paywalls').bind('click', function(event){
				$('#tp_mode_details').slideDown('slow');
				$(this).hide();
				$('#tp-hide-paywalls').show();
			})
		
	<?php
	if (isset($_REQUEST['rid'])) {
		echo "$('#tp-hide-paywalls').trigger('click');";
	} else {
		echo "$('#tp-show-paywalls').trigger('click');";
	}
	?>
		});
	</script>

	<?php if (count($errors)): ?>
		<?php foreach ($errors as $key => $value): ?>
			<script>tinypass.doError("<?php echo $key ?>", "<?php echo $value ?>");</script>
		<?php endforeach; ?>
	<?php endif; ?>


<?php } ?>