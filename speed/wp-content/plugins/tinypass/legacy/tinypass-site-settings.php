<?php
/**
 * This file perform the saving and dispalying of TinyPass settings on the 
 * TinyPass->Settings menu
 */

function tinypass_site_settings() {

	$storage = new TPStorage();

	if (isset($_POST['_Submit'])) {
		$ss = $storage->getSiteSettings();
		$ss->clear(array(TPSiteSettings::PPP_ENABLED, TPSiteSettings::DISABLE_COMMENTS_WHEN_DENIED));
		$ss->mergeValues($_POST['tinypass']);
		$storage->saveSiteSettings($ss);
	}

	$ss = $storage->getSiteSettings();
	?>
	<div id="poststuff" class="metabox-holder has-right-sidebar">
		<?php if (!empty($_POST['_Submit'])) : ?>
			<div id="message" class="updated fade"><p><strong><?php _e('Options saved.') ?></strong></p></div>
		<?php endif; ?>

		<div class="">
			<form action="" method="post" id="tinypass-conf">

				<?php __tinypass_section_head_alt(__("General settings")) ?>
				<br>
				<div class="tp-section">
					<div class="info">
						<div class="desc">Customize the Tinypass experience by changing these additional options</div>
					</div>
					<div class="body">

						<div class="postbox">
							<h3><?php _e('Options') ?> </h3>
							<div class="inside">
								<input type="checkbox" name="tinypass[ppv]" <?php echo checked($ss->isPPPEnabled()) ?>><label>&nbsp;<?php _e('Enable Tinypass for individual posts '); ?></label>
								<br>
								<input type="checkbox" name="tinypass[dc]" <?php echo checked($ss->isDisableCommentsWhenDenied()) ?>><label>&nbsp;<?php _e('Disable post comments when access is denied'); ?></label>
							</div>
						</div>
						<?php __tinypass_ppv_payment_display($ss) ?>

					</div>
					<?php __tinypass_section_head_alt(__("Plugin settings")) ?>
					<br>
				</div>

				<div class="tp-section">
					<div class="info">
						<div class="heading">Environment</div>
						<div class="desc"></div>
					</div>
					<div class="body">
						<div class="postbox">
							<h3><?php _e('Environment') ?> </h3>
							<div class="inside">
								<input type="radio" name="tinypass[env]" value="0" <?php echo checked($ss->isSand(), true) ?>><label><?php _e('Sandbox - for testing only'); ?></label><br>
								<input type="radio" name="tinypass[env]" value="1" <?php echo checked($ss->isProd(), true) ?>><label><?php _e('Live - for live payments'); ?></label>
							</div>
						</div>
					</div>
				</div>

				<div class="tp-section">
					<div class="info">
						<div class="heading">Application IDs and Keys</div>
					</div>
					<div class="body">


						<div class="postbox">
							<h3><?php _e('Application IDs and Keys'); ?> </h3>
							<div class="inside">

								<table class="form-table">

									<tr valign="top">
										<th scope="row"><?php _e('Application ID (Sandbox)'); ?></th>
										<td>
											<input id="aid_sand" name="tinypass[aid_sand]" type="text" size="10" maxlength="10" value="<?php echo $ss->getAIDSand() ?>"/><br>
											<span class="description">The Application ID (sandbox) can be retrieved from your account at <a target="_blank" href="http://sandbox.tinypass.com/member/merch">http://sandbox.tinypass.com</a></span>
										</td>
									</tr>

									<tr valign="top">
										<th scope="row"><?php _e('Application Secret Key (Sandbox)'); ?></th>
										<td>
											<input id="secret_key_sand" name="tinypass[secret_key_sand]" type="text" size="40" maxlength="40" value="<?php echo $ss->getSecretKeySand() ?>" style="" /><br>
											<span class="description">The Secret Key (sandbox) can be retrieved from your account at <a target="_blank" href="http://sandbox.tinypass.com/member/merch">http://sandbox.tinypass.com</a></span><br>
										</td>
									</tr>
									<tr valign="top">
										<th scope="row"><?php _e('Application ID (Live)'); ?></th>
										<td>
											<input id="aid_prod" name="tinypass[aid_prod]" type="text" size="10" maxlength="10" value="<?php echo $ss->getAIDProd() ?>"/><br>
											<span class="description">The Application ID (Live) can be retrieved from your account at <a target="_blank" href="http://dashboard.tinypass.com/member/merch">http://www.tinypass.com</a></span>
										</td>
									</tr>

									<tr valign="top">
										<th scope="row"><?php _e('Application Secret Key (Live)'); ?></th>
										<td>
											<input id="secret_key_prod" name="tinypass[secret_key_prod]" type="text" size="40" maxlength="40" value="<?php echo $ss->getSecretKeyProd() ?>" style="" /><br>
											<span class="description">The Secret Key (Live) can be retrieved from your account at <a target="_blank" href="http://dashboard.tinypass.com/member/merch">http://www.tinypass.com</a></span>
										</td>
									</tr>

								</table>
							</div>
						</div>
					</div>
					<div class="clear"></div>
				</div>

				<p>
					<input type="submit" name="_Submit" id="publish" value="Save Changes" tabindex="4" class="button-primary" />
				</p>

			</form>
		</div>
	</div>
<?php } ?>