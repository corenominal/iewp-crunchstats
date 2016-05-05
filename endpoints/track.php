<?php
/**
 * Track the hit
 */
function iewp_crunchstats_endpoint_track( $request_data )
{	
	if( get_option( 'iewp_crunchstats_track_logged_in' ) == 'false' )
		return array( 'Notice' => 'tracking disabled for logged in users.' );

	global $wpdb;

	$data = $request_data->get_params();

	// Insert additional data
	$data['date'] = time();
	$data['ip'] = $_SERVER['REMOTE_ADDR'];

	// Fugly, may look at this again
	$data['new_session'] = 0; 
	if( !isset( $_COOKIE['iewp_crunchstats_session'] ) )
	{
		$data['new_session'] = 1;
		setcookie( 'iewp_crunchstats_session', 'foo', 0, "/" );
	}
	
	// Sanity checks
	$keys = array( 'guid','title','content_type','name','post_id','user_agent','search_string','referer','window_width','window_height','date','ip', 'new_session' );
	
	foreach ($keys as $key)
	{
		if( !array_key_exists( $key, $data ) )
			return array( 'error' => 'Tracking failed, insufficient keys.' );
	}

	foreach ( $data as $key => $value )
	{
		if( !in_array( $key, $keys ) )
			return array( 'error' => 'Tracking failed, invalid keys.' );
	}

	// Insert the record
	$wpdb->insert( 'iewp_crunchstats_log', $data, array( '%s', '%s', '%s', '%s', '%d', '%s', '%s', '%s', '%d', '%d', '%d', '%s') );

	return array( 0 );
}