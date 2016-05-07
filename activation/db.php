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
				  `new_session` tinyint(1) NOT NULL,
				  `user_agent` varchar(512) NOT NULL DEFAULT '',
				  `is_bot` tinyint(1) NOT NULL,
				  `post_id` bigint(20) NOT NULL,
				  `content_type` varchar(20) NOT NULL DEFAULT '',
				  `name` varchar(255) NOT NULL DEFAULT '',
				  `referer` varchar(255) NOT NULL DEFAULT '',
				  `search_string` varchar(255) NOT NULL DEFAULT '',
				  `guid` varchar(255) NOT NULL DEFAULT '',
				  `title` varchar(255) NOT NULL DEFAULT '',
				  `window_width` int(6) NOT NULL,
				  `window_height` int(6) NOT NULL,
				  PRIMARY KEY (`id`),
				  KEY `date` (`date`),
				  KEY `ip` (`ip`),
				  KEY `new_session` (`new_session`),
				  KEY `is_bot` (`is_bot`)
				) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;";

		$query = $wpdb->query( $sql );
	}
}

iewp_crunchstats_create_tables();
