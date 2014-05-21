<?php
/**
 A module for [mathcaptcha]
**/

//shortcode handler
add_action('init', 'wpcf7_add_shortcode_mathcaptcha', 5);

function wpcf7_add_shortcode_mathcaptcha()
{
	wpcf7_add_shortcode('mathcaptcha', 'wpcf7_mathcaptcha_shortcode_handler', TRUE);
}

function wpcf7_mathcaptcha_shortcode_handler($tag)
{
	global $mc_class;
	
	if(!is_user_logged_in() || (is_user_logged_in() && $mc_class->get_options('hide_for_logged_users') === FALSE))
	{
		$tag = new WPCF7_Shortcode($tag);

		if(empty($tag->name))
			return '';

		$validation_error = wpcf7_get_validation_error($tag->name);
		$class = wpcf7_form_controls_class($tag->type);

		if($validation_error)
			$class .= ' wpcf7-not-valid';

		$atts = array();
		$atts['size'] = 2;
		$atts['maxlength'] = 2;
		$atts['class'] = $tag->get_class_option($class);
		$atts['id'] = $tag->get_option('id', 'id', true);
		$atts['tabindex'] = $tag->get_option('tabindex', 'int', true);
		$atts['aria-required'] = 'true';
		$atts['type'] = 'text';
		$atts['name'] = $tag->name;
		$atts['value'] = '';
		$atts = wpcf7_format_atts($atts);

		$mc_form = $mc_class->generate_captcha_phrase('cf7');
		$mc_form[$mc_form['input']] = '<input %2$s />';

		$math_captcha_title = apply_filters('math_captcha_title', $mc_class->get_options('title'));

		return sprintf(((empty($math_captcha_title)) ? '' : $math_captcha_title).'<span class="wpcf7-form-control-wrap %1$s">'.$mc_form[1].$mc_form[2].$mc_form[3].'%3$s</span><input type="hidden" value="'.($mc_class->get_session_number() - 1).'" name="'.$tag->name.'-sn" />', $tag->name, $atts, $validation_error);
	}
}


//validation
add_filter('wpcf7_validate_mathcaptcha', 'wpcf7_mathcaptcha_validation_filter', 10, 2);

function wpcf7_mathcaptcha_validation_filter($result, $tag)
{
	global $mc_class;

	$tag = new WPCF7_Shortcode($tag);
	$name = $tag->name;

	if(!is_admin() && isset($_POST[$name]))
	{
		if($_POST[$name] !== '')
		{
			$session_id = (isset($_POST[$name.'-sn']) && $_POST[$name.'-sn'] !== '' ? $mc_class->get_session_id($_POST[$name.'-sn']) : '');

			if($session_id !== '' && get_transient('cf7_'.$session_id) !== FALSE)
			{
				if(strcmp(get_transient('cf7_'.$session_id), sha1(AUTH_KEY.$_POST[$name].$session_id, FALSE)) !== 0)
				{
					$result['valid'] = FALSE;
					$result['reason'][$name] = wpcf7_get_message('wrong_mathcaptcha');
				}
			}
			else
			{
				$result['valid'] = FALSE;
				$result['reason'][$name] = wpcf7_get_message('time_mathcaptcha');
			}
		}
		else
		{
			$result['valid'] = FALSE;
			$result['reason'][$name] = wpcf7_get_message('fill_mathcaptcha');
		}
	}

	return $result;
}


//messages
add_filter('wpcf7_messages', 'wpcf7_mathcaptcha_messages');

function wpcf7_mathcaptcha_messages($messages)
{
	global $mc_class;

	return array_merge(
		$messages,
		array(
			'wrong_mathcaptcha' => array(
				'description' => __('Invalid captcha value.', 'math-captcha'),
				'default' => $mc_class->get_error_messages('wrong')
			),
			'fill_mathcaptcha' => array(
				'description' => __('Please enter captcha value.', 'math-captcha'),
				'default' => $mc_class->get_error_messages('fill')
			),
			'time_mathcaptcha' => array(
				'description' => __('Captcha time expired.', 'math-captcha'),
				'default' => $mc_class->get_error_messages('time')
			)
		)
	);
}


//warning message
add_action('wpcf7_admin_notices', 'wpcf7_mathcaptcha_display_warning_message');

function wpcf7_mathcaptcha_display_warning_message()
{
	if(empty($_GET['post']) || !($contact_form = wpcf7_contact_form( $_GET['post'])))
		return;

	$has_tags = (bool)$contact_form->form_scan_shortcode(array('type' => array('mathcaptcha')));

	if(!$has_tags)
		return;
}


//tag generator
add_action('admin_init', 'wpcf7_add_tag_generator_mathcaptcha', 45);

function wpcf7_add_tag_generator_mathcaptcha()
{
	if(!function_exists('wpcf7_add_tag_generator'))
		return;

	wpcf7_add_tag_generator('mathcaptcha', __('Math Captcha', 'math-captcha'), 'wpcf7-mathcaptcha', 'wpcf7_tg_pane_mathcaptcha');
}


function wpcf7_tg_pane_mathcaptcha(&$contact_form)
{
	echo '
	<div id="wpcf7-mathcaptcha" class="hidden">
		<form action="">
			<table>
				<tr>
					<td>
						'.esc_html(__('Name', 'math-captcha')).'<br />
						<input type="text" name="name" class="tg-name oneline" />
					</td>
				</tr>
			</table>
			<table class="scope mathcaptcha">
				<caption>'.esc_html(__('Input field settings', 'math-captcha')).'</caption>
				<tr>
					<td>
						<code>id</code> ('.esc_html(__('optional', 'math-captcha')).')<br />
						<input type="text" name="id" class="idvalue oneline option" />
					</td>
					<td>
						<code>class</code> ('.esc_html(__('optional', 'math-captcha')).')<br />
						<input type="text" name="class" class="classvalue oneline option" />
					</td>
				</tr>
			</table>
			<div class="tg-tag">
				'.esc_html(__('Copy this code and paste it into the form left.', 'math-captcha')).'<br />
				<input type="text" name="mathcaptcha" class="tag" readonly="readonly" onfocus="this.select()" />
			</div>
		</form>
	</div>';
}
?>