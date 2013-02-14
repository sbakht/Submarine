<!DOCTYPE html>
<html>
  <head>
    <style>
      html, body, #map_canvas { margin: 0; padding: 0; height: 100%; }
    </style>
    <script
      src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=visualization">
    </script>
    <script
  src="http://maps.googleapis.com/maps/api/js?libraries=geometry&sensor=false">
</script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>     
    <script>
      var map;

      function initialize() { //initializes google maps
        var mapOptions = {
          zoom: 13,
          center: new google.maps.LatLng(40.448761, -74.397539),
          mapTypeId: google.maps.MapTypeId.TERRAIN
        };
        map = new google.maps.Map(document.getElementById('map_canvas'),
              mapOptions);
      
        google.maps.event.addListener(map, 'rightclick', function(e) {
          if( document.getElementById("setDestination").checked == true ) { //if the box for setting destination is checked
            var c = confirm("Submarine to travel to: \nLatitude: " + e.latLng.lat() + "\nLongitude: " + e.latLng.lng());
            if(  c == true ) {
              //sends coordinates to gumstix here
            }
          }
        });
      }
      
      function getCircle(magnitude) {
        if(magnitude < 50) {
          var circle = {
            path: google.maps.SymbolPath.CIRCLE,
            fillColor: 'blue',
            fillOpacity: .2,
            scale: magnitude/2,
            strokeColor: 'white',
            strokeWeight: .5
          };
        }else{
          var circle = {
            path: google.maps.SymbolPath.CIRCLE,
            fillColor: 'FFFF00',
            fillOpacity: .2,
            scale: magnitude/2,
            strokeColor: 'white',
            strokeWeight: .5
          };
        }
        return circle;
      }
      
      $(document).ready(function(){
        
        $.ajax({
          type: "GET",
          url: "testdata1.txt", //Reads text file containing lat/longitude and associated temperatures
          success: function(data){
          
            var lines = data.split("|"); //splits file on every new line(changed to | )(every new lat/long/temp combo)
            var heatmapData = [];
            
            for(i = 0; i < lines.length; i++) {
              var splittedline = lines[i].split(" "); //splits on space to seperate lat, long, temp
              latitude = splittedline[0];
              longitude = splittedline[1];
              temperature = splittedline[2];
              var latLng = new google.maps.LatLng(latitude,longitude);
              heatmapData.push(latLng);
              // var heatmap = new google.maps.visualization.HeatmapLayer({
                // data: heatmapData,
                // dissipating: false,
                // map: map
              var marker = new google.maps.Marker({
                position: latLng,
                map: map,
                title: temperature, //shows the temperature when you hover over a circle
                icon: getCircle(temperature)
              });
            }
          }
        });
      });

      


  
      
  </script>
  </head>
  <body onload="initialize()">
  
     <?php
      // $lines = file("testdata.txt");
      // for($i = 0; $i < count($lines); $i++) {
        // $line = explode(" ", $lines[$i]);
        // $latitude = $line[0];
        // $longitude = $line[1];
        // $temperature = $line[2];
        // echo $temperature;
      // }
       ?>
      <input type="checkbox" id="setDestination">Pick Destination Coordinates On Map(right-click)<br>
      <div id="map_canvas"></div>
      <input type="file" id="files" name="files[]" multiple />
      <output id="list"></output>
    
  </body>
</html>