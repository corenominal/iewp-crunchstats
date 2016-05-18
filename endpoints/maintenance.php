<?php
/**
 * Run maintenance
 */
function iewp_crunchstats_endpoint_maintenance( $request_data )
{
	global $wpdb;

	$data = $request_data->get_params();

	// Test API key
	if( !isset( $data['apikey'] ) || empty( $data['apikey'] ) )
		return array( 'Error' => 'Please provide a valid API key. e.g. "apikey=YOUR-API-KEY-HERE"' );

	$apikey = get_option( 'iewp_crunchstats_apikey', '' );

	if( $apikey != $data['apikey'] )
		return array( 'Error' => 'Invalid API key' );

	// Clean-up bad referers
	$sql = "SELECT * FROM iewp_crunchstats_bad_referers";
	$bad_referers = $wpdb->get_results( $sql, ARRAY_A );

	if( $wpdb->num_rows > 0 )
	{
		foreach ($bad_referers as $bad_referer)
		{
			$wpdb->delete( 'iewp_crunchstats_log', array( 'referer' => $bad_referer['referer'] ), array( '%s' ) );
		}
	}

	return array( 'Notice' => 'Maintenance run successfully' );

}
