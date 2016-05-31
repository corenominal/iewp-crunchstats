<?php
/**
 * Debugging stuff - do not use, evar!
 */
function iewp_crunchstats_endpoint_debug( $request_data )
{
	global $wpdb;

	$data = $request_data->get_params();

	// Test API key
	if( !isset( $data['apikey'] ) || empty( $data['apikey'] ) )
		return array( 'Error' => 'Please provide a valid API key. e.g. "apikey=YOUR-API-KEY-HERE"' );

	$apikey = get_option( 'iewp_crunchstats_apikey', '' );

	if( $apikey != $data['apikey'] )
		return array( 'Error' => 'Invalid API key' );

	// Test action
	if( !isset( $data['action'] ) || empty( $data['action'] ) )
		return array( 'Error' => 'Please specify an action. e.g. "action=populate"' );

	switch ( $data['action'])
	{
		case 'populate':
			// Populate the log with random duplicates for the past year
			// Requires seed data
			$sql = "SELECT COUNT(*) AS `total` FROM `iewp_crunchstats_log`";
			$count = $wpdb->get_row( $sql );
			if( $count->total < 100 )
				return array( 'Error' => 'Insufficient seed data' );

			$insert = 100;
			// Grab random row, change date and insert
			for ($i=0; $i < $insert; $i++)
			{
				$sql = "SELECT * FROM `iewp_crunchstats_log`
						ORDER BY RAND()
						LIMIT 1";
				$row = $wpdb->get_row( $sql, ARRAY_A );
				unset( $row['id'] );
				$row['date'] = rand( strtotime( '-1 year' ), strtotime( '-11 months' ) );
				$row['is_bot'] = 0;
				$wpdb->insert(
					'iewp_crunchstats_log',
					$row,
					array( '%d', '%s', '%d', '%s', '%d', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%d' )
				);
			}
			return array( 'Notice' => $insert . ' rows inserted' );
			break;

		default:
			return array( 'Error' => 'Invalid action' );
			break;
	}



}
