<?php
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
    ));
}
add_action( 'rest_api_init', 'iewp_crunchstats_register_endpoints' );

/**
 * Endpoint:/wp-json/iewp_crunchstats/track
 */
require_once( plugin_dir_path( __FILE__ ) . 'track.php' );
