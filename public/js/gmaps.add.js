var map = new GMaps({
	el: '#map',
    lat: 18,
    lng: 70,
    zoom: 12,
})

GMaps.geocode({
	address: 'Santo Domingo',
    callback: function(results, status) {
   		if (status == 'OK') {
      		var latlng = results[0].geometry.location;
          var lat = latlng.lat();
          var lng = latlng.lng();
          if($('#lat').val()){
            lat = $('#lat').val();
          }
          if($('#long').val()){
            lng = $('#long').val();
          }
        	map.setCenter(lat, lng);
    	}
	}
});

$(document).ready(function(){
  var lat = $('#lat').val();
  var lng = $('#long').val();
  if(lat != '' && lng != ''){
    map.setZoom(16);
  }
  map.addMarker({
      lat: lat,
      lng: lng,
    });
  GMaps.on('click', map.map, function(event) {
    var index = map.markers.length;
    var lat = event.latLng.lat();
    var lng = event.latLng.lng();

    $('#lat').val(lat);
    $('#long').val(lng);
    map.removeMarkers();
    map.addMarker({
      lat: lat,
      lng: lng,
    });
  });
});
   
