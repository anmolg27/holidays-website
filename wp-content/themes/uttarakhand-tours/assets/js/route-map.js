document.addEventListener( 'DOMContentLoaded', function () {
	var container = document.getElementById( 'package-route-map' );

	if ( ! container || typeof L === 'undefined' ) {
		return;
	}

	var stops = JSON.parse( container.dataset.routeStops || '[]' );

	if ( ! stops.length ) {
		return;
	}

	var map = L.map( container );

	L.tileLayer( 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
		maxZoom: 18,
	} ).addTo( map );

	var latLngs = stops.map( function ( stop ) {
		return [ stop.lat, stop.lng ];
	} );

	stops.forEach( function ( stop ) {
		L.marker( [ stop.lat, stop.lng ] ).addTo( map ).bindPopup( stop.name );
	} );

	L.polyline( latLngs, { color: '#1a73e8' } ).addTo( map );

	map.fitBounds( latLngs );
} );
