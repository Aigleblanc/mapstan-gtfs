var map_stats;
var heatmap; 

function initialize_stats() {
	var style_map  = [{"featureType":"water","stylers":[{"saturation":43},{"lightness":-11},{"hue":"#0088ff"}]},{"featureType":"road","elementType":"geometry.fill","stylers":[{"hue":"#ff0000"},{"saturation":-100},{"lightness":99}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"color":"#808080"},{"lightness":54}]},{"featureType":"landscape.man_made","elementType":"geometry.fill","stylers":[{"color":"#ece2d9"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"color":"#ccdca1"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#767676"}]},{"featureType":"road","elementType":"labels.text.stroke","stylers":[{"color":"#ffffff"}]},{"featureType":"poi","stylers":[{"visibility":"off"}]},{"featureType":"landscape.natural","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#b8cb93"}]},{"featureType":"poi.park","stylers":[{"visibility":"on"}]},{"featureType":"poi.sports_complex","stylers":[{"visibility":"on"}]},{"featureType":"poi.medical","stylers":[{"visibility":"on"}]},{"featureType":"poi.business","stylers":[{"visibility":"simplified"}]}];
    var latlng = new google.maps.LatLng(48.692054, 6.184417);
    var options = {
        zoom: 13,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        styles: style_map,
		disableDefaultUI: false,
		scrollwheel: true,
		draggable: true,
		navigationControl: true,
		mapTypeControl: false,
		scaleControl: true,
		disableDoubleClickZoom: false        
    };

    map_stats = new google.maps.Map($('#map_stats')[0], options);

	heatmap = new HeatmapOverlay(map_stats, {"radius":15, "visible":true, "opacity":60});
	
	// Ajoute des données sur la carte
	//heatmap.addDataPoint(lat,lng,count);
	
	document.getElementById("tog").onclick = function(){
		heatmap.toggle();
	};

	heatmap_gene();
}

function heatmap_gene()
{
	$.ajax({
        url: "/api/stats/concentration",
        success: function(retour){

			//[{lat: 33.5363, lng:-117.044, count: 1},{lat: 33.5608, lng:-117.24, count: 1}]

			/*var heatdata = {
			    		max: 46,
			    		data: retour.heat
			    	}

			google.maps.event.addListenerOnce(map_stats, "idle", function(){
				heatmap.setDataSet(heatdata);
			});*/

        }, 
        timeout: function(){
        	console.log('expire');
        },
        error: function(){
        	console.log('error');
        }
    });



}