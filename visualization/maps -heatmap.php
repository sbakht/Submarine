<!DOCTYPE html>
<html>
  <head>
    <style>
      html, body, #map_canvas { margin: 0; padding: 0; height: 100%; }
    </style>
    <script
      src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=visualization">
    </script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>     
    <script>
      var map;

      function initialize() { //initializes google maps
        var mapOptions = {
          zoom: 15,
          center: new google.maps.LatLng(40.453023, -74.388193),
          mapTypeId: google.maps.MapTypeId.SATELLITE
        };
        map = new google.maps.Map(document.getElementById('map_canvas'),
              mapOptions);

      }
      

      $(document).ready(function(){
 
        $.ajax({
          type: "GET",
          url: "testdata1.txt", //Reads text file containing lat/longitude and associated temperatures
          success: function(data){
            var lines = data.split("\n"); //splits file on every new line(every new lat/long/temp combo)
            var heatmapData = [];
            x = 1;
            for(i = 0; i < lines.length; i++) {
              var splittedline = lines[i].split(" "); //splits on space to seperate lat, long, temp
              latitude = splittedline[0];
              longitude = splittedline[1];
              temperature = parseFloat(splittedline[2]);
              var latLng = new google.maps.LatLng(latitude,longitude);
              
              var weightedLoc = {
                location: latLng,
                weight: temperature/10.0
              };
            }
            heatmapData.push(weightedLoc);
            var heatmap = new google.maps.visualization.HeatmapLayer({
              data: heatmapData,
              dissipating: false,
              radius: 5,
              map: map
            });
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
        //echo $temperature;
      // }
      ?>
      <div id="target"></div>
      <div id="map_canvas"></div>
      <input type="file" id="files" name="files[]" multiple />
      <output id="list"></output>
    
  </body>
</html>