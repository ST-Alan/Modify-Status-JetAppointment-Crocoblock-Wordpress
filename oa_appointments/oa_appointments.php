<?php

/**
  Plugin Name: OA Appointments
  Plugin URI: https://oscaralderete.com/appointments
  Description: Lorem ipsum dolor sit amet consectetur adipiscing elit...
  Version: 1.0.0
  Author: Oscar Alderete <oscaralderete@gmail.com>
  Author URI: https://oscaralderete.com
  License: GPL v2 or later
 */
if (!defined('WPINC')) {
	die;
}

require plugin_dir_path(__FILE__) . 'includes/OA_Appointments.php';

new OscarAlderete\OA_Appointments(__FILE__);
