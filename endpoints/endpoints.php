<?php
if ( ! defined( 'WPINC' ) ) { die('Direct access prohibited!'); }
/**
 * Test if user is logged in.
 * Note, this is fugly, should look at improving
 */
function iewp_crunchstats_set_global_user_logged_in()
{
    global $iewp_crunchstats_logged_in;

    $iewp_crunchstats_logged_in = false;
    if ( is_user_logged_in() == true )
    {
        $iewp_crunchstats_logged_in = true;
    }
}
add_action( 'rest_api_init', 'iewp_crunchstats_set_global_user_logged_in' );

/**
 * Register endpoints
 */
function iewp_crunchstats_register_endpoints()
{
	// Endpoint:/wp-json/iewp_crunchstats/track
	register_rest_route( 'iewp_crunchstats', '/track', array(
        'methods' => 'POST',
        'callback' => 'iewp_crunchstats_endpoint_track',
        'show_in_index' => false,
    ));

	// Endpoint:/wp-json/iewp_crunchstats/stats
    register_rest_route( 'iewp_crunchstats', '/stats', array(
        'methods' => 'GET',
        'callback' => 'iewp_crunchstats_endpoint_stats',
        'show_in_index' => false,
    ));

	// Endpoint:/wp-json/iewp_crunchstats/maintenance
    register_rest_route( 'iewp_crunchstats', '/maintenance', array(
        'methods' => 'GET',
        'callback' => 'iewp_crunchstats_endpoint_maintenance',
        'show_in_index' => false,
    ));

    // Endpoint:/wp-json/iewp_crunchstats/maintenance
    register_rest_route( 'iewp_crunchstats', '/referer_blacklist', array(
        'methods' => 'GET',
        'callback' => 'iewp_crunchstats_endpoint_referer_blacklist',
        'show_in_index' => false,
    ));

	// Endpoint:/wp-json/iewp_crunchstats/debug
    register_rest_route( 'iewp_crunchstats', '/debug', array(
        'methods' => 'GET',
        'callback' => 'iewp_crunchstats_endpoint_debug',
        'show_in_index' => false,
    ));
}
add_action( 'rest_api_init', 'iewp_crunchstats_register_endpoints' );

// Endpoint:/wp-json/iewp_crunchstats/track
require_once( plugin_dir_path( __FILE__ ) . 'track.php' );

// Endpoint:/wp-json/iewp_crunchstats/stats
require_once( plugin_dir_path( __FILE__ ) . 'stats.php' );

// Endpoint:/wp-json/iewp_crunchstats/stats
require_once( plugin_dir_path( __FILE__ ) . 'maintenance.php' );

// Endpoint:/wp-json/iewp_crunchstats/referer_blacklist
require_once( plugin_dir_path( __FILE__ ) . 'referer_blacklist.php' );

// Endpoint:/wp-json/iewp_crunchstats/debug
require_once( plugin_dir_path( __FILE__ ) . 'debug.php' );
