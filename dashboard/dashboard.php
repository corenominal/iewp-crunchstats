<?php
/**
 * Dashboard widget
 */
function iewp_crunchstats_dashboard_widget()
{
	wp_add_dashboard_widget(
		'iewp_crunchstats_dashboard_widget', // Widget slug.
		'WP CrunchStats', // Title.
		'iewp_crunchstats_dashboard_widget_function' // Display function.
	);
}
add_action( 'wp_dashboard_setup', 'iewp_crunchstats_dashboard_widget' );

/**
 * Enqueue additional JavaScript
 */
function iewp_crunchstats_enqueue_scripts( $hook )
{

	if( 'index.php' != $hook )
	{
		return;
	}

	wp_register_script( 'iewp_crunchstats_js', plugin_dir_url( __FILE__ ) . 'js/iewp_crunchstats.js', array('jquery'), '0.0.1', true );
	wp_enqueue_script( 'iewp_crunchstats_js' );

	wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'iewp_crunchstats_enqueue_scripts' );

/**
* Widget content
*/
function iewp_crunchstats_dashboard_widget_function()
{
	?>
	<div id="iewp_crunchstats" class="iewp_crunchstats" data-site-url="<?php echo site_url() ?>" data-apikey="<?php echo get_option( 'iewp_crunchstats_apikey', '' ) ?>">

	</div>

	<?php
}
