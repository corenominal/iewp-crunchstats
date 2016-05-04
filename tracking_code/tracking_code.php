<?php
/**
 * Output the tracking code.
 */
function iewp_crunchstats_tracking_code()
{
	global $wp;

	$endpoint = site_url('/wp-json/iewp_crunchstats/track');

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

	$tracking_code = '<script type="text/javascript">
var payload="guid="+window.location.href;
payload+="&title="+document.title;
payload+="&content_type=' . $content_type . '";
payload+="&name=' . $name . '";
payload+="&post_id=' . $post_id . '";
payload+="&user_agent="+navigator.userAgent;
payload+="&search_string="+location.search;
payload+="&referer="+document.referrer;
payload+="&window_width="+window.innerWidth;
payload+="&window_height="+window.innerHeight;

xhttp = new XMLHttpRequest();
xhttp.open( "POST", "' . $endpoint . '", true );
xhttp.setRequestHeader( "Content-type", "application/x-www-form-urlencoded" );
xhttp.send( payload );
</script>';

	echo str_replace( array("\r", "\n"), '', $tracking_code );
}
add_action( 'wp_footer', 'iewp_crunchstats_tracking_code' );
