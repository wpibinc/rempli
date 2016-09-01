var geocoder;
var map;
var components={};
var okplace = 0;
function initialize() {


  var markers = [];
  map = new google.maps.Map(document.getElementById('map-canvas'), {
    mapTypeId: google.maps.MapTypeId.ROADMAP
  });

   var defaultPlace = new google.maps.LatLng(55.753854, 37.623539);
   var options = {
    types: ['address'],
    location: defaultPlace,
    radius: 3000,
    // componentRestrictions: {country: "ru"}
   };
   
  // Create the search box and link it to the UI element.
  var input = document.getElementById('pac-input');

  
  // autocomplete.setTypes(["address"]);
  
  var autocomplete = new google.maps.places.Autocomplete(input, options);
  // var searchBox = new google.maps.places.SearchBox(input, options);


autocomplete.addListener('place_changed', function() {
  codeAddress();
});
  // google.maps.event.addListener(autocomplete, 'places_changed', function() {
  //   // var place = searchBox.getPlaces()[0];

   
  //   // if (!place.geometry) return;

  //   // // If the place has a geometry, then present it on a map.
  //   // if (place.geometry.viewport) {
  //   //   map.fitBounds(place.geometry.viewport);
  //   // } else {
  //   //   map.setCenter(place.geometry.location);
  //   //   map.setZoom(17);
  //   // }
  //   codeAddress();
  // });

// $( "#pac-input" ).change(function() {
//   codeAddress();
// });

  // Bias the SearchBox results towards places that are within the bounds of the
  // current map's viewport.
  // google.maps.event.addListener(map, 'bounds_changed', function() {
  //   var bounds = map.getBounds();
  //   searchBox.setBounds(bounds);
  // });



  geocoder = new google.maps.Geocoder();
  var latlng = new google.maps.LatLng(55.668495, 37.280803);
  var mapOptions = {
    zoom: 16,
    disableDefaultUI: true,
    center: latlng
  }
  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
}



function codeAddress() {
  var address = document.getElementById('pac-input').value;
  geocoder.geocode( { 'address': address}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      map.setCenter(results[0].geometry.location);
      var marker = new google.maps.Marker({
          map: map,
          position: results[0].geometry.location
      });
      // console.log(results[0].geometry.location.lat());
      // 55.753854, 37.623539
      var enteredloc = new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng());
      var centerloc = new google.maps.LatLng(55.753854, 37.623539);
      // console.log(google.maps.geometry.spherical.computeDistanceBetween(enteredloc, centerloc));
      if( google.maps.geometry.spherical.computeDistanceBetween(enteredloc, centerloc) < 6000 )  {
                $( ".wrongplace" ).css( "display", "none" );
                okplace = 1;
            }
            else {
                $( ".wrongplace" ).css( "display", "block" );
                okplace = 0;
            }
    } else {
      // alert('Пожалуйста, введите свой адрес сверху страницы и нажмите Enter');
    }
  });
}



google.maps.event.addDomListener(window, 'load', initialize);