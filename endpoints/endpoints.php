<?php
/**
 * Register endpoints
 */
function iewp_crunchstats_register_endpoints()
{
	// Endpoint:/wp-json/iewp_crunchstats/track
	register_rest_route( 'iewp_crunchstats', '/track', array(
        'methods' => 'POST',
        'callback' => 'iewp_crunchstats_endpoint_track',
    ));
}
add_action( 'rest_api_init', 'iewp_crunchstats_register_endpoints' );

/**
 * Endpoint:/wp-json/iewp_crunchstats/track
 */
require_once( plugin_dir_path( __FILE__ ) . 'track.php' );
