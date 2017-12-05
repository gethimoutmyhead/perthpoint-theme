jQuery(document).ready(function(){
	var adminLocationBar = document.getElementById('pods-form-ui-pods-meta-location');
	if (adminLocationBar){
		var autocomplete = new google.maps.places.Autocomplete (adminLocationBar);
	}
})
