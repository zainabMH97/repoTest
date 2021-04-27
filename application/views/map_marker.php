<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Google Maps Multiple Marker(Pins) In Codeigniter - Tutsmake.com</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
	<style>
	.container{
	  padding: 2%;
	  text-align: center;
	 
	 } 
	 #map_wrapper_div {
	  height: 400px;
	}
	 
	#map_tuts {
		width: 100%;
		height: 100%;
	}
	</style>
</head>
<body> 
<div class="container">
  <div class="row">
  <div class="col-12">
   <div class="alert alert-success"><h2>Google Maps Multiple Marker(Pins) In Codeigniter</h2>
   </div>
   <div id="map_wrapper_div">
    <div id="map_tuts"></div>
   </div>
  </div>
</div>
</body>
<script>
$(function($) {
// Asynchronously Load the map API 
var script = document.createElement('script');
script.src = "https://maps.googleapis.com/maps/api/js?sensor=false&amp;callback=initialize";
document.body.appendChild(script);
});
 
function initialize() {
var map;
var bounds = new google.maps.LatLngBounds();
var mapOptions = {
     mapTypeId: 'roadmap'
};
                 
// Display a map on the page
map = new google.maps.Map(document.getElementById("map_tuts"), mapOptions);
map.setTilt(45);
 
// Multiple Markers
var markers = JSON.parse(<?php echo ($markers); ?>);
console.log(markers);
  
 var infoWindowContent = JSON.parse(`<?php echo ($infowindow); ?>`);       
     
// Display multiple markers on a map
var infoWindow = new google.maps.InfoWindow(), marker, i;
 
// Loop through our array of markers &amp; place each one on the map  
for( i = 0; i < markers.length; i++ ) {
    var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
    bounds.extend(position);
    marker = new google.maps.Marker({
        position: position,
        map: map,
        title: markers[i][0]
    });
     
    // Each marker to have an info window    
    google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
            infoWindow.setContent(infoWindowContent[i][0]);
            infoWindow.open(map, marker);
        }
    })(marker, i));
 
    // Automatically center the map fitting all markers on the screen
    map.fitBounds(bounds);
}
 
// Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
    this.setZoom(5);
    google.maps.event.removeListener(boundsListener);
});
 
}
</script>		
</html>