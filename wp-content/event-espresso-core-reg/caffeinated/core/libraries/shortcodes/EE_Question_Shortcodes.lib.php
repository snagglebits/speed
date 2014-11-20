<?php

if (!defined('EVENT_ESPRESSO_VERSION') )
	exit('NO direct script access allowed');

/**
 * Event Espresso
 *
 * Event Registration and Management Plugin for WordPress
 *
 * @ package			Event Espresso
 * @ author				Seth Shoultes
 * @ copyright		(c) 2008-2011 Event Espresso  All Rights Reserved.
 * @ license			http://eventespresso.com/support/terms-conditions/   * see Plugin Licensing *
 * @ link				http://www.eventespresso.com
 * @ version		 	4.0
 *
 * ------------------------------------------------------------------------
 *
 * EE_Question_Shortcodes
 * 
 * this is a child class for the EE_Shortcodes library.  The EE_Question_Shortcodes lists all shortcodes related to Questions and Answers for an attendee. 
 *
 * NOTE: if a method doesn't have any phpdoc commenting the details can be found in the comments in EE_Shortcodes parent class.
 * 
 * @package		Event Espresso
 * @subpackage	libraries/shortcodes/EE_Question_Shortcodes.lib.php
 * @author		Darren Ethier
 *
 * ------------------------------------------------------------------------
 */
class EE_Question_Shortcodes extends EE_Shortcodes {



	protected function _init_props() {
		$this->label = __('Attendee Shortcodes', 'event_espresso');
		$this->description = __('All shortcodes specific to attendee related data', 'event_espresso');
		$this->_shortcodes = array(
			'[QUESTION]' => __('Will parse to a question.', 'event_espresso'),
			'[ANSWER]' => __('Will parse to the answer for a question', 'event_espresso')
			);
	}


	protected function _parser( $shortcode ) {
		
		if ( ! $this->_data instanceof EE_Answer || !isset( $this->_extra_data['data'] ) || ! $this->_extra_data['data'] instanceof EE_Messages_Addressee ) {
			return '';
		}			
		
		switch ( $shortcode ) {

			case '[QUESTION]' :
				if ( isset( $this->_extra_data['data']->questions[$this->_data->ID()] )) {
					return  $this->_extra_data['data']->questions[$this->_data->ID()]->get_pretty('QST_display_text', 'no_wpautop');
					break;
				} else {
					EE_Error::add_error( __('A valid Question object could not be found while attempting to process message shortcodes', 'event_espresso'), __FILE__, __FUNCTION__, __LINE__ );
				}

			case '[ANSWER]' :
				return $this->_data->get_pretty('ANS_value', 'no_wpautop');
				break;
		}
		return '';
	}

} //end EE_Question_Shortcodes class