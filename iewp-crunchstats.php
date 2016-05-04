<?php
/**
 * Plugin Name: IEWP CrunchStats 
 * Plugin URI: https://github.com/corenominal/iewp-crunchstats
 * Description: A crunchy statistics plugin for WordPress.
 * Author: Philip Newborough
 * Version: 0.0.1
 * Author URI: https://corenominal.org
 */

/**
 * Plugin activation functions
 */
function iewp_crunchstats_activate()
{
	require_once( plugin_dir_path( __FILE__ ) . 'activation/db.php' );
}
register_activation_hook( __FILE__, 'iewp_crunchstats_activate' );

/**
 * The tracking code
 */
require_once( plugin_dir_path( __FILE__ ) . 'tracking_code/tracking_code.php' );

/**
 * REST API endpoints
 */
require_once( plugin_dir_path( __FILE__ ) . 'endpoints/endpoints.php' );