<?php
/**
 * Add submenu item to the default WordPress "Settings" menu.
 */
function iewp_crunchstats_menu()
{
	add_submenu_page( 
		'options-general.php', // parent slug to attach to
		'CrunchStats', // page title
		'CrunchStats', // menu title
		'manage_options', // capability
		'options-iewp-crunchstats', // slug
		'iewp_crunchstats_callback' // callback function
		);

	// Activate custom settings
	add_action( 'admin_init', 'iewp_crunchstats_register' );
}
add_action( 'admin_menu', 'iewp_crunchstats_menu' );

/**
 * callback function.
 */
function iewp_crunchstats_callback()
{
	?>
	
		<div class="wrap">
			<h1>WordPress CrunchStats</h1>

			<p>A crunchy statistics plugin for WordPress.</p>

			<hr>
			
			<form method="POST" action="options.php">
		
				<?php settings_fields( 'iewp_crunchstats_group' ); ?>
				<?php do_settings_sections( 'iewp_crunchstats_options' ); ?>
				<?php submit_button(); ?>

			</form>

			<hr>

			<h3>Manual Tracking Code</h3>

			<p>By default, CrunchStats will automatically insert its tracking code into any WordPress posts and pages. 
			The code below is provided for any static documents that sit outside of WordPress. Pages tracked with this code 
			will be classified as "other". Simply copy and paste this code into any static documents you want to track.</p>

			<p><strong>Note:</strong> only use this for documents hosted on <code><?php echo site_url() ?></code></p>
			
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row">
							Tracking Code
						</th>
						<td>
							<?php require_once( plugin_dir_path( __FILE__ ) . '../tracking_code/tracking_code_inc.php' ); ?>
							<textarea rows="14" class="widefat" name="iewp_crunchstats_manual_tracking_code" readonly><?php echo $tracking_code ?></textarea>
						</td>
					</tr>
				</tbody>
			</table>

		</div>

	<?php
}

/**
 * Register a custom option to hold tracking code.
 */
function iewp_crunchstats_register()
{
	register_setting( 'iewp_crunchstats_group', 'iewp_crunchstats_enable');
	register_setting( 'iewp_crunchstats_group', 'iewp_crunchstats_track_logged_in');
	
	add_settings_section( 'iewp-crunchstats-options', '', 'iewp_crunchstats_options', 'iewp_crunchstats_options' );
	
	add_settings_field( 'iewp-crunchstats-enable', 'Tracking Enabled', 'iewp_crunchstats_enable', 'iewp_crunchstats_options', 'iewp-crunchstats-options' );
	add_settings_field( 'iewp-crunchstats-tack-logged-in', 'Track WP Users', 'iewp_crunchstats_track_logged_in', 'iewp_crunchstats_options', 'iewp-crunchstats-options' );
}

/**
 * Enabled.
 */
function iewp_crunchstats_enable()
{
	$id = 'iewp_crunchstats_enable';
	$options = array('enabled','disabled');
	$default = 'disabled';
	$description = 'Enable/disable tracking.';
	echo iewp_crunchstats_options_select( $id, $options, $default, $description);
}

/**
 * Enabled.
 */
function iewp_crunchstats_track_logged_in()
{
	$id = 'iewp_crunchstats_track_logged_in';
	$options = array('enabled','disabled');
	$default = 'true';
	$description = 'Track users who are logged into WordPress?';
	echo iewp_crunchstats_options_select( $id, $options, $default, $description);
}

/**
 * Call back function for settings section. Do nothing.
 */
function iewp_crunchstats_options()
{
	return;
}

/**
 * Produces select for options
 */
function iewp_crunchstats_options_select( $id, $options, $default, $description = '' )
{
	$setting = get_option( $id, $default );
	$html = '<select name="'.$id.'">';
        foreach ( $options as $option )
        {
        	$selected = '';
        	if ( $option == $setting )
        	{
        		$selected = ' selected="selected"';
        	}
        	$html .= '<option value="'.$option.'"'.$selected.'>'.$option.'</option>';
        }
	$html .= '</select>';
	if($description != '')
	{
    	$html .= '<p class="description">' . $description . '</p>';
    }
    return $html;
}