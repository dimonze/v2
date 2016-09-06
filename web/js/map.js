$(function() {

  if ( $('#gmap').length ) {

    (function initialize() {

      var center = new google.maps.LatLng(55.731387,37.602829);

      var mapOptions = {
        center: center,
        zoom: 15,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        streetViewControl:false,
        mapTypeControl: false,
        scrollwheel: false,
        zoomControl: true
      };
    
      var map = new google.maps.Map(document.getElementById("gmap"),
          mapOptions);

      var marker = new google.maps.Marker({
          position: new google.maps.LatLng(55.732511, 37.600447),
          map: map
      });

      var marker = new google.maps.Marker({
          position: new google.maps.LatLng(55.729962, 37.606477),
          map: map
      });

      var marker = new google.maps.Marker({
          position: new google.maps.LatLng(55.72949, 37.605425),
          map: map
      });

      $(window).resize(function() {
        map.setZoom(map.getZoom());
        map.setCenter(center);
      });
    
    })();

  }

})