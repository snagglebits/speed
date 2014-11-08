<?php
if(!defined('ABSPATH'))	exit;

new Math_Captcha_Settings();

class Math_Captcha_Settings
{
	public $mathematical_operations;
	public $groups;
	public $forms;


	/**
	 *
	*/
	public function __construct()
	{
		// actions
		add_action('init', array(&$this, 'load_defaults'));
		add_action('admin_init', array(&$this, 'register_settings'));
		add_action('admin_menu', array(&$this, 'admin_menu_options'));
	}


	/**
	 *
	*/
	public function load_defaults()
	{
		if(!is_admin())
			return;

		$this->forms = array(
			'login_form' => __('login form', 'math-captcha'),
			'registration_form' => __('registration form', 'math-captcha'),
			'reset_password_form' => __('reset password form', 'math-captcha'),
			'comment_form' => __('comment form', 'math-captcha'),
			'bbpress' => __('bbpress', 'math-captcha'),
			'contact_form_7' => __('contact form 7', 'math-captcha')
		);

		$this->mathematical_operations = array(
			'addition' => __('addition (+)', 'math-captcha'),
			'subtraction' => __('subtraction (-)', 'math-captcha'),
			'multiplication' => __('multiplication (&#215;)', 'math-captcha'),
			'division' => __('division (&#247;)', 'math-captcha')
		);

		$this->groups = array(
			'numbers' => __('numbers', 'math-captcha'),
			'words' => __('words', 'math-captcha')
		);
	}


	/**
	 * Adds options menu
	*/
	public function admin_menu_options()
	{
		add_options_page(
			__('Math Captcha', 'math-captcha'),
			__('Math Captcha', 'math-captcha'),
			'manage_options',
			'math-captcha',
			array(&$this, 'options_page')
		);
	}


	/**
	 * Shows options page
	*/
	public function options_page()
	{
		echo '
		<div class="wrap">
			<h2>'.__('Math Captcha', 'math-captcha').'</h2>
			<div class="math-captcha-settings">
				<div class="df-credits">
					<h3 class="hndle">'.__('Math Captcha', 'math-captcha').' '.Math_Captcha()->defaults['version'].'</h3>
					<div class="inside">
						<h4 class="inner">'.__('Need support?', 'math-captcha').'</h4>
						<p class="inner">'.__('If you are having problems with this plugin, please talk about them in the', 'math-captcha').' <a href="http://www.dfactory.eu/support/?utm_source=math-captcha-settings&utm_medium=link&utm_campaign=support" target="_blank" title="'.__('Support forum','math-captcha').'">'.__('Support forum', 'math-captcha').'</a></p>
						<hr/>
						<h4 class="inner">'.__('Do you like this plugin?', 'math-captcha').'</h4>
						<p class="inner"><a href="http://wordpress.org/support/view/plugin-reviews/wp-math-captcha" target="_blank" title="'.__('Rate it 5', 'math-captcha').'">'.__('Rate it 5', 'math-captcha').'</a> '.__('on WordPress.org', 'math-captcha').'<br/>'.
						__('Blog about it & link to the', 'math-captcha').' <a href="http://www.dfactory.eu/plugins/math-captcha/?utm_source=math-captcha-settings&utm_medium=link&utm_campaign=blog-about" target="_blank" title="'.__('plugin page', 'math-captcha').'">'.__('plugin page', 'math-captcha').'</a><br/>'.
						__('Check out our other', 'math-captcha').' <a href="http://www.dfactory.eu/plugins/?utm_source=math-captcha-settings&utm_medium=link&utm_campaign=other-plugins" target="_blank" title="'.__('WordPress plugins', 'math-captcha').'">'.__('WordPress plugins', 'math-captcha').'</a>
						</p>
						<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank" class="inner">
							<input type="hidden" name="cmd" value="_s-xclick">
							<input type="hidden" name="hosted_button_id" value="BJSHR9GS5QJTC">
							<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
							<img alt="" border="0" src="https://www.paypalobjects.com/pl_PL/i/scr/pixel.gif" width="1" height="1">
						</form>
						<hr/>
						<p class="df-link inner">Created by <a href="http://www.dfactory.eu/?utm_source=math-captcha-settings&utm_medium=link&utm_campaign=created-by" target="_blank" title="dFactory - Quality plugins for WordPress"><img src="'.DOWNLOAD_ATTACHMENTS_URL.'/images/logo-dfactory.png" title="dFactory - Quality plugins for WordPress" alt="dFactory - Quality plugins for WordPress"/></a></p>
					</div>
				</div>
				<form action="options.php" method="post">';

		wp_nonce_field('update-options');
		settings_fields('math_captcha_options');
		do_settings_sections('math_captcha_options');

		echo '
					<p class="submit">';

		submit_button('', 'primary', 'save_mc_general', false);

		echo ' ';

		submit_button(__('Reset to defaults', 'math-captcha'), 'secondary reset_mc_settings', 'reset_mc_general', false);

		echo '
					</p>
				</form>
			</div>
			<div class="clear"></div>
		</div>';
	}


	/**
	 * 
	*/
	public function register_settings()
	{
		// general settings
		register_setting('math_captcha_options', 'math_captcha_options', array(&$this, 'validate_settings'));
		add_settings_section('math_captcha_settings', __('Math Captcha settings', 'math-captcha'), '', 'math_captcha_options');
		add_settings_field('mc_general_enable_captcha_for', __('Enable Math Captcha for', 'math-captcha'), array(&$this, 'mc_general_enable_captcha_for'), 'math_captcha_options', 'math_captcha_settings');
		add_settings_field('mc_general_hide_for_logged_users', __('Hide for logged in users', 'math-captcha'), array(&$this, 'mc_general_hide_for_logged_users'), 'math_captcha_options', 'math_captcha_settings');
		add_settings_field('mc_general_mathematical_operations', __('Mathematical operations', 'math-captcha'), array(&$this, 'mc_general_mathematical_operations'), 'math_captcha_options', 'math_captcha_settings');
		add_settings_field('mc_general_groups', __('Display captcha as', 'math-captcha'), array(&$this, 'mc_general_groups'), 'math_captcha_options', 'math_captcha_settings');
		add_settings_field('mc_general_title', __('Captcha field title', 'math-captcha'), array(&$this, 'mc_general_title'), 'math_captcha_options', 'math_captcha_settings');
		add_settings_field('mc_general_time', __('Captcha time', 'math-captcha'), array(&$this, 'mc_general_time'), 'math_captcha_options', 'math_captcha_settings');
		add_settings_field('mc_general_block_direct_comments', __('Block Direct Comments', 'math-captcha'), array(&$this, 'mc_general_block_direct_comments'), 'math_captcha_options', 'math_captcha_settings');
		add_settings_field('mc_general_deactivation_delete', __('Deactivation', 'math-captcha'), array(&$this, 'mc_general_deactivation_delete'), 'math_captcha_options', 'math_captcha_settings');
	}


	/**
	 *
	*/
	public function mc_general_enable_captcha_for()
	{
		echo '
		<div id="mc_general_enable_captcha_for">
			<fieldset>';

		foreach($this->forms as $val => $trans)
		{
			echo '
				<input id="mc-general-enable-captcha-for-'.$val.'" type="checkbox" name="math_captcha_options[enable_for][]" value="'.$val.'" '.checked(true, Math_Captcha()->options['general']['enable_for'][$val], false).' '.disabled((($val === 'contact_form_7' && !class_exists('WPCF7_ContactForm')) || ($val === 'bbpress' && !class_exists('bbPress'))), true, false).'/><label for="mc-general-enable-captcha-for-'.$val.'">'.esc_html($trans).'</label>';
		}

		echo '
				<br/>
				<span class="description">'.__('Select where you\'d like to use Math Captcha.', 'math-captcha').'</span>
			</fieldset>
		</div>';
	}


	/**
	 *
	*/
	public function mc_general_hide_for_logged_users()
	{
		echo '
		<div id="mc_general_hide_for_logged_users">
			<fieldset>
				<input id="mc-general-hide-for-logged" type="checkbox" name="math_captcha_options[hide_for_logged_users]" '.checked(true, Math_Captcha()->options['general']['hide_for_logged_users'], false).'/><label for="mc-general-hide-for-logged">'.__('Enable to hide captcha for logged in users.', 'math-captcha').'</label>
				<br/>
				<span class="description">'.__('Would you like to hide captcha for logged in users?', 'math-captcha').'</span>
			</fieldset>
		</div>';
	}


	/**
	 *
	*/
	public function mc_general_mathematical_operations()
	{
		echo '
		<div id="mc_general_mathematical_operations">
			<fieldset>';

		foreach($this->mathematical_operations as $val => $trans)
		{
			echo '
				<input id="mc-general-mathematical-operations-'.$val.'" type="checkbox" name="math_captcha_options[mathematical_operations][]" value="'.$val.'" '.checked(true, Math_Captcha()->options['general']['mathematical_operations'][$val], false).'/><label for="mc-general-mathematical-operations-'.$val.'">'.esc_html($trans).'</label>';
		}

		echo '
				<br/>
				<span class="description">'.__('Select which mathematical operations to use in your captcha.', 'math-captcha').'</span>
			</fieldset>
		</div>';
	}


	/**
	 *
	*/
	public function mc_general_groups()
	{
		echo '
		<div id="mc_general_groups">
			<fieldset>';

		foreach($this->groups as $val => $trans)
		{
			echo '
				<input id="mc-general-groups-'.$val.'" type="checkbox" name="math_captcha_options[groups][]" value="'.$val.'" '.checked(true, Math_Captcha()->options['general']['groups'][$val], false).'/><label for="mc-general-groups-'.$val.'">'.esc_html($trans).'</label>';
		}

		echo '
				<br/>
				<span class="description">'.__('Select how you\'d like to display you captcha.', 'math-captcha').'</span>
			</fieldset>
		</div>';
	}


	/**
	 *
	*/
	public function mc_general_title()
	{
		echo '
		<div id="mc_general_title">
			<fieldset>
				<input type="text" name="math_captcha_options[title]" value="'.Math_Captcha()->options['general']['title'].'"/>
				<br/>
				<span class="description">'.__('How to entitle field with captcha?', 'math-captcha').'</span>
			</fieldset>
		</div>';
	}


	/**
	 *
	*/
	public function mc_general_time()
	{
		echo '
		<div id="mc_general_time">
			<fieldset>
				<input type="text" name="math_captcha_options[time]" value="'.Math_Captcha()->options['general']['time'].'"/>
				<br/>
				<span class="description">'.__('Enter the time (in seconds) a user has to enter captcha value.', 'math-captcha').'</span>
			</fieldset>
		</div>';
	}


	/**
	 *
	*/
	public function mc_general_block_direct_comments()
	{
		echo '
		<div id="mc_general_block_direct_comments">
			<fieldset>
				<input id="mc-general-block-direct-comments" type="checkbox" name="math_captcha_options[block_direct_comments]" '.checked(true, Math_Captcha()->options['general']['block_direct_comments'], false).'/><label for="mc-general-block-direct-comments">'.__('Blocks direct access to wp-comments-post.php. Enable this to prevent spambots from posting to Wordpress via a URL.', 'math-captcha').'</label>
				<br/>
				<span class="description">'.__('Blocks direct access to wp-comments-post.php. Enable this to prevent spambots from posting to Wordpress via a URL.', 'math-captcha').'</span>
			</fieldset>
		</div>';
	}


	/**
	 *
	*/
	public function mc_general_deactivation_delete()
	{
		echo '
		<div id="mc_general_deactivation_delete">
			<fieldset>
				<input id="mc-general-deactivation-delete" type="checkbox" name="math_captcha_options[deactivation_delete]" '.checked(true, Math_Captcha()->options['general']['deactivation_delete'], false).'/><label for="mc-general-deactivation-delete">'.__('Delete settings on plugin deactivation.', 'math-captcha').'</label>
				<br/>
				<span class="description">'.__('Delete settings on plugin deactivation', 'math-captcha').'</span>
			</fieldset>
		</div>';
	}


	/**
	 * Validates settings
	*/
	public function validate_settings($input)
	{
		if(isset($_POST['save_mc_general']))
		{
			// enable captcha forms
			$enable_for = array();

			if(empty($input['enable_for']))
			{
				foreach(Math_Captcha()->defaults['general']['enable_for'] as $enable => $bool)
				{
					$input['enable_for'][$enable] = false;
				}
			}
			else
			{
				foreach($this->forms as $enable => $trans)
				{
					$enable_for[$enable] = (in_array($enable, $input['enable_for']) ? true : false);
				}

				$input['enable_for'] = $enable_for;
			}

			if(!class_exists('WPCF7_ContactForm') && Math_Captcha()->options['general']['enable_for']['contact_form_7'])
				$input['enable_for']['contact_form_7'] = true;

			if(!class_exists('bbPress') && Math_Captcha()->options['general']['enable_for']['bbpress'])
				$input['enable_for']['bbpress'] = true;

			// enable mathematical operations
			$mathematical_operations = array();

			if(empty($input['mathematical_operations']))
			{
				add_settings_error('empty-operations', 'settings_updated', __('You need to check at least one mathematical operation. Defaults settings of this option restored.', 'math-captcha'), 'error');

				$input['mathematical_operations'] = Math_Captcha()->defaults['general']['mathematical_operations'];
			}
			else
			{
				foreach($this->mathematical_operations as $operation => $trans)
				{
					$mathematical_operations[$operation] = (in_array($operation, $input['mathematical_operations']) ? true : false);
				}

				$input['mathematical_operations'] = $mathematical_operations;
			}

			// enable groups
			$groups = array();

			if(empty($input['groups']))
			{
				add_settings_error('empty-groups', 'settings_updated', __('You need to check at least one group. Defaults settings of this option restored.', 'math-captcha'), 'error');

				$input['groups'] = Math_Captcha()->defaults['general']['groups'];
			}
			else
			{
				foreach($this->groups as $group => $trans)
				{
					$groups[$group] = (in_array($group, $input['groups']) ? true : false);
				}

				$input['groups'] = $groups;
			}

			// hide for logged in users
			$input['hide_for_logged_users'] = isset($input['hide_for_logged_users']);

			// block direct comments access
			$input['block_direct_comments'] = isset($input['block_direct_comments']);

			// deactivation delete
			$input['deactivation_delete'] = isset($input['deactivation_delete']);

			// captcha title
			$input['title'] = trim($input['title']);

			// captcha time
			$time = (int)$input['time'];
			$input['time'] = ($time < 0 ? Math_Captcha()->defaults['general']['time'] : $time);

			// flush rules
			$input['flush_rules'] = true;
		}
		elseif(isset($_POST['reset_mc_general']))
		{
			$input = Math_Captcha()->defaults['general'];

			add_settings_error('settings', 'settings_reset', __('Settings restored to defaults.', 'math-captcha'), 'updated');
		}

		return $input;
	}
}
?>