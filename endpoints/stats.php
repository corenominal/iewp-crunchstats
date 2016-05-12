<?php
/**
 * Return the stats
 */
function iewp_crunchstats_endpoint_stats( $request_data )
{	
	global $wpdb;

	$data = $request_data->get_params();

	// Test API key
	if( !isset( $data['apikey'] ) || empty( $data['apikey'] ) )
		return array( 'Error' => 'Please provide a valid API key. e.g. "apikey=YOUR-API-KEY-HERE"' );

	$apikey = get_option( 'iewp_crunchstats_apikey', '' );

	if( $apikey != $data['apikey'] )
		return array( 'Error' => 'Invalid API key' );


	// Test report type
	if( !isset( $data['report'] ) || empty( $data['report'] ) )
		return array( 'Error' => 'Please specify a report type. e.g. "report=summary-today"' );

	// Report switch
	switch ( $data['report'] )
	{
		case 'summary-today':
			return array('foo' => 'bar' );
			break;
		
		default:
			return array( 'Error' => 'Unknown report type. Please specify a valid report type' );
			break;
	}

}