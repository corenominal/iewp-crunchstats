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
            <label for="iewp_crunchstats_report_select">Select report:</label>
            <select id="iewp_crunchstats_report_select">
                <option data-report-type="list-default" value="recently-viewed-content">recently viewed: all</option>
                <option data-report-type="list-default" value="recently-viewed-posts">recently viewed: posts</option>
                <option data-report-type="list-default" value="recently-viewed-pages">recently viewed: pages</option>
                <option data-report-type="list-default" value="recently-viewed-other">recently viewed: other</option>
                <option data-report-type="list-popular" value="popular-content-all">popular content: all</option>
                <option data-report-type="list-popular" value="popular-content-posts">popular content: posts</option>
                <option data-report-type="list-popular" value="popular-content-pages">popular content: pages</option>
                <option data-report-type="list-popular" value="popular-content-other">popular content: other</option>
				<option data-report-type="list-referers" value="referers-recent">recent referers</option>
				<option data-report-type="list-referers-common" value="referers-common">common referers</option>
                <option data-report-type="list-searches" value="searches-recent">recent searches</option>
				<option data-report-type="list-searches-common" value="searches-common">common searches</option>
				<option data-report-type="list-default" value="recent-bot-activity">recent bot activity</option>
                <option data-report-type="list-404s" value="recent-404-errors">recent 404 errors</option>
				<option data-report-type="list-404s-common" value="common-404-errors">common 404 errors</option>
            </select>
			<button class="button iewp_crunchstats_refresh" id="iewp_crunchstats_refresh" disabled="disabled"><span class="dashicons dashicons-update"></span></button>
        </div>

        <div id="iewp_crunchstats_report" class="iewp_crunchstats_report">
            <span class="iewp_crunchstats_loading"><img src="/wp-includes/images/spinner.gif"> generating report ...</span>
        </div>

	</div>

	<?php
}
