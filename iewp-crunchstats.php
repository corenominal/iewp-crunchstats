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
	require_once( plugin_dir_path( __FILE__ ) . 'activation/defaults.php' );
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

/**
 * Plugin settings link
 */
function iewp_crunchstats_action_links( $actions, $plugin_file )
{
	static $plugin;

	if (!isset($plugin))
		$plugin = plugin_basename(__FILE__);
	if ($plugin == $plugin_file)
	{
		$settings = array('settings' => '<a href="options-general.php?page=options-iewp-crunchstats">' . __('Settings', 'General') . '</a>');

		$actions = array_merge($settings, $actions);
	}
	return $actions;
}
add_filter( 'plugin_action_links', 'iewp_crunchstats_action_links', 10, 5 );

/**
 * Settings Page
 */
require_once( plugin_dir_path( __FILE__ ) . 'admin/admin.php' );

/**
 * Dashboard Widget
 */
require_once( plugin_dir_path( __FILE__ ) . 'dashboard/dashboard.php' );
