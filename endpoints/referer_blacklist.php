<?php
if ( ! defined( 'WPINC' ) ) { die('Direct access prohibited!'); }
/**
 * Referer blacklist
 */
function iewp_crunchstats_endpoint_referer_blacklist( $request_data )
{
	global $wpdb;

	$data = $request_data->get_params();

	// Test API key
	if( !isset( $data['apikey'] ) || empty( $data['apikey'] ) )
		return array( 'Error' => 'Please provide a valid API key. e.g. "apikey=YOUR-API-KEY-HERE"' );

	$apikey = get_option( 'iewp_crunchstats_apikey', '' );

	if( $apikey != $data['apikey'] )
		return array( 'Error' => 'Invalid API key' );

	if( !isset( $data['action'] ) || empty( $data['action'] ) )
		return array( 'Error' => 'Please specify an action. e.g. "action=insert"' );

	// Switch on action
	switch ( $data['action'] )
	{
		case 'insert':
			// Test ID
			if ( !isset( $data['id'] ) || !is_numeric( $data['id'] ) )
				return array( 'Error' => 'No ID provided' );

			// Get refer info
			$row = $wpdb->get_row( "SELECT * FROM iewp_crunchstats_log WHERE id = " . $data['id'], ARRAY_A );

			// Test referer record
			if ( null === $row )
				return array( 'Error' => 'could not retrieve referer details' );

			// Insert refer into blacklist
			$wpdb->insert(
				'iewp_crunchstats_bad_referers',
				array(
					'date' => time(),
					'referer' => $row['referer']
				),
				array(
					'%d',
					'%s'
				)
			);
			return array('Blacklist ID' => $wpdb->insert_id, 'Referer deatils' => $row );

			break;

		default:
			return array( 'Error' => 'Invalid action' );
			break;
	}


}
