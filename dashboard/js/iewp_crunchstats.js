jQuery(document).ready(function($)
{

	// Get the API key and site URL, set endpoint root
	var apikey = $( '#iewp_crunchstats' ).data( 'apikey' );
	var site_url = $( '#iewp_crunchstats' ).data( 'site-url' );
	var endpoint = site_url + '/wp-json/iewp_crunchstats/';

	// Perform maintenance and call first report
	$.ajax({
		url: endpoint + 'maintenance',
		type: 'GET',
		dataType: 'json',
		data: {apikey: apikey}
	})
	.done(function() {
		// Get the default report
		iewp_crunchstats_get_report( 'recently-viewed-content', 'list-default' );
	})
	.fail(function() {
		console.log('Error running iewp_crunchstats maintenance AJAX call');
	});

    // Select report
    $( document ).on( 'change keyup', '#iewp_crunchstats_report_select', function()
    {
		$( '#iewp_crunchstats_refresh' ).attr('disabled', 'disabled');
		var report = $( this ).val();
		var report_type = $( this ).find(':selected').data( 'report-type' );

        $( '#iewp_crunchstats_report' ).html( '<span class="iewp_crunchstats_loading"><img src="/wp-includes/images/spinner.gif"> generating report ...</span>' );

        iewp_crunchstats_get_report( report, report_type );

    });

	// Refresh button
    $( document ).on( 'click', '#iewp_crunchstats_refresh', function()
    {
		$( this ).attr('disabled', 'disabled');
		var report = $( '#iewp_crunchstats_report_select' ).val();
		var report_type = $( '#iewp_crunchstats_report_select' ).find(':selected').data( 'report-type' );

        $( '#iewp_crunchstats_report' ).html( '<span class="iewp_crunchstats_loading"><img src="/wp-includes/images/spinner.gif"> generating report ...</span>' );

        iewp_crunchstats_get_report( report, report_type );

    });

	// Get data for report and call report generating function
	function iewp_crunchstats_get_report( report, report_type)
	{
		$.ajax({
			url: endpoint + 'stats',
			type: 'GET',
			dataType: 'json',
			data: { apikey: apikey, report: report }
		})
		.done(function( data ) {
            if( data.num_rows > 0 )
			{
				switch ( report_type )
				{
					case 'list-default':
						iewp_crunchstats_report_type_list_default( data.report );
						break;

					default:
						$( '#iewp_crunchstats_report' ).html( '<span class="nodata"><span class="dashicons dashicons-warning"></span> Invalid report type.</span>' );
						break;
				}
			}
			else
			{
				$( '#iewp_crunchstats_report' ).html( '<span class="nodata"><span class="dashicons dashicons-warning"></span> No data to report with.</span>' );
			}
			$( '#iewp_crunchstats_refresh' ).removeAttr("disabled");
		})
		.fail(function() {
			console.log('Error running iewp_crunchstats stats AJAX call:' + report);
			$( '#iewp_crunchstats_refresh' ).removeAttr("disabled");
		});
	}

	function iewp_crunchstats_report_type_list_default( data )
	{
		var r = '<ul>';
		jQuery.each(data, function(i, row)
		{
			r += '<li><span class="timestamp">' + row.date + '</span> <a href="' + row.guid + '">' + row.title + '</a></li>';
		});
		r += '</ul>';
		$( '#iewp_crunchstats_report' ).html( r );
	}


});
