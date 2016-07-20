var map = new GMaps({
	el: '#map',
    lat: 18,
    lng: 70,
    zoom: 12,
})

var n = 0;
$(document).ready(function(){
  updateMap();
  $( "input[type=checkbox]" ).on( "change", updateMap );
});

function calculateAndShowArea(){
  if(!$('#calculate').attr('disabled')){
    var path = [];
    for(var i = 0; i < map.markers.length; i++){
      path.push([map.markers[i].position.lat(),map.markers[i].position.lng()]);
    }
    console.log(path);
    polygon = map.drawPolygon({
      paths: path, // pre-defined polygon shape
      strokeColor: '#BBD8E9',
      strokeOpacity: 1,
      strokeWeight: 3,
      fillColor: '#BBD8E9',
      fillOpacity: 0.6
    });
    setTimeout(function(){ 
      var area = google.maps.geometry.spherical.computeArea(polygon.getPath());
      area = (area/1000000).toFixed(3);
      var center = polygonCenter(polygon);
      map.drawOverlay({
        lat: center.lat(),
        lng: center.lng(),
        content: '<div style="font-size:200%; color:black;">'+area+'km2</div>'
      });
    }, 50);
  }
}

function updateMap(){
  
  map.removeMarkers();
  map.removePolygons();
  map.removeOverlays();
  n = 0;
  $('#businesses-table > tbody  > tr').each(function() {
    if($(this).find('td').eq(4).find('#check').is(':checked')){
      var lat = $(this).find('td').eq(1).text();
      var lng = $(this).find('td').eq(2).text();
      var title = $(this).find('td').eq(0).text();
      map.addMarker({
          lat: lat,
          lng: lng,
          title: title,
      });
      n++;
    }
  });
  if(n >= 3){
    $("#calculate").attr('disabled',false);
  }
  else{
    $("#calculate").attr('disabled',true);
  }
  if(n === 0){
    GMaps.geocode({
    address: 'Santo Domingo',
      callback: function(results, status) {
        if (status == 'OK') {
            var latlng = results[0].geometry.location;
            map.setCenter(latlng.lat(), latlng.lng());
            map.setZoom(12);
        }
      }
    });
  }
  else{
    map.fitZoom();
  }
}

function polygonCenter(poly) {
    var lowx,
        highx,
        lowy,
        highy,
        lats = [],
        lngs = [],
        vertices = poly.getPath();

    for(var i=0; i<vertices.length; i++) {
      lngs.push(vertices.getAt(i).lng());
      lats.push(vertices.getAt(i).lat());
    }

    lats.sort();
    lngs.sort();
    lowx = lats[0];
    highx = lats[vertices.length - 1];
    lowy = lngs[0];
    highy = lngs[vertices.length - 1];
    center_x = lowx + ((highx-lowx) / 2);
    center_y = lowy + ((highy - lowy) / 2);
    return (new google.maps.LatLng(center_x, center_y));
  }
