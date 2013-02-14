
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Google Maps JavaScript API v3 Example: Heatmap Layer</title>
    <link href="https://developers.google.com/maps/documentation/javascript/examples/default.css" rel="stylesheet">
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=visualization"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>     
    
    <?php
    $r = 1;
    $numSub = 3; //Number of submarines data you have

    
    for($i = 0; $i < $numSub; $i++) {
      $sub[$i] = file_get_contents("testdata".($i+1).".txt");
    }
    //echo $lol;
    // function escapeJavaScriptText($string)
// {
    // return str_replace("\n", '\n', str_replace('"', '\"', addcslashes(str_replace("\r", '', (string)$string), "\0..\37'\\")));
// }
    // $loler = escapeJavaScriptText($lol);
    ?>
    <script>
      // Adding 500 Data Points
      var map, pointarray;
      var heatmap = [];
      var heatmapData = [];
      // var heatmapData2 = [];
      // var latitude, longitude, temperature;
      
      var numSub = "<?php echo $numSub ?>";
        
      sub = <?php echo json_encode($sub[0]); ?>; //impossible to loop, have to repeat manually for multiple submarines
      createHeatData(sub, 0);
      
      sub = <?php echo json_encode($sub[1]); ?>;
      createHeatData(sub, 1);
      
      sub = <?php echo json_encode($sub[2]); ?>;
      createHeatData(sub, 2);
     
      // $.ajax({
        // type: "GET",
        // url: "testdata.txt", //Reads text file containing lat/longitude and associated temperatures
        // success: function(data){
          // alert("YES");
          // var lines = data.split("\n"); //splits file on every new line(every new lat/long/temp combo)
          // for(i = 0; i < lines.length; i++) {
            // var splittedline = lines[i].split(" "); //splits on space to seperate lat, long, temp
            // latitude = (splittedline[0]); //might need float
            // longitude = (splittedline[1]);
            // temperature = parseFloat(splittedline[2]);
            // var derp = {
              // location: new google.maps.LatLng(latitude,longitude),
              // weight: temperature
            // };
            // derp = new google.maps.LatLng(latitude,longitude);
            // heatmapData.push(derp);
          // }
          // console.log(heatmapData);

         // }
      // });
                       // heatmapData.push(
       // {location: new google.maps.LatLng(40.443047, -74.366293), weight: 54.7141146763},
       // {location: new google.maps.LatLng(40.443057, -74.366293), weight: 54.7141146763},
       // {location: new google.maps.LatLng(40.444057, -74.366293), weight: 54.7141146763}
       // );

     
    //console.log(heatmapData);
      function initialize() {
        var mapOptions = {
          zoom: 13,
          center: new google.maps.LatLng(40.420824, -74.391319),
          mapTypeId: google.maps.MapTypeId.SATELLITE
        };

        map = new google.maps.Map(document.getElementById('map_canvas'),
            mapOptions);

        for(i = 0; i < numSub; i++) {
          heatmap[i] = new google.maps.visualization.HeatmapLayer({
            data: heatmapData[i]
          });

          heatmap[i].setMap(map);
        }
      }
      
      function createHeatData(data, subnum) {
        var lines = data.split("|");
        heatData = [];
        for(i = 0; i < lines.length; i++) {
          var splittedline = lines[i].split(" "); //splits on space to seperate lat, long, temp
          latitude = parseFloat(splittedline[0]); //might need float
          longitude = parseFloat(splittedline[1]);
          temperature = parseFloat(splittedline[2]);
          var derp = {
              location: new google.maps.LatLng(latitude,longitude),
              weight: temperature
            };
          heatData.push(derp)
        }
        heatmapData[subnum] = heatData;
      }

      function toggleHeatmap(subNum) {
        heatmap[subNum].setMap(heatmap[subNum].getMap() ? null : map);
      }

      function changeGradient() {
        var gradient = [
          'rgba(0, 255, 255, 0)',
          'rgba(0, 255, 255, 1)',
          'rgba(0, 191, 255, 1)',
          'rgba(0, 127, 255, 1)',
          'rgba(0, 63, 255, 1)',
          'rgba(0, 0, 255, 1)',
          'rgba(0, 0, 223, 1)',
          'rgba(0, 0, 191, 1)',
          'rgba(0, 0, 159, 1)',
          'rgba(0, 0, 127, 1)',
          'rgba(63, 0, 91, 1)',
          'rgba(127, 0, 63, 1)',
          'rgba(191, 0, 31, 1)',
          'rgba(255, 0, 0, 1)'
        ]
        heatmap.setOptions({
          gradient: heatmap.get('gradient') ? null : gradient
        });
      }

      function changeRadius() {
        heatmap.setOptions({radius: heatmap.get('radius') ? null : 20});
      }

      function changeOpacity() {
        heatmap.setOptions({opacity: heatmap.get('opacity') ? null : 0.2});
      }
    </script>
  </head>

  <body onload="initialize()">
    <?php
      for($i = 0; $i < $numSub; $i++) {
        echo "<input type=checkbox checked=on onclick=toggleHeatmap(".$i.")>Toggle Submarine ".($i + 1)." Data</input><br>";
      }
    ?>
    <div id="map_canvas" style="height: 600px; width: 800px;"></div>
    <button onclick="toggleHeatmap()">Toggle 1st Submarine Data</button>
    <button onclick="toggleHeatmap2()">Toggle 2nd Submarine Data</button>
    <button onclick="changeGradient()">Change gradient</button>
    <button onclick="changeRadius()">Change radius</button>
    <button onclick="changeOpacity()">Change opacity</button>
    <br>
  </body>
</html>
