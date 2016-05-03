<?php
/**
 * Output the tracking code.
 */
function iewp_crunchstats_tracking_code()
{
	
	global $wp;
	//print_r( $_SERVER );
	//print_r( $wp );

	$endpoint = site_url('/wp-json/corenominal/test');

	// Set some default values
	$content = 'other';
	$name = '';
	$post_id = -1;
	//$ip = $_SERVER['REMOTE_ADDR'];
	//$user_agent = $_SERVER['HTTP_USER_AGENT'];
	// $referer = '';
	// if( isset( $_SERVER['HTTP_REFERER'] ) )
	// {
	// 	$referer = $_SERVER['HTTP_REFERER'];
	// 	if (strpos( $referer, site_url() ) !== false)
	// 	{
	// 	    $referer = '';
	// 	}
	// }

	if( is_front_page() && is_home() )
		$content = 'homepage';

	if( is_single() )
	{
		$content = 'post';
		$name = $wp->query_vars['name'];
		$post_id = get_the_ID();
	}

	if( is_page() )
	{
		$content = 'page';
		$name = $wp->query_vars['pagename'];
		$post_id = get_the_ID();
	}

	if( is_archive() )
		$content = 'archive';
	
	if( is_category() )
		$content = 'category';

	if( is_tax() )
		$content = 'taxonomy';

	if( is_author() )
		$content = 'taxonomy';

	if( is_search() )
	{
		$content = 'search';
	}

	if( is_404() )
		$content = '404';

	$tracking_code = '<script type="text/javascript">
var payload = "foo=bar";
payload+="&guid="+window.location.href;
payload+="&title="+document.title;
payload+="&content=' . $content . '";
payload+="&name=' . $name . '";
payload+="&post_id=' . $post_id . '";
payload+="&search_string="+location.search;
payload+="&referer="+document.referrer;

xhttp = new XMLHttpRequest();
xhttp.open( "POST", "' . $endpoint . '", true );
xhttp.setRequestHeader( "Content-type", "application/x-www-form-urlencoded" );
xhttp.send( payload );
</script>';

	echo str_replace( array("\r", "\n"), '', $tracking_code );
}
add_action( 'wp_footer', 'iewp_crunchstats_tracking_code' );
