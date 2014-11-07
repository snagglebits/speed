<?php
/*
  Plugin Name: Event Espresso - States/Provinces Pack: Australia
  Plugin URI: http://www.eventespresso.com
  Description: This plugin adds Australia States/Provinces to Event Espresso 4.
  Version: 1.0
  Author: Event Espresso
  Author URI: http://www.eventespresso.com
  Copyright 2014 Event Espresso (email : support@eventespresso.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA02110-1301USA
*/

function ee_australia_states_provinces_activate() {
  $installed = get_option( 'ee_australia_states_provinces_added');
  
  if ($installed) return;

  global $wpdb;

  $sql = "INSERT INTO `" . $wpdb->prefix . "esp_state` (`CNT_ISO`, `STA_abbrev`, `STA_name`, `STA_active`) VALUES
    ('AU', 'ACT', 'Australian Capital Territory', 1),
    ('AU', 'NSW', 'New South Wales', 1),
    ('AU', 'NT', 'Northern Territory', 1),
    ('AU', 'QLD', 'Queensland', 1),
    ('AU', 'SA', 'South Australia', 1),
    ('AU', 'TAS', 'Tasmania', 1),
    ('AU', 'VIC', 'Victoria', 1),
    ('AU', 'WA', 'Western Australia', 1);";

  if ($wpdb->query($sql)){

    add_option( 'ee_australia_states_provinces_added', 1, '', 'no' );

  }

}

register_activation_hook( __FILE__, 'ee_australia_states_provinces_activate' );
