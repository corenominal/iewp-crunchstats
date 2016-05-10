<?php
/**
 * Insert default options
 */
update_option( 'iewp_crunchstats_enable', 'disabled' );
update_option( 'iewp_crunchstats_track_logged_in', 'enabled' );
update_option( 'iewp_crunchstats_record_ip_addresses', 'disabled' );

$apikey = sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
update_option( 'iewp_crunchstats_apikey', $apikey );