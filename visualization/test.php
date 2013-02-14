<html>
<head>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<title>heatmap.js GMaps Heatmap Layer</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<style>
			body, html {
				margin:0;
				padding:0;
				font-family:Arial;
			}
			h1 {
				margin-bottom:10px;
			}
			#main {
				position:relative;
				width:1020px;
				padding:20px;
				margin:auto;
			}
			#heatmapArea {
				position:relative;
				float:left;
				width:800px;
				height:600px;
				border:1px dashed black;
			}
			#configArea {
				position:relative;
				float:left;
				width:200px;
				padding:15px;
				padding-top:0;
				padding-right:0;
			}
			.btn {
				margin-top:25px;
				padding:10px 20px 10px 20px;
				-moz-border-radius:15px;
				-o-border-radius:15px;
				-webkit-border-radius:15px;
				border-radius:15px;
				border:2px solid black;
				cursor:pointer;
				color:white;
				background-color:black;
			}
			#gen:hover{
				background-color:grey;
				color:black;
			}
			textarea{
				width:260px;
				padding:10px;
				height:200px;
			}
			h2{
				margin-top:0;
			}
		</style>
<link rel="shortcut icon" type="image/png" href="http://www.patrick-wied.at/img/favicon.png" />
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

</head>
<body>
<div id="main">
			<h1>GMaps Heatmap Overlay</h1>
			<a href="http://www.patrick-wied.at/static/heatmapjs/" title="heatmap.js">Back to the project page</a><br /><br />
			<div id="heatmapArea">
			
			</div>
			<div id="configArea">
				<h2>Sidenotes</h2>
				This is a demonstration of a canvas heatmap gmaps overlay<br /><br />
				<strong>Note: this is an early release of the heatmap layer. Please feel free to <a href="https://github.com/pa7/heatmap.js" target="_blank">contribute patches</a>. (e.g: correct datapoint pixels after dragrelease (in draw))</strong>
				<div id="tog" class="btn">Toggle HeatmapOverlay</div>
				<div id="gen" class="btn">Add 5 random lat/lng coordinates</div>
			</div>
			
<div style="position:absolute;width:940px;top:750px;text-align:center;"><a href="http://www.patrick-wied.at/static/heatmapjs/">heatmap.js</a> by <a href="http://www.patrick-wied.at" target="_blank">Patrick Wied</a></div>

</div>
<script type="text/javascript" src="heatmap.js"></script>
<script type="text/javascript" src="heatmap-gmaps.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>     

<script>

var map;
var heatmap; 


	var myLatlng = new google.maps.LatLng(41.438212, -74.390602);
	// sorry - this demo is a beta
	// there is lots of work todo
	// but I don't have enough time for eg redrawing on dragrelease right now
	var myOptions = {
	  zoom: 13,
	  center: myLatlng,
	  mapTypeId: google.maps.MapTypeId.ROADMAP,
	  disableDefaultUI: false,
	  scrollwheel: true,
	  draggable: true,
	  navigationControl: true,
	  mapTypeControl: false,
	  scaleControl: true,
	  disableDoubleClickZoom: false
	};
	map = new google.maps.Map(document.getElementById("heatmapArea"), myOptions);
	
	heatmap = new HeatmapOverlay(map, {"radius":15, "visible":true, "opacity":60});

    $("#gen").click(function worker() {
                  heatmap.addDataPoint(41.438212, -74.390602,10);
        $.ajax({
          type: "GET",
          url: "testdata1.txt", //Reads text file containing lat/longitude and associated temperatures
          success: function(data){
            alert("YES");
            var lines = data.split("\n"); //splits file on every new line(every new lat/long/temp combo)
            var heatmapData = [];
            for(i = 0; i < lines.length; i++) {
              var splittedline = lines[i].split(" "); //splits on space to seperate lat, long, temp
              latitude = splittedline[0];
              longitude = splittedline[1];
              temperature = splittedline[2];
              var derp = {
                lat: latitude,
                lng: longitude,
                count: temperature
              };
              heatmapData.push(derp);
               heatmap.addDataPoint(latitude,longitude,temperature);
              // var latLng = new google.maps.LatLng(latitude,longitude);
            }
            var testData={
                  max: 46,
                  data: heatmapData
                };
                herp(heatmapData);
                console.log(heatmapData);
                }
        });
       });
       
			
	

	
	document.getElementById("tog").onclick = function(){
		heatmap.toggle();
	};
	
    
	
	// this is important, because if you set the data set too early, the latlng/pixel projection doesn't work
	// google.maps.event.addListenerOnce(map, "idle", function(){
		// heatmap.setDataSet(testData);
	// });
  
  $("h1").click(function() {
      // worker();
      
      alert(map.getZoom());
  		heatmap.setDataSet(tester);
});

 
  function herp(tester) {
  		heatmap.setDataSet(tester);
}

  

</script>
</body>
</html>