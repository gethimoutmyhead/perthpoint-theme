jQuery(document).ready(function(){
 //jQuery("#test-script").html("jQuery says Hello World");
 	var AddressToSearchBar = document.getElementById('searchaddress');
 	if (AddressToSearchBar){
 	//searchBar.value = "Cheese";
		var autocomplete = new google.maps.places.Autocomplete (AddressToSearchBar);
		jQuery('#findAddressForm').submit(function (){
			//alert ("hi");
			getAddress();
			return false;
		});
		jQuery('#findmyGPS').click(function (){
			//alert ("hi");
			getLocation();
			return false;
		});

	};
	var hostAddressBar = document.getElementById('pods-form-ui-pods-field-location');
	if (hostAddressBar){
		var autocomplete = new google.maps.places.Autocomplete (hostAddressBar);
	}

	
	//$('#searchForm').submit(function (){
		//getAddress();
		//return false;
	//});
});


function getAddress(){
//this function looks up the address typed on google maps, finds the closest coordinate, and then submits the form
	var geocoder = new google.maps.Geocoder();
	address = jQuery("#searchaddress").val();
   if (geocoder) {
      geocoder.geocode({ 'address': address, 'region': 'au' }, function (results, status) {
         if (status === google.maps.GeocoderStatus.OK) {
            //searchAddress = results[0].formatted_address;
            jQuery("#searchaddress").val(results[0].formatted_address);
            searchAddress = (results[0].formatted_address).replace(" ", "+");
            searchLat = results[0].geometry.location.lat();
            searchLong = results[0].geometry.location.lng();
            window.location = window.location.href.split('?')[0] + "?lat=" + searchLat + "&lon=" + searchLong + "&addr=" + searchAddress;
            //getDirectoryList();
         }
         else {
            alert("Geocoding failed: " + status);
         }
      });
   }
}
function getLocation() {
// this function will first determine if GPS is supported, then it will find your latitude and longitude, and save it to searchLat, searchLong
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else { 
        alert("Geolocation is not supported by this browser.");
       }
}
    
function showPosition(position) {
// a GPS location has been found. this function will save the coordinates and then get a new record list ordered by distance
    alert("Latitude: " + position.coords.latitude + 
    "<br>Longitude: " + position.coords.longitude + "<br>");	
    searchLat = position.coords.latitude;
    searchLong = position.coords.longitude;
    window.location = window.location.href.split('?')[0] + "?lat=" + searchLat + "&lon=" + searchLong;
 
    

    //https://maps.googleapis.com/maps/api/geocode/json?latlng=40.714224,-73.961452&key=AIzaSyDWnGVLjU3bQ1FS24kR_wBKCMN2d2o3ltI
    //getDirectoryList();
}


