var map = new GMaps({
	el: '#map',
    lat: 18,
    lng: 70,
    zoom: 16,
})

$(document).ready(function(){
  var lat = $('#lat').text();
  var lng = $('#long').text();
  lat = parseFloat(lat);
  lng = parseFloat(lng);
  console.log(lat);
  map.addMarker({
      lat: lat,
      lng: lng,
    });
  map.setCenter(lat, lng);
});
   
