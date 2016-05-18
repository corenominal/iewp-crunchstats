jQuery(document).ready(function($)
{

	// Get the API key and site URL
	var apikey = $( '#iewp_crunchstats' ).data('apikey');
	var site_url = $( '#iewp_crunchstats' ).data('site-url');
	var endpoint = site_url + '/wp-json/iewp_crunchstats/';

	// Perform maintenance and call first report
	$.ajax({
		url: endpoint + 'maintenance',
		type: 'GET',
		dataType: 'json',
		data: {apikey: apikey}
	})
	.done(function() {
		report_recently_viewed_content();
	})
	.fail(function() {
		console.log('Error running iewp_crunchstats maintenance AJAX call');
	});

	// Initial report
	function report_recently_viewed_content()
	{
		var report = 'recently-viewed-content';
		$.ajax({
			url: endpoint + 'stats',
			type: 'GET',
			dataType: 'json',
			data: {apikey: apikey, report: report}
		})
		.done(function( data ) {
			if( data.num_rows > 0 )
			{
				jQuery.each(data.report, function(i, row)
				{
					// TODO create HTML report and spit out into #iewp_crunchstats
					//console.log( row.title );
				});
			}
			else
			{
				// TODO report that there is no report
				//console.log( 'Nothing to play with :(' );
			}


		})
		.fail(function() {
			console.log('Error running iewp_crunchstats stats AJAX call:' + report);
		});
	}


});
