<?php
/**
 * Track the hit
 */
function iewp_crunchstats_endpoint_track( $request_data )
{	
	global $iewp_crunchstats_logged_in;

	if( get_option( 'iewp_crunchstats_track_logged_in' ) == 'disabled' && $iewp_crunchstats_logged_in == true )
		return array( 'Notice' => 'tracking disabled for logged in users.' );

	global $wpdb;

	$data = $request_data->get_params();

	// Insert additional data
	$data['date'] = time();
	$data['ip'] = $_SERVER['REMOTE_ADDR'];

	// Are we logging IP addresses? If not, clear it
	if( get_option( 'iewp_crunchstats_record_ip_addresses' ) == 'disabled' )
		$data['ip'] = '';

	// Fugly, may look at this again
	$data['new_session'] = 0; 
	if( !isset( $_COOKIE['iewp_crunchstats_session'] ) )
	{
		$data['new_session'] = 1;
		setcookie( 'iewp_crunchstats_session', 'foo', 0, "/" );
	}

	// Detect bot - basic detection only
	$data['is_bot'] = 0;
	if ( preg_match('/bot|crawl|slurp|spider/i', $data['user_agent'] ) )
	{
		$data['is_bot'] = 1;
	}
	
	// Sanity checks
	$keys = array( 'guid','title','content_type','name','post_id','user_agent','search_string','referer','window_width','window_height','date','ip','new_session','is_bot' );
	
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

	if( strpos( $data['guid'], site_url() ) === false )
		return array( 'Notice' => 'invalid GUID.' );

	// Insert the record
	$wpdb->insert( 'iewp_crunchstats_log', $data, array( '%s', '%s', '%s', '%s', '%d', '%s', '%s', '%s', '%d', '%d', '%d', '%s', '%d') );

	return array( 0 );
}