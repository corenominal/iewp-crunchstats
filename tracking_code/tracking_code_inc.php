<?php

$endpoint = site_url('/wp-json/iewp_crunchstats/track');

if( !isset($content_type) )
	$content_type = 'other';

if( !isset($name) )
	$name = '';

if( !isset($post_id) )
	$post_id = -1;

$tracking_code = '<script type="text/javascript">
var payload="guid="+encodeURIComponent(window.location.href);
payload+="&title="+encodeURIComponent(document.title);
payload+="&content_type=' . $content_type . '";
payload+="&name=' . $name . '";
payload+="&post_id=' . $post_id . '";
payload+="&user_agent="+encodeURIComponent(navigator.userAgent);
payload+="&search_string="+encodeURIComponent(location.search);
payload+="&referer="+encodeURIComponent(document.referrer);
payload+="&window_width="+window.innerWidth;
payload+="&window_height="+window.innerHeight;
xhttp = new XMLHttpRequest();
xhttp.open( "POST", "' . $endpoint . '", true );
xhttp.setRequestHeader( "Content-type", "application/x-www-form-urlencoded" );
xhttp.send( payload );
</script>';
