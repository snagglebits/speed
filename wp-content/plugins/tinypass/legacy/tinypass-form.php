<?php
/*
 * This file contains all form related helper methods for disaplying
 * form content either from settings, post settings, or various other popups
 */
add_action('wp_ajax_tp_showEditPopup', 'ajax_tp_showEditPopup');
add_action('wp_ajax_tp_saveEditPopup', 'ajax_tp_saveEditPopup');
wp_enqueue_script("jquery");
wp_enqueue_script("jquery-ui");
wp_enqueue_script('jquery-ui-dialog');

/**
 * AJAX callback to show the Tinypass options form for both tags and posts/pages
 */
function ajax_tp_showEditPopup() {
	if (!current_user_can('edit_posts'))
		die();

	tinypass_include();

	$postID = $_POST['post_ID'];

	$storage = new TPStorage();
	$ps = $storage->getPostSettings($postID);

	tinypass_post_form($ps, $postID);

	die();
}

/**
 * Save the post popup form
 */
function ajax_tp_saveEditPopup() {

	if (!current_user_can('edit_posts'))
		die();

	if (!wp_verify_nonce($_REQUEST['tinypass_nonce'], 'tinypass_options'))
		die('Security check failed');

	tinypass_include();

	$storage = new TPStorage();
	$errors = array();

	$ss = $storage->getSiteSettings();
	$ps = $ss->validatePostSettings($_POST['tinypass'], $errors);

	$storage->savePostSettings($_POST['post_ID'], $ps);

	if (count($errors)) {
		echo "var a; tinypass.clearError(); ";
		foreach ($errors as $field => $msg) {
			echo "tinypass.doError('$field', \"$msg\");";
		}
		die();
	}

	$ps = $storage->getPostSettings($_POST['post_ID']);
	echo tinypass_post_options_summary($ps);

	die();
}

/**
 * 
 * @param TPPaySettings $ps
 * @return string
 */
function tinypass_post_options_summary(TPPaySettings $ps) {

	$output = "";

	$resource_name = htmlspecialchars(stripslashes($ps->getResourceName()));
	$resource_id = htmlspecialchars(stripslashes($ps->getResourceId()));

	if ($resource_name == '')
		$resource_name = 'Default to post title';

	$en = $ps->isEnabled() ? __('Yes') : __('No');

	$output .= "<div><strong>Enabled:</strong>&nbsp;" . $en . "</div>";

	$output .= "<div><strong>Name:</strong>&nbsp;" . $resource_name . "</div>";

	$output .= "<div><strong>RID:</strong>&nbsp;" . $resource_id . "</div>";
	$line = "<div><strong>Pricing:</strong></div>";
	for ($i = 1; $i <= 3; $i++) {

		if ($ps->hasPriceConfig($i) == false)
			continue;

		$caption = $ps->getCaption($i);

		$line .= "<div style='padding-left:50px;'>" . $ps->getAccessFullFormat($i);

		if ($caption != '') {
			$line .= " - '" . htmlspecialchars(stripslashes($caption)) . "'";
		}

		$line .= "</div>";
	}

	$output .= $line;

	return $output;
}

/**
 * 
 */
function tinypass_post_header_form(TPPaySettings $postSettings) {
	?>

	<table class="form-table">
		<tr>
			<td>
				<input id="tp_modify_button" class="button" type="button" hef="#" onclick="return tinypass.showTinyPassPopup();return false;" value="Modify Options">
				<div id="tp_dialog" title="<img src='http://www.tinypass.com/favicon.ico'> Tinypass Options" style="display:none;"></div>
				<br>
			</td>
		</tr>

		<tr>
			<td>
				<span id="tp_hidden_options"><?php echo tinypass_post_options_summary($postSettings); ?> </span>
			</td>
		</tr>
	</table>

	<?php
}

/**
 * Method outputs the popup form for entering TP parameters.
 * Will work with both tag and post forms
 */
function tinypass_post_form(TPPaySettings $ps, $postID = null) {
	$resource_id = htmlspecialchars(stripslashes($ps->getResourceId()));

	if ($resource_id == '')
		$ps->setResourceId('wp_post_' . $postID);
	?>

	<div id="poststuff">
		<?php wp_nonce_field('tinypass_options', 'tinypass_nonce'); ?>
		<div class="tp-settings">
			<div id="tp-error"></div>
			<div class="inside">

				<input type="hidden" name="tinypass[post_ID]" value="<?php echo $postID ?>"/>
				<input type="hidden" name="post_ID" value="<?php echo $postID ?>"/>

				<div>
					<strong>Enable this Post:</strong> <input type="checkbox" autocomplete=off name="tinypass[en]" value="1" <?php echo checked($ps->isEnabled()) ?>>
				</div>

				<div class="tp-section">
				<div class="postbox">
					<h3><?php _e("Enter up to 3 price options") ?></h3>
					<div class="inside">
						<table class="tinypass_price_options_form">
							<tr>
								<th width="100"><?php _e('Price') ?></th>
								<th width="180"><?php _e('Length of access') ?></th>
								<th width="270"><?php _e('Caption (optional)') ?></th>
							</tr>
						</table>

						<?php echo __tinypass_price_option_display('1', $ps, false, 180) ?>
						<?php echo __tinypass_price_option_display('2', $ps, false, 180) ?>
						<?php echo __tinypass_price_option_display('3', $ps, false, 180) ?>

						<br>
						<a class="add_option_link button" href="#" onclick="tinypass.addPriceOption();return false;">Add</a>
						<a class="add_option_link button" href="#" onclick="tinypass.removePriceOption();return false;">Remove</a>
					</div>
				</div>
			</div>
				<?php echo __tinypass_payment_messaging_post_display($ps) ?>
				<?php echo __tinypass_custom_rid_display($ps) ?>
				<div>
					<center>
						<button class="button" type="button" onclick="tinypass.saveTinyPassPopup();">Save</button>
						<button class="button" type="button" onclick="tinypass.closeTinyPassPopup();">Cancel</button>
					</center>
				</div>
			</div>
		</div>
	</div>

<?php } ?>
<?php

/**
 * show settings section head
 */
function __tinypass_section_head(TPPaySettings $ps, $num, $text = '', $html = '') {
	?>

	<div class="tp-section-header">
		<div class="num"><?php echo $num ?></div>
		<?php echo $text ?>
		<?php echo $html ?>
	</div>

<?php } ?>
<?php

/**
 * Alternative settings section head 
 */
function __tinypass_section_head_alt($text = '') {
	?>

	<div class="tp-section-header">
		<?php echo $text ?>
	</div>

<?php } ?>
<?php

/**
 * Show the metered content section
 */
function __tinypass_counter_display(TPPaySettings $ps) {
	?>

	<div class="tp-section">
		<div class="info">
			<div class="heading"><?php _e('Add a preview counter') ?></div>
			<div class="slider">
				<?php echo tinypass_slider('tinypass[ct_en]', array('Off' => '0', 'On' => '1'), $ps->getCounterEnabled()) ?>
				<div class="clear"></div>
				<br>
			</div>
			<div class="desc">
				Show a small counter on the edge of the screen so users know how many free views they have left.
			</div>
			<div class="image">
				<img src="<?php echo TINYPASS_IMAGE_DIR ?>/support-counter.png">
			</div>
		</div>
		<div class="body">

			<div class="postbox">
				<!--
			<h3><?php _e('Where should clicking on the counter bring users?'); ?> </h3>
			<div class="inside">
				<div class="label">
					<input type="radio" name="tinypass[ct_onclick]" value="<?php echo TPPaySettings::CT_ONCLICK_NOTHING ?>" <?php checked($ps->isCounterOnClick(TPPaySettings::CT_ONCLICK_NOTHING)) ?>>
					Counter is not clickable
				</div>
				<div class="label">
					<input type="radio" name="tinypass[ct_onclick]" value="<?php echo TPPaySettings::CT_ONCLICK_PAGE ?>" <?php checked($ps->isCounterOnClick(TPPaySettings::CT_ONCLICK_PAGE)) ?>>
					Open the dedicated information page on your site in a new tab ( defined below )
				</div>
				<div class="label">
					<input type="radio" name="tinypass[ct_onclick]" value="<?php echo TPPaySettings::CT_ONCLICK_APPEAL ?>" <?php checked($ps->isCounterOnClick(TPPaySettings::CT_ONCLICK_APPEAL)) ?> >
					Open the pop-up appeal over the current page (appeal must be enabled first) 
				</div>
				<br>
			</div>
				-->
				<h3><?php _e('Customize it'); ?> </h3>
				<div class="inside">
					<div class="label">Where should the counter appear?
						<?php echo __tinypass_dropdown("tinypass[ct_pos]", array('1' => 'Top right', '2' => 'Top left', '3' => 'Bottom left', '4' => 'Bottom right'), $ps->getCounterPosition()) ?>
					</div>
					<div class="label">Only show the counter to user after
						<input type="text" name="tinypass[ct_delay]" size="2" value="<?php echo $ps->getCounterDelay(0) ?>">
						views
					</div>
				</div>
				<br> <br>
				<!--	
				<h3><?php _e('Create a custom preview counter'); ?> </h3>
				<div class="inside"> 
					<div class="">
						Override the default appeal design by creating a custom template file
						<br> <br>
				<?php echo get_template_directory() ?>/<b>tinypass_counter_display.php</b>
					</div>
				</div>
				-->
			</div>
		</div>
		<div class="clear"></div>
	</div>

<?php } ?>
<?php

/**
 * Show the metered content section
 */
function __tinypass_appeal_display(TPPaySettings $ps) {

	$num_views = $ps->getAppealNumViews(5);
	$freq = $ps->getAppealFrequency(2);
	$msg1 = esc_attr(stripslashes($ps->getAppealMessage1()));
	$msg2 = esc_attr(stripslashes($ps->getAppealMessage2()));
	?>

	<div class="tp-section">
		<div class="info">
			<div class="heading">Add an appeal pop-up</div>
			<div class="slider">
				<?php echo tinypass_slider('tinypass[app_en]', array('Off' => '0', 'On' => '1'), $ps->getAppealEnabled()) ?>
				<div class="clear"></div>
				<br>
			</div>
			<div class="desc">During the preview periods, you can trigger a lightbox overlay that asks users to purchase or subscribe.
				Pick what it says, how it looks, and when it appears.
			</div>
			<div class="image">
				<img src="<?php echo TINYPASS_IMAGE_DIR ?>/support-appeal.png">
			</div>
		</div>
		<div class="body">

			<div class="postbox">
				<h3><?php _e('When it appears'); ?> </h3>
				<div class="inside">
					<div id="" class="tp-appeal-config">
						<div class="inline-label">Pop-up the appeal after </div>
						<input type="text" size="3" maxlength="3" name="tinypass[app_views]" value="<?php echo $num_views ?>">
						<div class="inline-label">views, then continue to show it every </div>
						<input type="text" size="3" maxlength="3" name="tinypass[app_freq]" value="<?php echo $freq ?>">
						<div class="inline-label"> views until the preview period ends</div>
					</div>
				</div>
				<h3><?php _e('Add some messaging'); ?> </h3>
				<div class="inside">
					<div class="label">Enter a header</div>
					<input id="tp_pd_denied_msg1" name="tinypass[app_msg1]" value="<?php echo $msg1 ?>" size="60" maxlength="80">
					<br>

					<div class="label">Enter a description</div>
					<textarea id="tp_pd_denied_sub1" rows="3" cols="59" name="tinypass[app_msg2]"><?php echo $msg2 ?></textarea>
				</div>
				<!--
				<h3><?php _e('Create a custom appeal design'); ?> </h3>
				<div class="inside"> 
					<div class="">
						Override the default appeal design by creating a custom template file
						<br> <br>
				<?php echo get_template_directory() ?>/<b>tinypass_appeal_display.php</b>
					</div>
				</div>
				-->
			</div>
		</div>
		<div class="clear"></div>
	</div>

<?php } ?>
<?php

/**
 * Show the metered content section
 */
function __tinypass_metered_display(TPPaySettings $ps) {

	$metered = $ps->getMetered('count');

	$trial_period = $ps->getMeterTrialPeriod();
	$trial_period_type = $ps->getMeterTrialPeriodType();

	$lockout_period = $ps->getMeterLockoutPeriod('1');
	$lockout_period_type = $ps->getMeterLockoutPeriodType('week');

	$meter_count = $ps->getMeterMaxAccessAttempts(10);

	$times = TPSiteSettings::$PERIOD_CHOICES;
	?>

	<div class="tp-section">
		<div class="info">
			<div class="heading">How many previews?</div>
			<div class="desc">After a user hits their preview count, they will be required
				to pay for access until your timer resets.
			</div>
		</div>
		<div class="body">

			<div class="postbox">
				<h3><?php _e('Mode & Rules'); ?> </h3>
				<div class="inside">

					<table class="form-table">
						<tr>
							<td width="120" valign="middle">
								<div>
									<?php echo __tinypass_dropdown("tinypass[metered]", array('count' => 'Page views'), $metered, array("onchange" => "tinypass.showMeteredOptions(this)")) ?>
								</div>
							</td>
							<td style="border-left:1px solid #DFDFDF">

								<div id="tp-metered-count" class="tp-metered-options">
									<label>Users get</label>
									<input type="text" size="5" maxlength="5" name="tinypass[m_maa]" value="<?php echo $meter_count ?>">
									<label>free views within</label>
									<input type="text" size="5" maxlength="5" name="tinypass[m_lp]" value="<?php echo $lockout_period ?>">
									<?php echo __tinypass_dropdown("tinypass[m_lp_type]", $times, $lockout_period_type) ?>
								</div>

								<div id="tp-metered-time" class="tp-metered-options">
									<label>Users will have access for</label>
									<input type="text" size="5" maxlength="5" name="tinypass[m_tp]" value="<?php echo $trial_period ?>">
									<?php echo __tinypass_dropdown("tinypass[m_tp_type]", $times, $trial_period_type) ?>
									<label>then they will be locked out for</label>
									<input type="text" size="5" maxlength="5" name="tinypass[m_lp]" value="<?php echo $lockout_period ?>">
									<?php echo __tinypass_dropdown("tinypass[m_lp_type]", $times, $lockout_period_type) ?>
								</div>

							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
<?php } ?>
<?php

function __tinypass_save_buttons(TPPaySettings $ps, $edit = false) {
	?>

	<p>
		<?php if ($edit): ?>
			<input type="submit" name="_Submit" value="Save Changes" tabindex="4" class="button-primary" />
			<a href="<?php menu_page_url('tinypass.php') ?>" class="button-primary"> Cancel </a>
			<input type="submit" name="_Delete" value="Delete" tabindex="4" class="button-primary"  style="" onclick="return confirm('Are you sure you want to delete this paywall? All protected posts will become available for free.')"/>
		<?php else: ?>
			<input type="submit" name="_Submit" value="Create paywall" tabindex="4" class="button-primary" />
			<a href="<?php menu_page_url('tinypass.php') ?>" class="button-primary"> Cancel </a>
		<?php endif; ?>
	</p>

<?php } ?>
<?php

function __tinypass_purchase_page_display(TPPaySettings $ps) { ?>

	<div class="tp-section">

		<div class="info">
			<div class="heading">Add a 'Read More' landing page</div>
			<div class="desc">Will you have a page on your site that talks about how great your content and why
				your users should buy it?
				<br><br>
				Specify the page here and Tinypass will give you a shortcode that will put the purchase
				options anywhere you place it on the page.
			</div>
		</div>
		<div class="body">
			<div class="postbox">
				<h3><?php echo _e("Link to your information page") ?></h3>
				<div class="inside"> 
					<div class="label">Information landing page</div>
					<input name="tinypass[sub_page]" size="40" value="<?php echo $ps->getSubscriptionPage() ?>" >
					<p class="help">Path of existing page e.g. /signup, /join</p>

					<div class="label"><?php echo _e("Confirmation page after purchase (required)") ?></div>
					<input name="tinypass[sub_page_success]" size="40" value="<?php echo $ps->getSubscriptionPageSuccess() ?>" >
					<p class="help">Path of existing page e.g. /thankyou</p>
					<hr>
					<div class="label"><?php echo _e("Paste this shortcut on your information page to position the Tinypass button") ?></div>
					<input name="" readonly="true" size="40" value='<?php echo "[tinypass rid=\"" . $ps->getResourceId() . "\"]" ?>' >
					<p class="help"></p>
				</div>
			</div>
		</div>
		<div class="clear"></div>
	</div>

<?php } ?>
<?php

/**
 * Display the resource name field
 */
function __tinypass_name_display(TPPaySettings $ps) {

	$name = stripslashes(esc_attr($ps->getResourceName()));

	if (!$name)
		$name = get_bloginfo("name") . " - Premium Content";
	?>
	<div class="tp-section">
		<div class="info">
			<div class="heading">Name your content</div>
			<div class="desc">What are you users buying?</div>
		</div>
		<div class="body">

			<div class="postbox">
				<h3><?php _e('Enter the name'); ?> </h3>
				<div class="inside"> 

					<div class="tp-simple-table">
						<input name="tinypass[resource_name]" size="40" value="<?php echo $name ?>" >
					</div>

				</div>
			</div>
		</div>
		<div class="clear"></div>
	</div>

<?php } ?>
<?php

/**
 * Tag display section
 */
function __tinypass_tag_display(TPPaySettings $ps) {
	?>

	<div class="tp-section">
		<div class="info">
			<div class="heading">Pick your content</div>
			<div class="desc">All tagged posts will automatically be restricted with this paywall.</div>
		</div>
		<div class="body">
			<div class="postbox"> 
				<h3><?php echo _e("Select the tags of the content you want restricted") ?></h3>
				<div class=""> 
					<div class="tag-holder">
						<?php foreach ($ps->getPremiumTagsArray() as $tag): ?>
							<div class="tag">
								<div class="text"><?php echo $tag ?></div>
								<div class="remove"></div>
								<input type="hidden" name="tinypass[tags][]" value="<?php echo $tag ?>">
							</div>
						<?php endforeach; ?>
					</div>
					<div class="clear"></div>
					<div class="tag-entry tp-bg">
						<input type="text" class="premium_tags" autocomplete="off" >
						<a class="add_tag button-secondary"><?php _e('Add') ?></a>
					</div>
				</div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
<?php } ?>
<?php

/**
 * Display pricing options section
 */
function __tinypass_pricing_display(TPPaySettings $ps) {
	?>

	<div class="tp-section">
		<div class="info">
			<div class="heading"><?php _e("Set your price options") ?></div>
			<div class="desc">
				Give access periods of hours, days, weeks, months, unlimited time, or even monthly subscriptions.
				<br> <br>
				Check out our  <a target="_blank" href="http://developer.tinypass.com">documentation</a> for cool stuff like foreign currency, pay-what-you-want, and more.
			</div>
		</div>
		<div class="body">
			<div class="">
				<div class=""> 

					<table class="tinypass_price_options_form">
						<tr>
							<th width="100"><?php _e('Price') ?></th>
							<th width="380"><?php _e('Length of access') ?></th>
							<th width="270"><?php _e('Caption (optional)') ?></th>
						</tr>
					</table>

					<?php echo __tinypass_price_option_display(1, $ps) ?>
					<?php echo __tinypass_price_option_display(2, $ps) ?>
					<?php echo __tinypass_price_option_display(3, $ps) ?>

					<br>
					<div id="pricing_add_more_buttons">
						<strong>
							<a class="add_option_link button-secondary" href="#" onclick="tinypass.addPriceOption();return false;"><?php _e('Add') ?></a>
							<a class="add_option_link button-secondary" href="#" onclick="tinypass.removePriceOption();return false;"><?php _e('Remove') ?></a>
						</strong>
						<br>
					</div>
				</div>
			</div>
		</div>
		<div class="clear"></div>
	</div>

<?php } ?>
<?php

/**
 * 
 */
function __tinypass_ppv_payment_display(TPSiteSettings $ss) {
	?>

	<div class="postbox">
		<h3><?php _e('Add default messaging for posts '); ?> </h3>
		<div class="inside"> 

			<div class="tp-simple-table">

				<div class="label">Enter a header</div>
				<input id="tp_pd_denied_msg1" name="tinypass[pd_denied_msg1]" value="<?php echo esc_attr(stripslashes($ss->getDeniedMessage1())) ?>" size="80" maxlength="80">
				<br>

				<div class="label">Enter a description</div>
				<textarea id="tp_pd_denied_sub1" rows="5" cols="80" name="tinypass[pd_denied_sub1]"><?php echo stripslashes($ss->getDeniedSub1()) ?></textarea>
			</div>

		</div>
	</div>

<?php } ?>
<?php

function __tinypass_custom_rid_display(TPPaySettings $ps) { ?>
	<div class="tp-section" id="">

		<div class="postbox">
			<h3><?php _e('Resource Details - for advanced usage only'); ?> </h3>
			<div class="inside"> 
				<div class="tp_pd_type_panel">

					<div class="tp-simple-table">

						<div class="label"><?php _e('RID') ?></div>
						<input id="tp_pd_denied_msg1" name="tinypass[resource_id]" value="<?php echo esc_attr(stripslashes($ps->getResourceId(""))) ?>" size="50" maxlength="50">

						<p class="">Leave this field empty for default RID value of <b>'wp_post_XXX'</b> where XXX is the current wordpress post ID</p>
						<p class="">Changing RID will cause previous purchases to be 'disconnected'.  Users that have already made a purchase will no longer have access.</p>
						<p class="">RIDs should NOT be modified after purchases have been made!</p>

						<div class="clear"></div>

					</div>
				</div>
			</div>
		</div>

	</div>

<?php } ?>
<?php

function __tinypass_payment_messaging_post_display(TPPaySettings $ps) { ?>

	<div class="tp-section" id="">

		<div class="postbox">
			<h3><?php _e('Customize your messaging'); ?> </h3>
			<div class="inside"> 
				<div class="tp_pd_type_panel">

					<div class="tp-simple-table">

						<div class="label"><?php _e('Header (optional)') ?></div>
						<input id="tp_pd_denied_msg1" name="tinypass[pd_denied_msg1]" value="<?php echo esc_attr(stripslashes($ps->getDeniedMessage1(""))) ?>" size="50" maxlength="50">
						<br>

						<div class="label"><?php _e('Description (optional)') ?></div>
						<textarea id="tp_pd_denied_sub1" rows="3" cols="49" name="tinypass[pd_denied_sub1]"><?php echo stripslashes($ps->getDeniedSub1("")) ?></textarea>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php } ?>
<?php

/**
 * Display payment display options 
 */
function __tinypass_purchase_option_table_display(TPPaySettings $ps) {
	?>

	<div class="tp-section">
		<div class="info">
			<div class="heading"><?php _e("Purchase option table") ?></div>
			<div class="desc">
				This contains the purchase buttons for users on restricted pages.
			</div>
			<div class="image">
				<img src="<?php echo TINYPASS_IMAGE_DIR  ?>/support-table.png">
			</div>
		</div>
		<div class="body">

			<div class="postbox">
				<h3><?php _e('Add some messaging'); ?> </h3>
				<div class="inside"> 
					<div class="">
						<div class="label">Enter a header</div>
						<input id="tp_pd_denied_msg1" name="tinypass[pd_denied_msg1]" value="<?php echo esc_attr(stripslashes($ps->getDeniedMessage1())) ?>" size="60" maxlength="80">
						<br>

						<div class="label">Enter a description</div>
						<textarea id="tp_pd_denied_sub1" rows="3" cols="59" name="tinypass[pd_denied_sub1]"><?php echo stripslashes($ps->getDeniedSub1()) ?></textarea>
					</div>
					<br>
					<div class="">
						<div>
							<input type="checkbox" name="tinypass[pd_order]" value="1" <?php echo checked($ps->isPostFirstInOrder()) ?>>
							<span class="">Always display per post price settings first on restricted pages</span>
						</div>
					</div>
				</div>
			</div>
			<!--
		<div class="postbox">
			<h3><?php _e('Create a custom purchase layout'); ?> </h3>
			<div class="inside"> 
				<div class="">
					Override the default purchase layout by creating a custom template file
					<br> <br>
			<?php echo get_template_directory() ?>/<b><?php echo TINYPASS_PURCHASE_TEMPLATE ?></b>
				</div>
			</div>
		</div>
			-->
		</div>
		<div class="clear"></div>
	</div>

<?php } ?>
<?php

/**
 * Display individual price option
 */
function __tinypass_price_option_display($opt, TPPaySettings $ps, $sub = true, $subWidth = 380) {

	$times = TPSiteSettings::$PERIOD_CHOICES;

	$enabled = 0;

	$default_price = '';
	$default_access_period = '';
	$default_access_period_type = '';

	if ($opt == '1') {
		$default_price = '1';
		$default_access_period = '1';
		$default_access_period_type = 'day';
	}

	$price = $ps->getPrice($opt, $default_price);
	$access_period = $ps->getAccessPeriod($opt, $default_access_period);
	$access_period_type = $ps->getAccessPeriodType($opt, $default_access_period_type);

	$caption = htmlspecialchars(stripslashes($ps->getCaption($opt)));

	$recur = "1 month" == $ps->getRecurring($opt);

	if ($opt == 1 || $ps->hasPriceConfig($opt)) {
		$enabled = 1;
	}

	$display = "display:none";
	if ($opt == '1' || $enabled) {
		$display = "";
	}
	?>
	<table class="tinypass_price_options_form option_form option_form<?php echo $opt ?>" style="<?php echo $display ?>">
		<tr>
			<td width="100">
				<input type="hidden" id="<?php echo "po_en$opt" ?>" name="tinypass[<?php echo "po_en$opt" ?>]" value="<?php echo $enabled ?>">
				<input type="text" size="8" maxlength="10" name="tinypass[<?php echo "po_p$opt" ?>]" value="<?php echo $price ?>">
			</td>
			<td width="<?php echo $subWidth ?>">
				<?php if ($sub): ?>
					<input class="recurring-opts-off" opt="<?php echo $opt ?>" type="radio" value="0" name="tinypass[po_recur<?php echo $opt ?>]" <?php echo checked($recur, false) ?> autocomplete="false">
				<?php endif; ?>
				<input type="text" size="5" maxlength="5" name="tinypass[<?php echo "po_ap$opt" ?>]" value="<?php echo $access_period ?>" class="po_ap_opts<?php echo $opt ?>">
				<?php echo __tinypass_dropdown("tinypass[po_ap_type$opt]", $times, $access_period_type, array('class' => "po_ap_opts$opt")) ?>
				<?php if ($sub): ?>
					<span style="margin-left:30px">&nbsp;</span>
					<input class="recurring-opts-on" id="<?php echo "po_recur$opt" ?>" type="radio" name="tinypass[po_recur<?php echo $opt ?>]" value="1 month" <?php checked($recur) ?> opt="<?php echo $opt ?>">
					<label for="<?php echo "po_recur$opt" ?>"><?php _e("Monthly Subscription") ?></label>
				<?php endif; ?>
			</td>
			<td width="270">
				<input type="text" size="20" maxlength="20" name="tinypass[<?php echo "po_cap$opt" ?>]" value="<?php echo $caption ?>">
			</td>
		</tr>
	</table>
	<?php
}

function tinypass_slider($field_name, $options, $selected_value) {

	$output = "<div class='tp-slider'>";

	foreach ($options as $name => $value) {

		if ($value == $selected_value) {
			$output .= "<div class='choice' val='$value'><div class='choice-selected'>$name</div></div>";
		} else {
			$output .= "<div class='choice' val='$value'><div class=''>$name</div></div>";
		}
	}

	$output .= "<input name='$field_name' type='hidden' value='$selected_value'>";

	$output .= "<div class='clear'></div></div>";

	return $output;
}

function __tinypass_dropdown($name, $values, $selected, $attrs = null) {
	if ($attrs == null)
		$attrs = array();

	$output = "<select name=\"$name\" ";

	foreach ($attrs as $key => $value) {
		$output .= " $key=\"$value\"";
	}

	$output .= ">";

	foreach ($values as $key => $value) {
		$output .= "<option value=\"$key\" " . selected($selected, $key, false) . ">$value</option>";
	}

	$output .= "</select>";

	return $output;
}
?>