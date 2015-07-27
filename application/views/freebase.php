<html>
<head>
	<title></title>
	<link type="text/css" rel="stylesheet" href="https://www.gstatic.com/freebase/suggest/4_1/suggest.min.css" />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js"></script>
	<script type="text/javascript" src="https://www.gstatic.com/freebase/suggest/4_1/suggest.min.js"></script>
</head>
<body>

<input type="text" id="myinput"/>
	
<div id="artist"></div>
<div id="video"></div>

<script type="text/javascript">
$(function() {
  $("#myinput").suggest(
  	{
  		filter	:'(all type:/music/recording)',
  		key 	: "AIzaSyC1TDNEigM5Ufze11g5UpWNSiOQAdu7YdM",
  		lang 	: 'fr'
  	})
	.bind("fb-select", function(e, data) {

			var topic_id = data.mid;
			var service_url = 'https://www.googleapis.com/freebase/v1/topic';
			var params = {
					key 	: "AIzaSyC1TDNEigM5Ufze11g5UpWNSiOQAdu7YdM",
  					lang 	: 'fr'
				};
			$.getJSON(service_url + topic_id + '?callback=?', params, function(topic) {
				var artist 	= topic.property['/music/recording/artist'].values[0].text;
				var url 	= topic.property['/common/topic/topical_webpage'].values[0].text;



				$('#artist').empty().append(artist);
				$('#video').empty().html("<iframe width='420' height='315' src='"+ url +"' frameborder='0' allowfullscreen>></iframe>");
			});
	});
});
</script>



</body>
</html>