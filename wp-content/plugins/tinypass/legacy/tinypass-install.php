<?php

/**
 * Activate Tinypass plugin.  Will perform upgrades and check compatibility
 */
function tinypass_activate() {

	$error = '';
	if (!extension_loaded('mbstring'))
		$error .= "&nbsp;&nbsp;&nbsp;<a href=\"http://php.net/manual/en/ref.mbstring.php\">mbstring php module</a> is required for Tinypass<br>";
	if (!extension_loaded('mcrypt'))
		$error .= "&nbsp;&nbsp;&nbsp;<a href=\"http://php.net/manual/en/book.mcrypt.php\">mcrypt php module</a> is required for Tinypass<br>";

	if (version_compare(PHP_VERSION, '5.2.0') < 0) {
		$error .= "&nbsp;&nbsp;&nbsp;Requires PHP 5.2+";
	}

	if ($error)
		die('Tinypass could not be enabled<br>' . $error);

	$old = get_option("tinypass_setting");
	if ($old && count($old)) {
		$message = "Upgrading from Tinypass version 1.x to 2.x is considered a significant upgrade.<br>";
		$message .= "<br>Please contact support@tinypass.com if you are having migration issues or questions";
		$message .= "<br><br>You can restore your previous version by manually downloading latest 1.4.x plugin at http://wordpress.org/extend/plugins/tinypass/developers";
		$message .= "<br><br>You can manually upgrade by uninstalling the Tinypass plugin and then performing a brand new install.  All your existing settings will be lost!!";
		die($message);
	}

	tinypass_upgrades();

	$data = get_plugin_data(TINYPASS_PLUGIN_FILE_PATH);
	$version = $data['Version'];
	update_option('tinypass_version', $version);
}

function tinypass_upgrades() {

	tinypass_include();

	$current = get_option('tinypass_version');
	if ($current < '2.1.0') {
		$storage = new TPStorage();
		$ss = $storage->getSiteSettings();

		//update the old wp_bundle1
		$pw = $storage->findPaywall('wp_bundle1');
		if ($pw != null) {

			$pw->setEnabled(true);
			if ($pw->getMode() == 0) {
				$pw->setEnabled(false);
			}
			$storage->savePaywallSettings($ss, $pw);
		}

		update_option('tinypass_version', '2.1.0');
	}

	if($current < '3.0.0') {

		//mark this as legacy
		update_option('tinypass_legacy', 1);
		
		update_option('tinypass_version', '3.0.0');

	}

}

function tinypass_deactivate() {
	
}

function tinypass_uninstall() {
	tinypass_include();
	delete_option('tinypass_legacy');
	$storage = new TPStorage();
	$storage->deleteAll();
}

?>