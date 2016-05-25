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

    wp_register_style( 'iewp_crunchstats_css', plugin_dir_url( __FILE__ ) . 'css/iewp_crunchstats.css', array(), '0.0.1', 'all' );
	wp_enqueue_style( 'iewp_crunchstats_css' );

	wp_register_script( 'iewp_charts_js', plugin_dir_url( __FILE__ ) . 'js/vendor/Chart.bundle.js', array('jquery'), '0.0.1', true );
	wp_enqueue_script( 'iewp_charts_js' );

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

        <div class="iewp_crunchstats_report_select_container">
            <label class="iewp-sr-only" for="iewp_crunchstats_report_select">Select report:</label>
            <select id="iewp_crunchstats_report_select">
                <option data-report-type="list-default" value="recently-viewed-content">Recently viewed: all</option>
                <option data-report-type="list-default" value="recently-viewed-posts">Recently viewed: posts</option>
                <option data-report-type="list-default" value="recently-viewed-pages">Recently viewed: pages</option>
                <option data-report-type="list-default" value="recently-viewed-other">Recently viewed: other</option>
                <option data-report-type="list-popular" value="popular-content-all">Popular content: all</option>
                <option data-report-type="list-popular" value="popular-content-posts">Popular content: posts</option>
                <option data-report-type="list-popular" value="popular-content-pages">Popular content: pages</option>
                <option data-report-type="list-popular" value="popular-content-other">Popular content: other</option>
				<option data-report-type="list-referers" value="referers-recent">Recent referers</option>
				<option data-report-type="list-referers-common" value="referers-common">Common referers</option>
                <option data-report-type="list-searches" value="searches-recent">Recent searches</option>
				<option data-report-type="list-searches-common" value="searches-common">Common searches</option>
				<option data-report-type="list-default" value="recent-bot-activity">Recent bot activity</option>
                <option data-report-type="list-404s" value="recent-404-errors">Recent 404 errors</option>
				<option data-report-type="list-404s-common" value="common-404-errors">Common 404 errors</option>
            </select>
			<button class="button iewp_crunchstats_refresh" id="iewp_crunchstats_refresh" disabled="disabled"><span class="dashicons dashicons-update"></span></button>
        </div>

        <div id="iewp_crunchstats_report" class="iewp_crunchstats_report">
            <span class="iewp_crunchstats_loading"><img src="/wp-includes/images/spinner.gif"> generating report ...</span>
        </div>

	</div>

	<?php
}
