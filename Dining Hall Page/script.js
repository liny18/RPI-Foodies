function initMap(){
  //map options
  var options = {
    zoom: 16,
    center: {lat: 42.7298 , lng: -73.6789}
  }
  //new map
  var map = new google.maps.Map(document.getElementById('map'), options);

  addMarker(map, {lat: 42.7284 , lng: -73.6745}, "<h4>Commons</h4>");
  addMarker(map, {lat: 42.7297 , lng: -73.6781}, "<h4>Sage</h4>");
  addMarker(map, {lat: 42.73116 , lng: -73.68577}, "<h4>Blitman</h4>");
  addMarker(map, {lat: 42.73105 , lng: -73.67124}, "<h4>BarH</h4>");
  // //markers
  // var marker = new google.maps.Marker({
  //   position: {lat: 42.7284 , lng: -73.6745},
  //   map: map
  // });

  // var infoWindow = new google.maps.InfoWindow({
  //   content:'<p>Commmons Dining Hall</p>'
  // })

  // marker.addListener('click', function(){
  //   infoWindow.open(map, marker);
  // })


}

function addMarker(map, coords, title){
  var marker = new google.maps.Marker({
    position: coords,
    map: map
  });

  var infoWindow = new google.maps.InfoWindow({
    content: title
  })

  marker.addListener('click', function(){
    infoWindow.open(map, marker);
  })
}