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
		iewp_crunchstats_get_report( 'today-hour-by-hour', 'graph-day-hour-by-hour' );
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

					case 'list-popular':
						iewp_crunchstats_report_type_list_popular( data.report );
						break;

					case 'list-referers':
						iewp_crunchstats_report_type_list_referers( data.report );
						break;

					case 'list-referers-common':
						iewp_crunchstats_report_type_list_referers_common( data.report );
						break;

					case 'list-searches':
						iewp_crunchstats_report_type_list_searches( data.report );
						break;

					case 'list-searches-common':
						iewp_crunchstats_report_type_list_searches_common( data.report );
						break;

					case 'list-404s':
						iewp_crunchstats_report_type_list_404s( data.report );
						break;

					case 'list-404s-common':
						iewp_crunchstats_report_type_list_404s_common( data.report );
						break;

					case 'graph-day-hour-by-hour':
						iewp_crunchstats_report_graph_day_hour_by_hour( data.label, data.report1, data.report2 );
						break;

					case 'graph-last-X-days':
						iewp_crunchstats_report_graph_last_X_days( data.days, data.label ,data.labels, data.report1, data.report2 );
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
			r += '<li><span class="timestamp">' + row.date + '</span> <a target="_blank" href="' + row.guid + '">' + row.title + '</a></li>';
		});
		r += '</ul>';
		$( '#iewp_crunchstats_report' ).html( r );
	}

	function iewp_crunchstats_report_type_list_popular( data )
	{
		var r = '<ul>';
		jQuery.each(data, function(i, row)
		{
			r += '<li><span class="count">' + row.total + '</span> <a target="_blank" href="' + row.guid + '">' + row.title + '</a></li>';
		});
		r += '</ul>';
		$( '#iewp_crunchstats_report' ).html( r );
	}

	function iewp_crunchstats_report_type_list_referers( data )
	{
		var r = '<ul>';
		jQuery.each(data, function(i, row)
		{
			// TODO options for marking referer spam
			r += '<li><span class="timestamp">' + row.date + '</span> <a target="_blank" href="http://derefer.unbubble.eu?u=' + row.referer + '">' + row.referer + '</a></li>';
		});
		r += '</ul>';
		$( '#iewp_crunchstats_report' ).html( r );
	}

	function iewp_crunchstats_report_type_list_referers_common( data )
	{
		var r = '<ul>';
		jQuery.each(data, function(i, row)
		{
			// TODO options for marking referer spam
			r += '<li><span class="count">' + row.total + '</span> <a target="_blank" href="http://derefer.unbubble.eu?u=' + row.referer + '">' + row.referer + '</a></li>';
		});
		r += '</ul>';
		$( '#iewp_crunchstats_report' ).html( r );
	}

	function iewp_crunchstats_report_type_list_searches( data )
	{
		var r = '<ul>';
		jQuery.each(data, function(i, row)
		{
			r += '<li><span class="timestamp">' + row.date + '</span> <a target="_blank" href="' + row.guid + '">' + row.query + '</a></li>';
		});
		r += '</ul>';
		$( '#iewp_crunchstats_report' ).html( r );
	}

	function iewp_crunchstats_report_type_list_searches_common( data )
	{
		var r = '<ul>';
		jQuery.each(data, function(i, row)
		{
			r += '<li><span class="count">' + row.total + '</span> <a target="_blank" href="' + row.guid + '">' + row.query + '</a></li>';
		});
		r += '</ul>';
		$( '#iewp_crunchstats_report' ).html( r );
	}


	function iewp_crunchstats_report_type_list_404s_common( data )
	{
		var r = '<ul>';
		jQuery.each(data, function(i, row)
		{
			r += '<li><span class="count">' + row.total + '</span> <a target="_blank" href="' + row.guid + '">' + row.guid + '</a></li>';
		});
		r += '</ul>';
		$( '#iewp_crunchstats_report' ).html( r );
	}

	function iewp_crunchstats_report_type_list_404s( data )
	{
		var r = '<ul>';
		jQuery.each(data, function(i, row)
		{
			r += '<li><span class="timestamp">' + row.date + '</span> <a target="_blank" href="' + row.guid + '">' + row.guid + '</a></li>';
		});
		r += '</ul>';
		$( '#iewp_crunchstats_report' ).html( r );
	}

	function iewp_crunchstats_report_graph_day_hour_by_hour( label, data1, data2 )
	{
		var header = '<h2>Hits today: ' + data1[0].hits + '</h2>';
		var w = $( '#iewp_crunchstats_report' ).width();
		$( '#iewp_crunchstats_report' ).html( header + '<canvas id="iewpChart" width="' + w + '" height="400"></canvas>' );
		var ctx = $( '#iewpChart' );

		// Create the labels and data array
		var hours = [];
		var hits = [];

		// Preload the hits
		for (var i = 0; i < 24; i++)
		{
			hits.push(0);
		}

		for (var i = 0; i < 24; i++)
		{
			var hour = i.toString();
			if( hour.length < 2 )
			{
				hour = '0' + hour;
			}

			for (var j = 0; j < data2.length; j++)
			{
				if( data2[j].hour == hour )
				{
					hits[i] = data2[j].total;
				}
			}

			hours.push( hour );
		}

		var chartData =
		{
		    labels: hours,
		    datasets: [
		        {
		            label: label,
		            backgroundColor: "rgba(0,115,170,0.2)",
		            borderColor: "rgba(0,115,170,1)",
		            borderWidth: 1,
		            hoverBackgroundColor: "rgba(0,115,170,0.4)",
		            hoverBorderColor: "rgba(0,115,170,1)",
		            data: hits,
		        }
		    ]
		};

		var options = {
		    scales: {
		        yAxes: [{
		            display: true,
		            ticks: {
		                beginAtZero: true
		            }
		        }]
		    }
		};

		var iewpBarChart = new Chart(ctx,
		{
		    type: 'bar',
		    data: chartData,
			options: options
		});
	}

	function iewp_crunchstats_report_graph_last_X_days( days, label, labels, data1, data2 )
	{
		var header = '<h2>Total hits: ' + data1[0].hits + '</h2>';
		var w = $( '#iewp_crunchstats_report' ).width();
		$( '#iewp_crunchstats_report' ).html( header + '<canvas id="iewpChart" width="' + w + '" height="400"></canvas>' );
		var ctx = $( '#iewpChart' );

		// Create the hitsdata array
		//var hits = [0,0,0,0,0,0,0];
		var hits = [];
		for (var i = 0; i < days; i++)
		{
			hits.push( 0 );
		}

		for (var i = 0; i < labels.length; i++)
		{
			for (var j = 0; j < data2.length; j++)
			{
				if( data2[j].day === labels[i] )
				{
					hits[i] = data2[j].total;
				}
			};
		}

		var chartData =
		{
		    labels: labels,
		    datasets: [
		        {
		            label: label,
		            backgroundColor: "rgba(0,115,170,0.2)",
		            borderColor: "rgba(0,115,170,1)",
		            borderWidth: 1,
		            hoverBackgroundColor: "rgba(0,115,170,0.4)",
		            hoverBorderColor: "rgba(0,115,170,1)",
		            data: hits,
		        }
		    ]
		};

		var options = {
		    scales: {
		        yAxes: [{
		            display: true,
		            ticks: {
		                beginAtZero: true
		            }
		        }]
		    }
		};

		var iewpBarChart = new Chart(ctx,
		{
		    type: 'bar',
		    data: chartData,
			options: options
		});
	}


});
