var currentMap;
var lastDone;


jQuery(document).ready(function($){

	var mapOptions = {
      center: new google.maps.LatLng(3.36942,-76.53497),
      zoom: 16
    };

    currentMap = new google.maps.Map(document.getElementById("gmap"),mapOptions);


    if ( !geoPosition.init() ) {
		$('#myLocation').parent().addClass('disabled');
    }

    $('#myLocation').click(function (e) {

		if( $('#myLocation').parent().hasClass('active')) {
			errorLocation();
		} else {
			if ( geoPosition.init() ){
				blockContent();
				geoPosition.getCurrentPosition(sucessLocation,errorLocation,{enableHighAccuracy: true, timeout : 30000});
			}else{
				alert("Geolocation is not supported or not allowed");
				errorLocation();
			}
		}

		$('#myLocation').parent().toggleClass('active');

		e.preventDefault();
    });
    
    errorLocation();

	function sucessLocation( location ) {
		// fill the data
		$('#PlacesLatitude').val(location.coords.latitude);
		$('#PlacesLongitude').val(location.coords.longitude);
		$('#PlacesSort').val('relevance');
		// load Recomended
		unBlockContent();
		if ( lastDone == 'search' ) {
			$("#PlacesIndexForm").submit();
		} else {
			load_recomended();
		}
	}

	function errorLocation ( error ) {
		// Continue
		$('#PlacesLatitude').val('3.36942');
		$('#PlacesLongitude').val('-76.53497');
		$('#PlacesSort').val('relevance');
		// load Recomended
		unBlockContent();
		if ( lastDone == 'search' ) {
			$("#PlacesIndexForm").submit();
		} else {
			load_recomended();
		}
	}

	$("#PlacesIndexForm").submit(function (event) {
		lastDone = 'search';
		$.ajax({
			dataType: 'json',
			data: $(this).serialize(),
			url: nearUrl,
			beforeSend: function (e) {
				// body...
				$('#venue-list-title').html('Loading...');
				$('#venue-list').html('');
				blockContent();
			},
			success:function ( data, textStatus, jqXHR ) {
				// build data
				$('#venue-list-title').html('Results for: "' + $('#PlacesQ').val() + '"' );
				show_venues(data);
				unBlockContent();
			},
			error: function ( jqXHR, textStatus, errorMessage ) {
				// show error message
				unBlockContent();
			}
		});

		event.preventDefault();
	});

	$('#showExplorer').click(function (e) {
		e.preventDefault();
		load_recomended();
	});

	function load_recomended () {
		//alert ( 'Starting load_recomended' );
		lastDone = 'recomended';
		$.ajax({
			dataType: 'json',
			data: $("#PlacesIndexForm").serialize(),
			url: exploreUrl,
			beforeSend: function (e) {
				// body...
				$('#venue-list-title').html('Loading...');
				$('#venue-list').html('');
				blockContent();
			},
			success:function ( data, textStatus, jqXHR ) {
				// build data
				$('#venue-list-title').html('Recomended places');
				show_venues(data);
				unBlockContent();
			},
			error: function ( jqXHR, textStatus, errorMessage ) {
				// show error message
				unBlockContent();
			}
		});
	}

	var markers = [];
	var markersIds = [];

	function show_venues (data) {
		var bounds = data.suggestedBounds;
		var items = data.groups[0].items;

		for (var i = 0; i < markers.length; i++) {
			markers[i].setMap(null);
		}
		markers = [];
		markersIds = [];

		if (items.length === 0) return;

		//var gmBound = new google.maps.LatLngBounds( new google.maps.LatLng(bounds.sw.lat, bounds.sw.lng), new google.maps.LatLng(bounds.ne.lat, bounds.ne.lng));
		//currentMap.fitBounds(gmBound);

		var source   = $("#venue-list-template").html();
		var template = Handlebars.compile(source);

		$('#venue-list').html('');

		var gmBound = new google.maps.LatLngBounds();
		
		for ( i = 0; i < items.length; i++) {
			// To add the marker to the map, use the 'map' property
			var m = createMarker(items[i].venue);
			markers.push(m);
			markersIds.push(items[i].venue.id);
			gmBound.extend(m.getPosition());

			// Paint mark 
			var itemHtml = $(template(items[i].venue));
			itemHtml.bind('click', clickListItem );
			itemHtml.bind('mouseenter', overListItem);
			itemHtml.bind('mouseleave', outListItem);

			$('#venue-list').append(itemHtml);
		}

		currentMap.fitBounds(gmBound);
	}

	function clickListItem (e) {
		// body...
		openVenue($(this).data('venue'));
		e.preventDefault();
	}

	var overItem;

	function overListItem (e) {
		overItem = $(this).data('venue');

		var m = markers[markersIds.indexOf(overItem)];

		if (m.getAnimation() === null) {
			m.setAnimation(google.maps.Animation.BOUNCE);
		}
	}

	function outListItem (e) {
		markers[markersIds.indexOf(overItem)].setAnimation(null);
	}

	function createMarker(venue) {
		var venueLatlng = new google.maps.LatLng(venue.location.lat, venue.location.lng );
		var marker = new google.maps.Marker({
			position: venueLatlng,
			map: currentMap,
			title:name
		});

		google.maps.event.addListener(marker, 'mouseover', function(e){
			$('#venue-list a.hover').removeClass('hover');
			$("#venue_"+venue.id).addClass('hover');
		});

		google.maps.event.addListener(marker, 'mouseout', function(e){
			$('#venue-list a.hover').removeClass('hover');
		});

		google.maps.event.addListener(marker, 'click', function(e){
			openVenue(venue.id);
			$('#venue-list a.hover').removeClass('hover');
		});

		return marker;
	}

	function openVenue (id) {

		$.ajax({
			url: viewUrl+"/"+id,
			beforeSend: function (e) {
				blockContent();
			},
			success:function ( data, textStatus, jqXHR ) {
				$('#venue-info .modal-body').html(data);
				$('.cat-list img').tooltip();
				$('#venue-info').modal('show');
				unBlockContent();
			},
			error: function ( jqXHR, textStatus, errorMessage ) {
				// show error message
				unBlockContent();
			}
		});

	}

	function blockContent() {
		$("body").prepend("<div class='divBlockContent'></div>");
	}

	function unBlockContent() {
		$(".divBlockContent").remove();
	}

});