jQuery(document).ready(function($)
{

	// Get the API key and site URL, set endpoint root
	var apikey = $( '#iewp_crunchstats' ).data( 'apikey' );
	var site_url = $( '#iewp_crunchstats' ).data( 'site-url' );
	var endpoint = site_url + '/wp-json/iewp_crunchstats/';

	// Referer select
	$( document ).on( 'click', '.iewp-referer', function( e )
	{
		e.preventDefault();
		var id = $( this ).data( 'id' );
		$( '#iewp-ref-info-' + id ).toggle();
	});

	// Referer blacklist
	$( document ).on( 'click', '.iewp-ref-blacklist', function( e )
	{
		e.preventDefault();
		var id = $( this ).data( 'id' );
		$( '#iewp-ref-' + id + ' .iewp-refer-body' ).hide();
		var confirm = '<div id="iewp-confirm-blacklist-' + id + '" class="iewp-blacklist-confirm">Are you sure you want to blacklist this referer?'
		confirm += '<span class="iewp-blacklist-confirm-options"><a data-id="' + id + '" class="iewp-cancel-blacklist" href="#">cancel</a> | ';
		confirm +='<a data-id="' + id + '" class="iewp-confirm-blacklist" href="#">confirm</a>';
		confirm += '</span></div>';
		$( '#iewp-ref-' + id ).append( confirm );
	});

	// Referer blacklist - do blacklisting
	$( document ).on( 'click', '.iewp-confirm-blacklist', function( e )
	{
		e.preventDefault();
		var id = $( this ).data( 'id' );
		$( '#iewp-ref-' + id ).html( '<span class="iewp-blacklisted"><img src="/wp-includes/images/spinner.gif"> blacklisting referer ...</span>' );
		var data = {
			id: id,
			apikey: apikey,
			action: 'insert'
		};

		$.ajax({
			url: endpoint + 'referer_blacklist',
			type: 'GET',
			dataType: 'json',
			data: data
		})
		.done(function( data ) {
			// Handle any errors
			if( data.Error !== undefined )
			{
				$( '#iewp-ref-' + id ).html( '<span class="iewp-blacklisted">Error: ' + data.Error + ' :(</span>' );
				return;
			}
			// Perform maintenance and remove item from list
			$.ajax({
				url: endpoint + 'maintenance',
				type: 'GET',
				dataType: 'json',
				data: {apikey: apikey}
			})
			.done(function() {
				$( '#iewp-ref-' + id ).addClass( 'notify' );
				$( '#iewp-ref-' + id ).html( '<span class="iewp-blacklisted">Referer added to blacklist!</span>' );
				setTimeout(function()
				{
					$( '#iewp-ref-' + id ).fadeOut(500, function()
					{
						$( this ).remove();
					});
				}, 2000);
			})
			.fail(function() {
				console.log('Error running iewp_crunchstats maintenance AJAX call');
			});
		})
		.fail(function() {
			console.log( 'Failed to insert blacklisted referer' );
		});
	});

	// Referer blacklist - cancel blacklisting
	$( document ).on( 'click', '.iewp-cancel-blacklist', function( e )
	{
		e.preventDefault();
		var id = $( this ).data( 'id' );
		$( '#iewp-ref-' + id + ' .iewp-refer-body' ).show();
		$( '#iewp-confirm-blacklist-' + id ).remove();
	});

});
