/* Javascript elements for the respiteLocation function */

// Gets a user's location and draws it on a map.
// Uses Google's non-registered API

if (navigator.geolocation) {
  navigator.geolocation.getCurrentPosition(function(position) { 
	  showLocation(position.coords.latitude, position.coords.longitude);
  }); 
}else{
  var key = "your_key";
  var script = "http://www.google.com/jsapi?key=" + key;
  $.getScript(script, function(){
    if ((typeof google == 'object') &&
       google.loader && google.loader.ClientLocation) { 
         showLocation(google.loader.ClientLocation.latitude, 
                    google.loader.ClientLocation.longitude);
     }else{
       var message = $("<p>Couldn't find your address.</p>"); 
       message.insertAfter("#map");
     };
  });        
};


var showLocation = function(lat, lng){
  var fragment = "&markers=color:red|color:red|label:Y|" + lat + "," + lng;
  var image = $("#map");      
  var source = image.attr("src") + fragment;
  source = source.replace("sensor=false", "sensor=true");
  image.attr("src", source);
};


