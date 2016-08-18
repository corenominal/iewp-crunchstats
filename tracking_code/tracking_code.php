<?php
if ( ! defined( 'WPINC' ) ) { die('Direct access prohibited!'); }
/**
 * Output the tracking code.
 */
function iewp_crunchstats_tracking_code()
{

	// Test - preview page?
	if( is_preview() == true )
		return;

	// Test - tracking enabled?
	if( get_option( 'iewp_crunchstats_enable' ) == 'disabled' )
		return;

	global $wp;

	// Set some default values
	$content_type = 'other';
	$name = '';
	$post_id = -1;

	if( is_front_page() && is_home() )
		$content_type = 'homepage';

	if( is_single() )
	{
		$content_type = 'post';
		$name = $wp->query_vars['name'];
		$post_id = get_the_ID();
	}

	if( is_page() )
	{
		$content_type = 'page';
		$name = $wp->query_vars['pagename'];
		$post_id = get_the_ID();
	}

	if( is_archive() )
		$content_type = 'archive';

	if( is_category() )
		$content_type = 'category';

	if( is_tax() )
		$content_type = 'taxonomy';

	if( is_author() )
		$content_type = 'taxonomy';

	if( is_search() )
		$content_type = 'search';

	if( is_404() )
		$content_type = '404';

	require_once( plugin_dir_path( __FILE__ ) . 'tracking_code_inc.php' );

	echo str_replace( array("\r", "\n"), '', $tracking_code ) . "\n";
}
add_action( 'wp_footer', 'iewp_crunchstats_tracking_code' );
