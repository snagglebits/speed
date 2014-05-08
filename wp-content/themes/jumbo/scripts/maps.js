  var geocoder;
  var map;

  function mapsinitialize() {
	geocoder = new google.maps.Geocoder();
	if(document.getElementById("map") && jQuery("#map").attr("data-latlong")){
		var uselatlong = jQuery("#map").attr("data-latlong");
		var temp = new Array();
		latlong = uselatlong.split(",");
		latitude = latlong[0];
		longitude = latlong[1];
	}
	else {var latitude = "-34.397"; var longitude = "150.644";}
	var latlng = new google.maps.LatLng(latitude, longitude);
	var myOptions = {
	  zoom: +mapsettings.zoomlevel,
	  center: latlng,
	  mapTypeId: google.maps.MapTypeId.ROADMAP
	}
	if(document.getElementById("map")){
		var address = jQuery("#map").attr("rel");
		map = new google.maps.Map(document.getElementById("map"), myOptions);
		codeAddress(address);
	}
  }

	function codeAddress(address) {
		geocoder.geocode( { 'address': address}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				map.setCenter(results[0].geometry.location);
				var marker = new google.maps.Marker({
					map: map,
					position: results[0].geometry.location
				});
			} else {}
		});
	}


jQuery(document).ready(function()
	{
		mapsinitialize();
		jQuery("#nearby a").click(function(){
			var address = jQuery(this).attr("rel");
			codeAddress(address);
			return false;
		});
	});
