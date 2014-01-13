<?php
/*
Plugin Name: Math Captcha
Description: Math Captcha is a <strong>100% effective CAPTCHA for WordPress</strong> that integrates into login, registration, comments, Contact Form 7 and bbPress.
Version: 1.0.9
Author: dFactory
Author URI: http://www.dfactory.eu/
Plugin URI: http://www.dfactory.eu/plugins/math-captcha/
License: MIT License
License URI: http://opensource.org/licenses/MIT

Math Captcha
Copyright (C) 2013, Digital Factory - info@digitalfactory.pl

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/

if(!defined('ABSPATH'))	exit; //exit if accessed directly

new Math_Captcha();

class Math_Captcha
{
	private $defaults = array(
		'general' => array(
			'enable_for' => array(
				'login_form' => FALSE,
				'registration_form' => TRUE,
				'reset_password_form' => TRUE,
				'comment_form' => TRUE,
				'bbpress' => FALSE,
				'contact_form_7' => FALSE
			),
			'hide_for_logged_users' => TRUE,
			'title' => 'Math Captcha',
			'mathematical_operations' => array(
				'addition' => TRUE,
				'subtraction' => TRUE,
				'multiplication' => FALSE,
				'division' => FALSE
			),
			'groups' => array(
				'numbers' => TRUE,
				'words' => FALSE
			),
			'time' => 300,
			'deactivation_delete' => FALSE
		),
		'version' => '1.0.9'
	);
	private $session_ids = array();
	private $session_number = 0;
	private $options = array();
	private $choices = array();
	private $enable_for = array();
	private $mathematical_operations = array();
	private $groups = array();
	private $error_messages = array();
	private $errors;


	public function __construct()
	{
		register_activation_hook(__FILE__, array(&$this, 'activation'));
		register_deactivation_hook(__FILE__, array(&$this, 'deactivation'));

		//changes from older versions
		$db_version = get_option('math_captcha_version');

		if(version_compare(($db_version === FALSE ? '1.0.0' : $db_version), '1.0.9', '<'))
		{
			if(($array = get_option('mc_options')) !== FALSE)
			{
				update_option('math_captcha_options', $array);
				delete_option('mc_options');
			}
		}

		$this->options['general'] = array_merge($this->defaults['general'], (($array = get_option('math_captcha_options')) === FALSE ? array() : $array));

		//actions
		add_action('plugins_loaded', array(&$this, 'init_mc_session'), 1);
		add_action('plugins_loaded', array(&$this, 'load_textdomain'));
		add_action('plugins_loaded', array(&$this, 'load_defaults'));
		add_action('init', array(&$this, 'load_actions_filters'), 1);
		add_action('admin_init', array(&$this, 'register_settings'));
		add_action('admin_menu', array(&$this, 'admin_menu_options'));
		add_action('admin_enqueue_scripts', array(&$this, 'admin_comments_scripts_styles'));

		//filters
		add_filter('plugin_action_links', array(&$this, 'plugin_settings_link'), 10, 2);
		add_filter('plugin_row_meta', array(&$this, 'plugin_extend_links'), 10, 2);
		add_filter('shake_error_codes', array(&$this, 'add_shake_error_codes'), 1);
	}


	/**
	 * Activation
	*/
	public function activation()
	{
		add_option('math_captcha_options', $this->defaults['general'], '', 'no');
		update_option('math_captcha_version', $this->defaults['version'], '', 'no');
	}


	/**
	 * Deactivation
	*/
	public function deactivation()
	{
		if($this->options['general']['deactivation_delete'] === TRUE)
		{
			delete_option('math_captcha_options');
			delete_option('math_captcha_version');
		}
	}


	/**
	 * Gets error messages
	*/
	public function get_error_messages($error)
	{
		return $this->error_messages[$error];
	}


	/**
	 * Gets options
	*/
	public function get_options($option)
	{
		return $this->options['general'][$option];
	}


	/**
	 * Gets session's ID
	*/
	public function get_session_id($number = 0)
	{
		return $this->session_ids['multi'][$number];
	}


	/**
	 * Gets session's number for Contact Form 7 multi instances
	*/
	public function get_session_number()
	{
		return $this->session_number;
	}


	/**
	 * Loads required filters
	*/
	public function load_actions_filters()
	{
		global $pagenow;

		//comments
		if($this->options['general']['enable_for']['comment_form'] === TRUE)
		{
			if(!is_user_logged_in())
				add_action('comment_form_after_fields', array(&$this, 'add_captcha_form'));
			else
			{
				if($this->options['general']['hide_for_logged_users'] === FALSE)
				{
					add_action('comment_form_logged_in_after', array(&$this, 'add_captcha_form'));
				}
			}

			add_filter('preprocess_comment', array(&$this, 'add_comment_with_captcha'));
		}

		//login, register, lost-password
		if($pagenow === 'wp-login.php')
		{
			$action = (isset($_GET['action']) && $_GET['action'] !== '' ? $_GET['action'] : NULL);

			if($this->options['general']['enable_for']['registration_form'] === TRUE && (!is_user_logged_in() || (is_user_logged_in() && $this->options['general']['hide_for_logged_users'] === FALSE)) && $action === 'register')
			{
				add_action('register_form', array(&$this, 'add_captcha_form'));
				add_action('register_post', array(&$this, 'add_user_with_captcha'), 10, 3);
				add_action('signup_extra_fields', array(&$this, 'add_captcha_form'));
				add_filter('wpmu_validate_user_signup', array(&$this, 'validate_user_with_captcha'));
			}

			if($this->options['general']['enable_for']['reset_password_form'] === TRUE && (!is_user_logged_in() || (is_user_logged_in() && $this->options['general']['hide_for_logged_users'] === FALSE)) && $action === 'lostpassword')
			{
				add_action('lostpassword_form', array(&$this, 'add_captcha_form'));
				add_action('lostpassword_post', array(&$this, 'check_lost_password_with_captcha'));
			}

			if($this->options['general']['enable_for']['login_form'] === TRUE && (!is_user_logged_in() || (is_user_logged_in() && $this->options['general']['hide_for_logged_users'] === FALSE)) && $action === NULL)
			{
				add_action('login_form', array(&$this, 'add_captcha_form'));
				add_filter('login_redirect', array(&$this, 'redirect_login_with_captcha'), 10, 3);
			}
		}

		//bbPress
		if($this->options['general']['enable_for']['bbpress'] === TRUE)
		{
			include_once(ABSPATH.'wp-admin/includes/plugin.php');

			if(is_plugin_active('bbpress/bbpress.php') && (!is_user_logged_in() || (is_user_logged_in() && $this->options['general']['hide_for_logged_users'] === FALSE)))
			{
				add_action('bbp_theme_after_reply_form_content', array(&$this, 'add_bbp_captcha_form'));
				add_action('bbp_theme_after_topic_form_content', array(&$this, 'add_bbp_captcha_form'));
				add_action('bbp_new_reply_pre_extras', array(&$this, 'check_bbpress_captcha'));
				add_action('bbp_new_topic_pre_extras', array(&$this, 'check_bbpress_captcha'));
			}
		}

		//Contact Form 7
		if($this->options['general']['enable_for']['contact_form_7'] === TRUE)
		{
			include_once(ABSPATH.'wp-admin/includes/plugin.php');

			if(is_plugin_active('contact-form-7/wp-contact-form-7.php'))
			{
				global $mc_class;
				$mc_class = $this;

				include_once('includes/math-captcha-cf7.php');
			}
		}
	}


	/**
	 * Validates lost password form
	*/
	public function check_lost_password_with_captcha()
	{
		$this->errors = new WP_Error();
		$user_error = FALSE;
		$user_data = NULL;

		//checks captcha
		if(isset($_POST['mc-value']) && $_POST['mc-value'] !== '')
		{
			if($this->session_ids['default'] !== '' && get_transient('mc_'.$this->session_ids['default']) !== FALSE)
			{
				if(strcmp(get_transient('mc_'.$this->session_ids['default']), sha1(AUTH_KEY.$_POST['mc-value'].$this->session_ids['default'], FALSE)) !== 0)
					$this->errors->add('math-captcha-error', $this->error_messages['wrong']);
			}
			else
				$this->errors->add('math-captcha-error', $this->error_messages['time']);
		}
		else
			$this->errors->add('math-captcha-error', $this->error_messages['fill']);

		//checks user_login (from wp-login.php)
		if(empty($_POST['user_login']))
			$user_error = TRUE;
		elseif(strpos($_POST['user_login'], '@'))
		{
			$user_data = get_user_by('email', trim($_POST['user_login']));

			if(empty($user_data))
				$user_error = TRUE;
		}
		else
			$user_data = get_user_by('login', trim($_POST['user_login']));

		if(!$user_data)
			$user_error = TRUE;

		//something went wrong?
		if(!empty($this->errors->errors))
		{
			//nasty hack (captcha is wrong but user_login is ok)
			if($user_error === FALSE)
				add_filter('allow_password_reset', array(&$this, 'add_lostpassword_wp_message'));
			else
				add_filter('login_errors', array(&$this, 'add_lostpassword_captcha_message'));
		}
	}


	/**
	 * Adds lost password errors
	*/
	public function add_lostpassword_captcha_message($errors)
	{
		return $errors.$this->errors->errors['math-captcha-error'][0];
	}


	/**
	 * Adds lost password errors (special way)
	*/
	public function add_lostpassword_wp_message()
	{
		return $this->errors;
	}


	/**
	 * Validates register form
	*/
	public function add_user_with_captcha($login, $email, $errors)
	{
		if(isset($_POST['mc-value']) && $_POST['mc-value'] !== '')
		{
			if($this->session_ids['default'] !== '' && get_transient('mc_'.$this->session_ids['default']) !== FALSE)
			{
				if(strcmp(get_transient('mc_'.$this->session_ids['default']), sha1(AUTH_KEY.$_POST['mc-value'].$this->session_ids['default'], FALSE)) !== 0)
					$errors->add('math-captcha-error', $this->error_messages['wrong']);
			}
			else
				$errors->add('math-captcha-error', $this->error_messages['time']);
		}
		else
			$errors->add('math-captcha-error', $this->error_messages['fill']);

		return $errors;
	}


	/**
	 * Validates register form
	*/
	public function validate_user_with_captcha($result)
	{
		if(isset($_POST['mc-value']) && $_POST['mc-value'] !== '')
		{
			if($this->session_ids['default'] !== '' && get_transient('mc_'.$this->session_ids['default']) !== FALSE)
			{
				if(strcmp(get_transient('mc_'.$this->session_ids['default']), sha1(AUTH_KEY.$_POST['mc-value'].$this->session_ids['default'], FALSE)) !== 0)
					$results['errors']->add('math-captcha-error', $this->error_messages['wrong']);
			}
			else
				$results['errors']->add('math-captcha-error', $this->error_messages['time']);
		}
		else
			$results['errors']->add('math-captcha-error', $this->error_messages['fill']);

		return $results;
	}


	/**
	 * Posts login form
	*/
	public function redirect_login_with_captcha($redirect, $bool, $errors)
	{
		$error = FALSE;
		$act = '';

		if(isset($_GET['captcha']) && in_array($_GET['captcha'], array('fill', 'wrong', 'time'), TRUE))
		{
			$errors->add('math-captcha-error', $this->error_messages[$_GET['captcha']]);
		}

		if(!empty($_POST))
		{
			if(isset($_POST['mc-value']) && $_POST['mc-value'] !== '')
			{
				if($this->session_ids['default'] !== '' && get_transient('mc_'.$this->session_ids['default']) !== FALSE)
				{
					if(strcmp(get_transient('mc_'.$this->session_ids['default']), sha1(AUTH_KEY.$_POST['mc-value'].$this->session_ids['default'], FALSE)) !== 0)
					{
						$error = (!is_wp_error($errors) ? TRUE : $errors->add('math-captcha-error', $this->error_messages['wrong']));
						$act = 'wrong';
					}
				}
				else
				{
					$error = (!is_wp_error($errors) ? TRUE : $errors->add('math-captcha-error', $this->error_messages['time']));
					$act = 'time';
				}
			}
			else
			{
				$error = (!is_wp_error($errors) ? TRUE : $errors->add('math-captcha-error', $this->error_messages['fill']));
				$act = 'fill';
			}
		}

		if($error === FALSE || isset($_GET['captcha']))
			return $redirect;
		else
		{
			wp_clear_auth_cookie();
			return site_url('/wp-login.php'.($act !== '' ? '?captcha='.$act : ''));
		}
	}


	/**
	 * Adds shake
	*/
	public function add_shake_error_codes($codes)
	{
		$codes[] = 'math-captcha-error';

		return $codes;
	}


	/**
	 * Adds captcha to comment form
	*/
	public function add_comment_with_captcha($comment)
	{
		if(isset($_POST['mc-value']) && (!is_admin() || DOING_AJAX) && ($comment['comment_type'] === '' || $comment['comment_type'] === 'comment'))
		{
			if($_POST['mc-value'] !== '')
			{
				if($this->session_ids['default'] !== '' && get_transient('mc_'.$this->session_ids['default']) !== FALSE)
				{
					if(strcmp(get_transient('mc_'.$this->session_ids['default']), sha1(AUTH_KEY.$_POST['mc-value'].$this->session_ids['default'], FALSE)) === 0)
						return $comment;
					else
						wp_die($this->error_messages['wrong']);
				}
				else
					wp_die($this->error_messages['time']);
			}
			else
				wp_die($this->error_messages['fill']);
		}
		else
			return $comment;
	}


	/**
	 * Initializes cookie-session
	*/
	public function init_mc_session()
	{
		if(isset($_COOKIE['mc_session_ids']))
			$this->session_ids = $_COOKIE['mc_session_ids'];
		else
		{
			foreach(array('default', 'multi') as $place)
			{
				switch($place)
				{
					case 'multi':
						for($i = 0; $i < 5; $i++)
						{
							$this->session_ids[$place][$i] = sha1(wp_generate_password(64, FALSE, FALSE));
						}
						break;

					case 'default':
						$this->session_ids[$place] = sha1(wp_generate_password(64, FALSE, FALSE));
						break;
				}
			}
		}

		setcookie('mc_session_ids[default]', $this->session_ids['default'], current_time('timestamp', TRUE) + apply_filters('math_captcha_time', $this->options['general']['time']), COOKIEPATH, COOKIE_DOMAIN);

		for($i = 0; $i < 5; $i++)
		{
			setcookie('mc_session_ids[multi]['.$i.']', $this->session_ids['multi'][$i], current_time('timestamp', TRUE) + apply_filters('math_captcha_time', $this->options['general']['time']), COOKIEPATH, COOKIE_DOMAIN);
		}
	}


	/**
	 * Shows and generates captcha
	*/
	public function add_captcha_form()
	{
		if(is_admin())
			return;

		$captcha_title = apply_filters('math_captcha_title', $this->options['general']['title']);

		echo '
		<p class="math-captcha-form">';

		if(!empty($captcha_title))
			echo '
			<label>'.$captcha_title.'<br /></label>';

		echo '
			<span>'.$this->generate_captcha_phrase('default').'</span>
		</p>';
	}


	/**
	 * Shows and generates captcha for bbPress
	*/
	public function add_bbp_captcha_form()
	{
		if(is_admin())
			return;

		$captcha_title = apply_filters('math_captcha_title', $this->options['general']['title']);

		echo '
		<p class="math-captcha-form">';

		if(!empty($captcha_title))
			echo '
			<label>'.$captcha_title.'<br /></label>';

		echo '
			<span>'.$this->generate_captcha_phrase('bbpress').'</span>
		</p>';
	}


	/**
	 * Validates bbpress topics and replies
	*/
	public function check_bbpress_captcha()
	{
		if(isset($_POST['mc-value']) && $_POST['mc-value'] !== '')
		{
			if($this->session_ids['default'] !== '' && get_transient('bbp_'.$this->session_ids['default']) !== FALSE)
			{
				if(strcmp(get_transient('bbp_'.$this->session_ids['default']), sha1(AUTH_KEY.$_POST['mc-value'].$this->session_ids['default'], FALSE)) !== 0)
					bbp_add_error('math-captcha-wrong', $this->error_messages['wrong']);
			}
			else
				bbp_add_error('math-captcha-wrong', $this->error_messages['time']);
		}
		else
			bbp_add_error('math-captcha-wrong', $this->error_messages['fill']);
	}


	/**
	 * Encodes chars
	*/
	private function encode_operation($string)
	{
		$chars = str_split($string);
		$seed = mt_rand(0, (int)abs(crc32($string) / strlen($string)));

		foreach($chars as $key => $char)
		{
			$ord = ord($char);

			//ignore non-ascii chars
			if($ord < 128)
			{
				//pseudo "random function"
				$r = ($seed * (1 + $key)) % 100;

				if($r > 60 && $char !== '@') {} // plain character (not encoded), if not @-sign
				elseif($r < 45) $chars[$key] = '&#x'.dechex($ord).';'; //hexadecimal
				else $chars[$key] = '&#'.$ord.';'; //decimal (ascii)
			}
		}

		return implode('', $chars);
	}


	/**
	 * Converts numbers to words
	*/
	private function numberToWords($number)
	{
		$words = array(
			1 => __('one', 'math-captcha'),
			2 => __('two', 'math-captcha'),
			3 => __('three', 'math-captcha'),
			4 => __('four', 'math-captcha'),
			5 => __('five', 'math-captcha'),
			6 => __('six', 'math-captcha'),
			7 => __('seven', 'math-captcha'),
			8 => __('eight', 'math-captcha'),
			9 => __('nine', 'math-captcha'),
			10 => __('ten', 'math-captcha'),
			11 => __('eleven', 'math-captcha'),
			12 => __('twelve', 'math-captcha'),
			13 => __('thirteen', 'math-captcha'),
			14 => __('fourteen', 'math-captcha'),
			15 => __('fifteen', 'math-captcha'),
			16 => __('sixteen', 'math-captcha'),
			17 => __('seventeen', 'math-captcha'),
			18 => __('eighteen', 'math-captcha'),
			19 => __('nineteen', 'math-captcha'),
			20 => __('twenty', 'math-captcha'),
			30 => __('thirty', 'math-captcha'),
			40 => __('forty', 'math-captcha'),
			50 => __('fifty', 'math-captcha'),
			60 => __('sixty', 'math-captcha'),
			70 => __('seventy', 'math-captcha'),
			80 => __('eighty', 'math-captcha'),
			90 => __('ninety', 'math-captcha')
		);

		if(isset($words[$number]))
			return $words[$number];
		else
		{
			$reverse = FALSE;

			switch(get_bloginfo('language'))
			{
				case 'de-DE':
					$spacer = 'und';
					$reverse = TRUE;
					break;

				case 'nl-NL':
					$spacer = 'en';
					$reverse = TRUE;
					break;
				
				case 'ru-RU':
				case 'pl-PL':
				case 'en-EN':
				default:
					$spacer = ' ';
			}

			$first = (int)(substr($number, 0, 1) * 10);
			$second = (int)substr($number, -1);

			return ($reverse === FALSE ? $words[$first].$spacer.$words[$second] : $words[$second].$spacer.$words[$first]);
		}
	}


	/**
	 * Generates captcha
	*/
	public function generate_captcha_phrase($form = '')
	{
		$ops = array(
			'addition' => '+',
			'subtraction' => '&#8722;',
			'multiplication' => '&#215;',
			'division' => '&#247;',
		);

		$operations = $groups = array();
		$input = '<input type="text" size="2" length="2" id="mc-input" name="mc-value" value="" aria-required="true" />';

		//available operations
		foreach($this->options['general']['mathematical_operations'] as $operation => $enable)
		{
			if($enable === TRUE)
				$operations[] = $operation;
		}

		//available groups
		foreach($this->options['general']['groups'] as $group => $enable)
		{
			if($enable === TRUE)
				$groups[] = $group;
		}

		//number of groups
		$ao = count($groups);

		//operation
		$rnd_op = $operations[mt_rand(0, count($operations) - 1)];
		$number[3] = $ops[$rnd_op];

		//place where to put empty input
		$rnd_input = mt_rand(0, 2);

		//which random operation
		switch($rnd_op)
		{
			case 'addition':
				if($rnd_input === 0)
				{
					$number[0] = mt_rand(1, 10);
					$number[1] = mt_rand(1, 89);
				}
				elseif($rnd_input === 1)
				{
					$number[0] = mt_rand(1, 89);
					$number[1] = mt_rand(1, 10);
				}
				elseif($rnd_input === 2)
				{
					$number[0] = mt_rand(1, 9);
					$number[1] = mt_rand(1, 10 - $number[0]);
				}

				$number[2] = $number[0] + $number[1];
				break;

			case 'subtraction':
				if($rnd_input === 0)
				{
					$number[0] = mt_rand(2, 10);
					$number[1] = mt_rand(1, $number[0] - 1);
				}
				elseif($rnd_input === 1)
				{
					$number[0] = mt_rand(11, 99);
					$number[1] = mt_rand(1, 10);
				}
				elseif($rnd_input === 2)
				{
					$number[0] = mt_rand(11, 99);
					$number[1] = mt_rand($number[0] - 10, $number[0] - 1);
				}

				$number[2] = $number[0] - $number[1];
				break;

			case 'multiplication':
				if($rnd_input === 0)
				{
					$number[0] = mt_rand(1, 10);
					$number[1] = mt_rand(1, 9);
				}
				elseif($rnd_input === 1)
				{
					$number[0] = mt_rand(1, 9);
					$number[1] = mt_rand(1, 10);
				}
				elseif($rnd_input === 2)
				{
					$number[0] = mt_rand(1, 10);
					$number[1] = ($number[0] > 5 ? 1 : ($number[0] === 4 && $number[0] === 5 ? mt_rand(1, 2) : ($number[0] === 3 ? mt_rand(1, 3) : ($number[0] === 2 ? mt_rand(1, 5) : mt_rand(1, 10)))));
				}

				$number[2] = $number[0] * $number[1];
				break;

			case 'division':
				if($rnd_input === 0)
				{
					$divide = array(2 => array(1, 2), 3 => array(1, 3), 4 => array(1, 2, 4), 5 => array(1, 5), 6 => array(1, 2, 3, 6), 7 => array(1, 7), 8 => array(1, 2, 4, 8), 9 => array(1, 3, 9), 10 => array(1, 2, 5, 10));
					$number[0] = mt_rand(2, 10);
					$number[1] = $divide[$number[0]][mt_rand(0, count($divide[$number[0]]) - 1)];
				}
				elseif($rnd_input === 1)
				{
					$divide = array(1 => 99, 2 => 49, 3 => 33, 4 => 24, 5 => 19, 6 => 16, 7 => 14, 8 => 12, 9 => 11, 10 => 9);
					$number[1] = mt_rand(1, 10);
					$number[0] = $number[1] * mt_rand(1, $divide[$number[1]]);
				}
				elseif($rnd_input === 2)
				{
					$divide = array(1 => 99, 2 => 49, 3 => 33, 4 => 24, 5 => 19, 6 => 16, 7 => 14, 8 => 12, 9 => 11, 10 => 9);
					$number[2] = mt_rand(1, 10);
					$number[0] = $number[2] * mt_rand(1, $divide[$number[2]]);
					$number[1] = (int)($number[0] / $number[2]);
				}

				if(!isset($number[2]))
				{
					$number[2] = (int)($number[0] / $number[1]);
				}
				break;
		}

		//words
		if($ao === 1 && $groups[0] === 'words')
		{
			if($rnd_input === 0)
			{
				$number[1] = $this->numberToWords($number[1]);
				$number[2] = $this->numberToWords($number[2]);
			}
			elseif($rnd_input === 1)
			{
				$number[0] = $this->numberToWords($number[0]);
				$number[2] = $this->numberToWords($number[2]);
			}
			elseif($rnd_input === 2)
			{
				$number[0] = $this->numberToWords($number[0]);
				$number[1] = $this->numberToWords($number[1]);
			}
		}
		//numbers and words
		elseif($ao === 2)
		{
			if($rnd_input === 0)
			{
				if(mt_rand(1, 2) === 2)
				{
					$number[1] = $this->numberToWords($number[1]);
					$number[2] = $this->numberToWords($number[2]);
				}
				else
					$number[$tmp = mt_rand(1, 2)] = $this->numberToWords($number[$tmp]);
			}
			elseif($rnd_input === 1)
			{
				if(mt_rand(1, 2) === 2)
				{
					$number[0] = $this->numberToWords($number[0]);
					$number[2] = $this->numberToWords($number[2]);
				}
				else
					$number[$tmp = array_rand(array(0 => 0, 2 => 2), 1)] = $this->numberToWords($number[$tmp]);
			}
			elseif($rnd_input === 2)
			{
				if(mt_rand(1, 2) === 2)
				{
					$number[0] = $this->numberToWords($number[0]);
					$number[1] = $this->numberToWords($number[1]);
				}
				else
					$number[$tmp = mt_rand(0, 1)] = $this->numberToWords($number[$tmp]);
			}
		}

		if(in_array($form, array('default', 'bbpress'), TRUE))
		{
			//position of empty input
			if($rnd_input === 0)
				$return = $input.' '.$number[3].' '.$this->encode_operation($number[1]).' = '.$this->encode_operation($number[2]);
			elseif($rnd_input === 1)
				$return = $this->encode_operation($number[0]).' '.$number[3].' '.$input.' = '.$this->encode_operation($number[2]);
			elseif($rnd_input === 2)
				$return = $this->encode_operation($number[0]).' '.$number[3].' '.$this->encode_operation($number[1]).' = '.$input;

			$transient_name = ($form === 'bbpress' ? 'bbp' : 'mc');
			$session_id = $this->session_ids['default'];
		}
		elseif($form === 'cf7')
		{
			$return = array();

			if($rnd_input === 0)
			{
				$return['input'] = 1;
				$return[2] = ' '.$number[3].' '.$this->encode_operation($number[1]).' = ';
				$return[3] = $this->encode_operation($number[2]);
			}
			elseif($rnd_input === 1)
			{
				$return[1] = $this->encode_operation($number[0]).' '.$number[3].' ';
				$return['input'] = 2;
				$return[3] = ' = '.$this->encode_operation($number[2]);
			}
			elseif($rnd_input === 2)
			{
				$return[1] = $this->encode_operation($number[0]).' '.$number[3].' ';
				$return[2] = $this->encode_operation($number[1]).' = ';
				$return['input'] = 3;
			}

			$transient_name = 'cf7';
			$session_id = $this->session_ids['multi'][$this->session_number++];
		}

		set_transient($transient_name.'_'.$session_id, sha1(AUTH_KEY.$number[$rnd_input].$session_id, FALSE), apply_filters('math_captcha_time', $this->options['general']['time']));

		return $return;
	}


	/**
	 * Load defaults
	*/
	public function load_defaults()
	{
		$this->error_messages = array(
			'fill' => '<strong>'. __('ERROR', 'math-captcha').'</strong>: '.__('Please enter captcha value.', 'math-captcha'),
			'wrong' => '<strong>'. __('ERROR', 'math-captcha').'</strong>: '.__('Invalid captcha value.', 'math-captcha'),
			'time' => '<strong>'. __('ERROR', 'math-captcha').'</strong>: '.__('Captcha time expired.', 'math-captcha')
		);

		$this->enable_for = array(
			'login_form' => __('login form', 'math-captcha'),
			'registration_form' => __('registration form', 'math-captcha'),
			'reset_password_form' => __('reset password form', 'math-captcha'),
			'comment_form' => __('comment form', 'math-captcha'),
			'bbpress' => __('bbpress', 'math-captcha'),
			'contact_form_7' => __('contact form 7', 'math-captcha')
		);

		$this->choices = array(
			'yes' => __('yes', 'math-captcha'),
			'no' => __('no', 'math-captcha')
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
	 * Registers settings
	*/
	public function register_settings()
	{
		//inline edit
		register_setting('math_captcha_options', 'math_captcha_options', array(&$this, 'validate_configuration'));
		add_settings_section('math_captcha_settings', __('Math Captcha settings', 'math-captcha'), '', 'math_captcha_options');
		add_settings_field('mc_enable_for', __('Enable Math Captcha for', 'math-captcha'), array(&$this, 'mc_enable_captcha_for'), 'math_captcha_options', 'math_captcha_settings');
		add_settings_field('mc_hide_for_logged_users', __('Hide for logged in users', 'math-captcha'), array(&$this, 'mc_hide_for_logged_users'), 'math_captcha_options', 'math_captcha_settings');
		add_settings_field('mc_mathematical_operations', __('Mathematical operations', 'math-captcha'), array(&$this, 'mc_mathematical_operations'), 'math_captcha_options', 'math_captcha_settings');
		add_settings_field('mc_groups', __('Display captcha as', 'math-captcha'), array(&$this, 'mc_groups'), 'math_captcha_options', 'math_captcha_settings');
		add_settings_field('mc_title', __('Captcha field title', 'math-captcha'), array(&$this, 'mc_title'), 'math_captcha_options', 'math_captcha_settings');
		add_settings_field('mc_time', __('Captcha time', 'math-captcha'), array(&$this, 'mc_time'), 'math_captcha_options', 'math_captcha_settings');
		add_settings_field('mc_deactivation_delete', __('Deactivation', 'math-captcha'), array(&$this, 'mc_deactivation_delete'), 'math_captcha_options', 'math_captcha_settings');
	}


	/**
	 * Setting field - enable for
	*/
	public function mc_enable_captcha_for()
	{
		echo '
		<div class="wplikebtns">';

		foreach($this->enable_for as $val => $trans)
		{
			echo '
			<input id="mc-enable-for-'.$val.'" type="checkbox" name="math_captcha_options[enable_for][]" value="'.$val.'" '.checked(TRUE, $this->options['general']['enable_for'][$val], FALSE).' '.disabled((($val === 'contact_form_7' && !is_plugin_active('contact-form-7/wp-contact-form-7.php')) || ($val === 'bbpress' && !is_plugin_active('bbpress/bbpress.php'))), TRUE, FALSE).' />
			<label for="mc-enable-for-'.$val.'">'.$trans.'</label>';
		}

		echo '
			<p class="description">'.__('Select were would you like to use Math Captcha.', 'math-captcha').'</p>
		</div>';
	}


	/**
	 * Setting field - hide for logged in users
	*/
	public function mc_hide_for_logged_users()
	{
		echo '
		<div class="wplikebtns">';

		foreach($this->choices as $val => $trans)
		{
			echo '
			<input id="mc-hide-for-logged-'.$val.'" type="radio" name="math_captcha_options[hide_for_logged_users]" value="'.$val.'" '.checked(($val === 'yes' ? TRUE : FALSE), $this->options['general']['hide_for_logged_users'], FALSE).' />
			<label for="mc-hide-for-logged-'.$val.'">'.$trans.'</label>';
		}

		echo '
			<p class="description">'.__('Would you like to hide captcha for logged in users?', 'math-captcha').'</p>
		</div>';
	}


	/**
	 * Setting field - title
	*/
	public function mc_title()
	{
		echo '
		<div>
			<input type="text" name="math_captcha_options[title]" value="'.$this->options['general']['title'].'" />
			<p class="description">'.__('How to entitle field with captcha?', 'math-captcha').'</p>
		</div>';
	}


	/**
	 * Setting field - time
	*/
	public function mc_time()
	{
		echo '
		<div>
			<input type="text" name="math_captcha_options[time]" value="'.$this->options['general']['time'].'" />
			<p class="description">'.__('Enter the time (in seconds) a user has to enter captcha value.', 'math-captcha').'</p>
		</div>';
	}


	/**
	 * Setting field - delete settings during deactivation
	*/
	public function mc_deactivation_delete()
	{
		echo '
		<div class="wplikebtns">';

		foreach($this->choices as $val => $trans)
		{
			echo '
			<input id="mc-deactivation-delete-'.$val.'" type="radio" name="math_captcha_options[deactivation_delete]" value="'.$val.'" '.checked(($val === 'yes' ? TRUE : FALSE), $this->options['general']['deactivation_delete'], FALSE).' />
			<label for="mc-deactivation-delete-'.$val.'">'.$trans.'</label>';
		}

		echo '
			<p class="description">'.__('Delete settings on plugin deactivation', 'math-captcha').'</p>
		</div>';
	}


	/**
	 * Setting field - methematical operations
	*/
	public function mc_mathematical_operations()
	{
		echo '
		<div class="wplikebtns">';

		foreach($this->mathematical_operations as $val => $trans)
		{
			echo '
			<input id="mc-mathematical-operations-'.$val.'" type="checkbox" name="math_captcha_options[mathematical_operations][]" value="'.$val.'" '.checked(TRUE, $this->options['general']['mathematical_operations'][$val], FALSE).' />
			<label for="mc-mathematical-operations-'.$val.'">'.$trans.'</label>';
		}

		echo '
			<p class="description">'.__('Select which mathematical operations to use in your captcha.', 'math-captcha').'</p>
		</div>';
	}


	/**
	 * Setting field - groups
	*/
	public function mc_groups()
	{
		echo '
		<div class="wplikebtns">';

		foreach($this->groups as $val => $trans)
		{
			echo '
			<input id="mc-groups-'.$val.'" type="checkbox" name="math_captcha_options[groups][]" value="'.$val.'" '.checked(TRUE, $this->options['general']['groups'][$val], FALSE).' />
			<label for="mc-groups-'.$val.'">'.$trans.'</label>';
		}

		echo '
			<p class="description">'.__('Select how you\'d like to display you captcha.', 'math-captcha').'</p>
		</div>';
	}


	/**
	 * Validates settings
	*/
	public function validate_configuration($input)
	{
		if(isset($_POST['save_math_captcha_options']))
		{
			$enable_for = array();
			$mathematical_operations = array();
			$groups = array();

			if(empty($input['enable_for']))
			{
				foreach($this->defaults['general']['enable_for'] as $enable => $bool)
				{
					$input['enable_for'][$enable] = FALSE;
				}
			}
			else
			{
				foreach($this->enable_for as $enable => $trans)
				{
					$enable_for[$enable] = (in_array($enable, $input['enable_for']) ? TRUE : FALSE);
				}

				$input['enable_for'] = $enable_for;
			}

			if(!is_plugin_active('contact-form-7/wp-contact-form-7.php') && $this->options['general']['enable_for']['contact_form_7'] === TRUE)
				$input['enable_for']['contact_form_7'] = TRUE;

			if(!is_plugin_active('bbpress/bbpress.php') && $this->options['general']['enable_for']['bbpress'] === TRUE)
				$input['enable_for']['bbpress'] = TRUE;

			if(empty($input['mathematical_operations']))
			{
				add_settings_error('empty-operations', 'settings_updated', __('You need to check at least one mathematical operation. Defaults settings of this option restored.', 'math-captcha'), 'error');

				$input['mathematical_operations'] = $this->defaults['general']['mathematical_operations'];
			}
			else
			{
				foreach($this->mathematical_operations as $operation => $trans)
				{
					$mathematical_operations[$operation] = (in_array($operation, $input['mathematical_operations']) ? TRUE : FALSE);
				}

				$input['mathematical_operations'] = $mathematical_operations;
			}

			if(empty($input['groups']))
			{
				add_settings_error('empty-groups', 'settings_updated', __('You need to check at least one group. Defaults settings of this option restored.', 'math-captcha'), 'error');

				$input['groups'] = $this->defaults['general']['groups'];
			}
			else
			{
				foreach($this->groups as $group => $trans)
				{
					$groups[$group] = (in_array($group, $input['groups']) ? TRUE : FALSE);
				}

				$input['groups'] = $groups;
			}

			$input['hide_for_logged_users'] = (isset($input['hide_for_logged_users']) && in_array($input['hide_for_logged_users'], array_keys($this->choices)) ? ($input['hide_for_logged_users'] === 'yes' ? TRUE : FALSE) : $this->defaults['general']['hide_for_logged_users']);
			
			$input['deactivation_delete'] = (isset($input['deactivation_delete']) && in_array($input['deactivation_delete'], array_keys($this->choices)) ? ($input['deactivation_delete'] === 'yes' ? TRUE : FALSE) : $this->options['general']['deactivation_delete']);

			$input['title'] = trim(sanitize_text_field($input['title']));

			$time = (int)$input['time'];
			$input['time'] = ($time < 0 ? $this->defaults['general']['time'] : $time);
		}

		return $input;
	}


	/**
	 * Adds options menu
	*/
	public function admin_menu_options()
	{
		$watermark_settings_page = add_options_page(
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
		<div class="wrap">'.screen_icon().'
			<h2>'.__('Math Captcha', 'math-captcha').'</h2>
			<div class="metabox-holder postbox-container math-captcha-settings">
				<form action="options.php" method="post">';

		wp_nonce_field('update-options');
		settings_fields('math_captcha_options');
		do_settings_sections('math_captcha_options');
		submit_button('', 'primary', 'save_math_captcha_options', TRUE);

		echo '
				</form>
			</div>
			<div class="df-credits postbox-container">
				<h3 class="metabox-title">'.__('Math Captcha', 'math-captcha').'</h3>
				<div class="inner">
					<h3>'.__('Need support?', 'math-captcha').'</h3>
					<p>'.__('If you are having problems with this plugin, please talk about them in the', 'math-captcha').' <a href="http://dfactory.eu/support/" target="_blank" title="'.__('Support forum','math-captcha').'">'.__('Support forum', 'math-captcha').'</a></p>
					<hr />
					<h3>'.__('Do you like this plugin?', 'math-captcha').'</h3>
					<p><a href="http://wordpress.org/support/view/plugin-reviews/wp-math-captcha" target="_blank" title="'.__('Rate it 5', 'math-captcha').'">'.__('Rate it 5', 'math-captcha').'</a> '.__('on WordPress.org', 'math-captcha').'<br />'.
					__('Blog about it & link to the', 'math-captcha').' <a href="http://dfactory.eu/plugins/math-captcha/" target="_blank" title="'.__('plugin page', 'math-captcha').'">'.__('plugin page', 'math-captcha').'</a><br />'.
					__('Check out our other', 'math-captcha').' <a href="http://dfactory.eu/plugins/" target="_blank" title="'.__('WordPress plugins', 'math-captcha').'">'.__('WordPress plugins', 'math-captcha').'</a>
					</p>            
					<hr />
					<p class="df-link">Created by <a href="http://www.dfactory.eu" target="_blank" title="dFactory - Quality plugins for WordPress"><img src="'.plugins_url('/images/logo-dfactory.png' , __FILE__ ).'" title="dFactory - Quality plugins for WordPress" alt="dFactory - Quality plugins for WordPress" /></a></p>
				</div>
			</div>
			<div class="clear"></div>
		</div>';
	}


	/**
	 * Enqueues scripts and styles (admin side)
	*/
	public function admin_comments_scripts_styles($page)
	{
		if(is_admin() && $page === 'settings_page_math-captcha')
		{
			wp_enqueue_script(
				'math-captcha',
				plugins_url('/js/admin.js', __FILE__),
				array('jquery', 'jquery-ui-core', 'jquery-ui-button')
			);

			wp_enqueue_style('math-captcha-admin', plugins_url('/css/admin.css', __FILE__));
			wp_enqueue_style('math-captcha-front', plugins_url('/css/wp-like-ui-theme.css', __FILE__));
		}
	}


	/**
	 * Loads textdomain
	*/
	public function load_textdomain()
	{
		load_plugin_textdomain('math-captcha', FALSE, dirname(plugin_basename(__FILE__)).'/languages/');
	}


	/**
	 * Add links to Support Forum
	*/
	public function plugin_extend_links($links, $file) 
	{
		if(!current_user_can('install_plugins'))
			return $links;

		$plugin = plugin_basename(__FILE__);

		if($file == $plugin) 
		{
			return array_merge(
				$links,
				array(sprintf('<a href="http://www.dfactory.eu/support/forum/math-captcha/" target="_blank">%s</a>', __('Support', 'math-captcha')))
			);
		}

		return $links;
	}


	/**
	 * Add links to Settings page
	*/
	function plugin_settings_link($links, $file) 
	{
		if(!is_admin() || !current_user_can('manage_options'))
			return $links;

		static $plugin;

		$plugin = plugin_basename(__FILE__);

		if($file == $plugin) 
		{
			$settings_link = sprintf('<a href="%s">%s</a>', admin_url('options-general.php').'?page=math-captcha', __('Settings', 'math-captcha'));
			array_unshift($links, $settings_link);
		}

		return $links;
	}
}
?>