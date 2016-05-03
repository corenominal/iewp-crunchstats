<?php
/**
 * Set-up database tables.
 * Test if tables exist, if they don't, create them
 */
function iewp_crunchstats_create_tables()
{
	global $wpdb;

	$query = $wpdb->query( 'SHOW TABLES LIKE "iewp_crunchstats_log"' );
	if( !$query )
	{
		$sql = "CREATE TABLE `iewp_crunchstats_log` (
				  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
				  `date` int(11) NOT NULL,
				  `ip` varchar(50) NOT NULL DEFAULT '',
				  `useragent` varchar(512) NOT NULL DEFAULT '',
				  `post_id` bigint(20) NOT NULL,
				  `referer` varchar(255) NOT NULL DEFAULT '',
				  `slug` varchar(255) NOT NULL DEFAULT '',
				  `guid` varchar(255) NOT NULL DEFAULT '',
				  `title` varchar(255) NOT NULL DEFAULT '',
				  PRIMARY KEY (`id`)
				) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

		$query = $wpdb->query( $sql );
	}
}

iewp_crunchstats_create_tables();
