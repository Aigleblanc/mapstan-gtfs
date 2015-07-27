var map,
	plotlayers 			= [],
	dir,
	markers 			= [],
	markersbus 			= [],
	markersvelos 		= [],
	markersautopis 		= [],
	markersparkings 	= [],
	markersgares 		= [],
	markerstrains		= [],
	markersgps 			= [],
	markerstravauxs 	= [],
	testiffirst 		= 0,
	trace_route 		= [],
	init_route 			= 0,
	realtime_bus,
	realtime_on 		= 0,
	realtime_gps,
	realtime_train,
	realtime_train_on 	= 0,	
	menu_on 			= 0,
	menu_left_on 		= 0,
	display_velo 		= 0,
	display_autopi 		= 0,
	display_parking 	= 0,
	display_gare 		= 0,
	display_train 		= 0,
	display_gps 		= 0,
	display_travaux 	= 0,
	ctaLayer,
	ligne_erase 		= 1,
	gps_center 			= 1,
	tps_gps 			= 1500,
	survId;

$("#find_me")
  .geocomplete()
  .bind("geocode:result", function(event, result){
    var pos = { coords : { 
    							latitude : result.geometry.location.d,
    							longitude : result.geometry.location.e
    					 	  }
    				}
    position(pos);
});

$("#display_line").change(function(){
	if($('#display_line').is(':checked') === true)
	{
		ligne_erase = 1;
	}else{
		ligne_erase = 0;
	}
});

$("#gps_center").change(function(){
	if($('#gps_center').is(':checked') === true)
	{
		gps_center = 1;
	}else{
		gps_center = 0;
	}
});

function initialize() {
	var style_map  = [{"featureType":"water","stylers":[{"saturation":43},{"lightness":-11},{"hue":"#0088ff"}]},{"featureType":"road","elementType":"geometry.fill","stylers":[{"hue":"#ff0000"},{"saturation":-100},{"lightness":99}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"color":"#808080"},{"lightness":54}]},{"featureType":"landscape.man_made","elementType":"geometry.fill","stylers":[{"color":"#ece2d9"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"color":"#ccdca1"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#767676"}]},{"featureType":"road","elementType":"labels.text.stroke","stylers":[{"color":"#ffffff"}]},{"featureType":"poi","stylers":[{"visibility":"off"}]},{"featureType":"landscape.natural","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#b8cb93"}]},{"featureType":"poi.park","stylers":[{"visibility":"on"}]},{"featureType":"poi.sports_complex","stylers":[{"visibility":"on"}]},{"featureType":"poi.medical","stylers":[{"visibility":"on"}]},{"featureType":"poi.business","stylers":[{"visibility":"simplified"}]}];
    var latlng = new google.maps.LatLng(48.6855064, 6.2057226);
    var options = {
        zoom: 13,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        styles: style_map
    };

    map = new google.maps.Map($('#map')[0], options);

}

function display_kml()
{
	ctaLayer = new google.maps.KmlLayer({
	    url: 'http://mapstan.fr/static/kml/Plans_Lignes_Bus_Stan_2014-01_01.kml'
	});
	ctaLayer.setMap(map);
}

function position(position)
{
	var pos = new google.maps.LatLng(position.coords.latitude,
									 position.coords.longitude);


	clearMarkersgps();
	var coord = { "lat"  	: position.coords.latitude,
			 	  "lng"  	: position.coords.longitude
				};

	Addmarkersgps(coord);

	if(gps_center === 1)
	{
		map.setCenter(pos);
	}

	if(position.coords.speed != undefined)
	{
		$('#suivie_position').html('<p>Vitesse : ' + position.coords.speed * 3.6 + ' km/h</p>');
	}
	//$('#suivie_position').append("lat : "+ position.coords.latitude + " lon : "+ position.coords.longitude + "<br>");
}

function erreur_gps(error) 
{
	var info = "Erreur lors de la géolocalisation : ";
    switch(error.code) {
	    case error.TIMEOUT:
	    	info += "Timeout !";
	    break;
	    case error.PERMISSION_DENIED:
	   		info += "Vous n’avez pas donné la permission";
	    break;
	    case error.POSITION_UNAVAILABLE:
	    	info += "La position n’a pu être déterminée";
	    break;
	    case error.UNKNOWN_ERROR:
	    	info += "Erreur inconnue";
	    break;
    }
    alert(info);
}

function Geolocalisation()
{
	if(navigator.geolocation) {
		survId = navigator.geolocation.watchPosition(position, erreur_gps, {enableHighAccuracy:true});
	} else {
		alert("Votre navigateur ne supporte pas la localisation.")
	}
}

function Addmarkersgps(coord)
{
	var image = {
		url    : '/static/img/map/personne/female-2.png',
		size   : new google.maps.Size(32, 37),
		origin : new google.maps.Point(0,0),
		anchor : new google.maps.Point(18, 37)
	};

    var latLng = new google.maps.LatLng(coord.lat, coord.lng);
    var marker = new google.maps.Marker({
        position 		: latLng,
        map 			: map,
        icon 			: image
    });

	markersgps.push(marker);
}
function Addmarkers(coord)
{
	var image = {
		url    : '/static/img/map/arret/busstop.png',
		size   : new google.maps.Size(32, 37),
		origin : new google.maps.Point(0,0),
		anchor : new google.maps.Point(10, 37)
	};

    var latLng = new google.maps.LatLng(coord.lat, coord.lng);
    var marker = new google.maps.Marker({
        position 		: latLng,
        map 			: map,
        perso_stop_id 	: coord.stop_id,
        perso_sens 		: coord.sens,
        perso_id_ligne  : coord.route_id,
        icon 			: image
    });

    if(coord.sens == 0){
    	var dir = "Aller";
	}else{
		var dir = "Retour";
	}

	var date_heure = get_date('court', '/');

	Content =  "<div class='infobulle_map'>";
    Content += "Arret <b>"+coord.stop_name+"</b><br>";
    Content += "Direction <b>"+coord.dirname+"</b> ("+dir+")<br><br>";
    Content += "<a href='#' class='open_modal_horaire' data-idstop='"+coord.stop_id+"' data-routeid='"+coord.route_id+"' data-sens='"+coord.sens+"'>Voir les horaires de passage</a><br>";
    //Content += "http://www.reseau-stan.com/horaires/arret/?rub_code=28&lign_id=8&laDate=25/2/2014&sens=1&pa_id=125";
    Content += "<div id='popin_"+coord.stop_id+'-'+coord.route_id+"'><img src='/assets/img/ajax-loader.gif' /></div>";
    Content += "<a href='#rapport' class='marker_prob signalement' data-idstop='"+coord.stop_id+"' data-routeid='"+coord.route_id+"' data-routelongname='"+coord.stop_name+"' data-stopname='"+coord.stop_name+"' data-sens='"+coord.sens+"'>Effectuer un signalement</a>";
	Content += "</div>";

	var infowindow = new google.maps.InfoWindow({
	  content: Content
	});

	google.maps.event.addListener(marker, 'click', function() {
		infowindow.open(map,marker);
		// Horaire de la base GTFS
		//horaire_arret(marker.perso_id_ligne, marker.perso_stop_id, marker.perso_sens);
		// Horaire de l'api Reseau Stan
		horaire_arret_rt(marker.perso_id_ligne, marker.perso_stop_id, marker.perso_sens);
		//param_url("arret|"+marker.perso_id_ligne+'|'+marker.perso_stop_id+'|'+marker.perso_sens+'|'+map.getZoom()+'|'+map.getCenter());
	});

	markers.push(marker);
}

function Addmarkersvelos(coord)
{
	var libre = "indisponnible";
	var img_velo = '/static/img/map/velo/velo_indispo.png';

	if(coord.dispo > 0){
		libre = "disponnible";
		img_velo = '/static/img/map/velo/velo_dispo.png';
	}

	var image = {
		url    : img_velo,
		size   : new google.maps.Size(32, 37),
		origin : new google.maps.Point(0,0),
		anchor : new google.maps.Point(18, 37)
	};

    var latLng = new google.maps.LatLng(coord.lat, coord.lng);
    var marker = new google.maps.Marker({
        position 		: latLng,
        map 			: map,
        icon 			: image
    });

	Content =  "<div class='infobulle_map'>";
    Content += "Velos <b>"+coord.nom+"</b><br>";
    Content += "<b>"+coord.adresse+"</b><br>";
    Content += "<br>Vélos disponnible : <b>"+coord.dispo+"/"+coord.total+"</b><br><br>";
    Content += "<a href='http://www.velostanlib.fr/' target='_blank'>http://www.velostanlib.fr/</a>";
    Content += "</div>";

	var infowindow = new google.maps.InfoWindow({
	  content: Content
	});

	google.maps.event.addListener(marker, 'click', function() {
		infowindow.open(map,marker);
		//param_url('velo|'+map.getZoom()+'|'+map.getCenter());
	});

	markersvelos.push(marker);
}

function Addmarkersautopis(coord)
{
	var image = {
		url    : '/static/img/map/car/car.png',
		size   : new google.maps.Size(32, 37),
		origin : new google.maps.Point(0,0),
		anchor : new google.maps.Point(18, 37)
	};

    var latLng = new google.maps.LatLng(coord.lat, coord.lng);
    var marker = new google.maps.Marker({
        position 		: latLng,
        map 			: map,
        icon 			: image
    });

	Content =  "<div class='infobulle_map'>";
    Content += "Nom de la voiture : <b>"+coord.nom+"</b><br>";
    Content += "Model <b>"+coord.model+"</b><br>";
    Content += "<b>"+coord.site+"</b> "+coord.adresse+"<br><br>";
    Content += "<a href='http://www.autopi.fr/' target='_blank'>http://www.autopi.fr/</a>";
	Content += "</div>";

	var infowindow = new google.maps.InfoWindow({
	  content: Content
	});

	google.maps.event.addListener(marker, 'click', function() {
		infowindow.open(map,marker);
		//param_url('autopi|'+map.getZoom()+'|'+map.getCenter());
	});

	markersautopis.push(marker);
}

function Addmarkersparkings(coord)
{

	var libre = "complet";
	var img_parking = '/static/img/map/parking/parking_plein.png';

	if(coord.complet == "false"){
		libre = "places libres";
		img_parking = '/static/img/map/parking/parking_libre.png';
	}

	var image = {
		url    : img_parking,
		size   : new google.maps.Size(32, 37),
		origin : new google.maps.Point(0,0),
		anchor : new google.maps.Point(18, 37)
	};

    var latLng = new google.maps.LatLng(coord.lat, coord.lng);
    var marker = new google.maps.Marker({
        position 		: latLng,
        map 			: map,
        icon 			: image
    });

	Content =  "<div class='infobulle_map'>";
    Content += "<b>"+coord.nom+"</b> ("+libre+")<br>";
    Content += "<i>"+coord.adresse+"</i><br>";
    Content += "<br>Place : <b>"+coord.places+"/"+coord.capacite+"</b><br>";
	Content += "</div>";

	var infowindow = new google.maps.InfoWindow({
	  content: Content
	});

	google.maps.event.addListener(marker, 'click', function() {
		infowindow.open(map,marker);
		//param_url("parking|"+marker.perso_id_ligne+'|'+marker.perso_stop_id+'|'+marker.perso_sens+'|'+map.getZoom()+'|'+map.getCenter());
	});

	markersparkings.push(marker);
}

function Addmarkerstravauxs(coord)
{

	if(coord.niveau_gen == "0 - A qualifier")
	{
		var img_travaux = '/static/img/map/travaux/construction_0.png';
	}else if(coord.niveau_gen == "1 - Fort")
	{
		var img_travaux = '/static/img/map/travaux/construction_1.png';
	}else if(coord.niveau_gen == "2 - Moyen")
	{
		var img_travaux = '/static/img/map/travaux/construction_2.png';
	}else if(coord.niveau_gen == "3 - Faible")
	{
		var img_travaux = '/static/img/map/travaux/construction_3.png';
	}else{
		var img_travaux = '/static/img/map/travaux/construction.png';
	}

	var image = {
		url    : img_travaux,
		size   : new google.maps.Size(32, 37),
		origin : new google.maps.Point(0,0),
		anchor : new google.maps.Point(18, 37)
	};

    var latLng = new google.maps.LatLng(coord.lat, coord.lng);
    var marker = new google.maps.Marker({
        position 		: latLng,
        map 			: map,
        icon 			: image
    });

	Content =  "<div class='infobulle_map'>";
    Content += "<i>"+coord.adresse+"</i><br>";
	Content += ""+coord.niveau_gen+"<br>";
	Content += ""+coord.type_inter+"<br>";
	Content += ""+coord.date_debut+"<br>";
	Content += ""+coord.date_fin+"<br>";
	Content += ""+coord.descr_gene+"<br>";
	Content += ""+coord.descr_ge_1+"<br>";
	Content += ""+coord.descr_ge_2+"<br>";

	Content += "</div>";

	var infowindow = new google.maps.InfoWindow({
	  content: Content
	});

	google.maps.event.addListener(marker, 'click', function() {
		infowindow.open(map,marker);
	});

	markerstravauxs.push(marker);
}

function Addmarkersgares(coord)
{

	var img_gare = '/static/img/map/train/gare.png';

	var image = {
		url    : img_gare,
		size   : new google.maps.Size(32, 37),
		origin : new google.maps.Point(0,0),
		anchor : new google.maps.Point(18, 37)
	};

    var latLng = new google.maps.LatLng(coord.lat, coord.lng);
    var marker = new google.maps.Marker({
        position 		: latLng,
        map 			: map,
        icon 			: image,
        perso_stop_id 	: coord.stop_id
    });

	Content =  "<div class='infobulle_map'>";
    Content += "<b>"+coord.nom+"</b> <br>";
    Content += "<a href='#' class='open_modal_sncf_horaire' data-idstop='"+coord.stop_id+"'>Voir les horaires de passage</a><br>";
    Content += "<div id='popin_"+coord.stop_id.replace(/ /g,"").replace(":","")+"'><img src='/assets/img/ajax-loader.gif' /></div>";
	Content += "</div>";

	var infowindow = new google.maps.InfoWindow({
	  content: Content
	});

	google.maps.event.addListener(marker, 'click', function() {
		infowindow.open(map,marker);
		horaire_sncf_arret(marker.perso_stop_id);
	});

	markersgares.push(marker);
}

function Addbus(coord)
{
	var image = {
		url    : '/static/img/map/bus/bus_'+coord.route_id+'.png',
		size   : new google.maps.Size(32, 37),
		origin : new google.maps.Point(0,0),
		anchor : new google.maps.Point(18, 32)
	};

    var latLng = new google.maps.LatLng(coord.lat, coord.lng);
    var marker = new google.maps.Marker({
        position 		: latLng,
        map 			: map,
        icon 			: image
    });

    if(coord.sens == 0){
    	var dir = "Aller";
	}else{
		var dir = "Retour";
	}

	var date_heure = get_date('court', '/');

	var type_transport = "Bus";
	if(coord.route_id == 101)
	{
		type_transport = "Tram";
	}else if(coord.route_id == 102)
	{
		type_transport = "Tram";
	}

	Content =  "<div class='infobulle_map'>";
	Content =  "<b>"+type_transport+"</b> Ligne "+coord.ligne_short_name+" <br>";
	Content += "Arret <b>"+ coord.stop_name +"</b><br>Ligne <b>"+ coord.ligne_name +"</b><br>";
	Content += "Vers l'arret <b>"+ coord.next_arret +"</b> direction <b>"+coord.dirname+"</b> ("+dir+")<br>";
	Content += "<br>Heure d'arrivé : <b>"+ coord.heure +"</b>";
	Content += "<br>bus <b>"+ coord.status +"</b><br><br>";

    //Content += "<a target='_blank' href='http://www.reseau-stan.com/horaires/arret/?rub_code=28&lign_id="+coord.route_id+"&laDate="+date_heure+"&sens="+coord.sens+"&pa_id="+coord.stop_id+"'>Horaire à cet arret</a><br>";
    Content += "<span> > </span> <a href='#rapport' class='marker_prob signalement' data-idstop='"+coord.stop_id+"' data-routeid='"+coord.route_id+"' data-routelongname='"+coord.stop_name+"' data-stopname='"+coord.stop_name+"' data-sens='"+coord.sens+"'>Effectuer un signalement</a>";

	Content += "</div>";

	var infowindow = new google.maps.InfoWindow({
	  content: Content
	});

	google.maps.event.addListener(marker, 'click', function() {
		infowindow.open(map,marker);
	});

	markersbus.push(marker);
}

function Addtrains(coord)
{
	var image = {
		url    : '/static/img/map/train/train.png',
		size   : new google.maps.Size(32, 37),
		origin : new google.maps.Point(0,0),
		anchor : new google.maps.Point(18, 32)
	};

    var latLng = new google.maps.LatLng(coord.lat, coord.lng);
    var marker = new google.maps.Marker({
        position 		: latLng,
        map 			: map,
        icon 			: image
    });

    if(coord.sens == 0){
    	var dir = "Aller";
	}else{
		var dir = "Retour";
	}

	var date_heure = get_date('court', '/');

	Content =  "<div class='infobulle_map'>";
	Content =  "Ligne "+coord.ligne_short_name+" <br>";
	Content += "Arret <b>"+ coord.stop_name +"</b><br>Ligne <b>"+ coord.ligne_name +"</b><br>";
	Content += "Vers l'arret <b>"+ coord.next_arret +"</b> direction <b>"+coord.dirname+"</b> ("+dir+")<br>";
	Content += "<br>Heure d'arrivé : <b>"+ coord.heure +"</b>";
	Content += "<br>bus <b>"+ coord.status +"</b><br><br>";

	Content += "</div>";

	var infowindow = new google.maps.InfoWindow({
	  content: Content
	});

	google.maps.event.addListener(marker, 'click', function() {
		infowindow.open(map,marker);
	});

	markerstrains.push(marker);
}

function setAllMap(map) {
  for (var i = 0; i < markers.length; i++) {
    markers[i].setMap(map);
  }
}

function clearMarkers() {
  setAllMap(null);
}
function showMarkers() {
  setAllMap(map);
}
function deleteMarkers() {
  clearMarkers();
  markers = [];
}

function setAllMapgps(map) {
  for (var i = 0; i < markersgps.length; i++) {
    markersgps[i].setMap(map);
  }
}

function clearMarkersgps() {
  setAllMapgps(null);
}
function showMarkersgps() {
  setAllMapgps(map);
}
function deleteMarkers_gps() {
  clearMarkersgps();
  markersgps = [];
}

function setAllMapbus(map) {
  for (var i = 0; i < markersbus.length; i++) {
    markersbus[i].setMap(map);
  }
}
function clearMarkersbus() {
  setAllMapbus(null);
}
function showMarkersbus() {
  setAllMapbus(map);
}
function deleteMarkersbus() {
  clearMarkersbus();
  markersbus = [];
}

function setAllMapvelos(map) {
  for (var i = 0; i < markersvelos.length; i++) {
    markersvelos[i].setMap(map);
  }
}
function clearMarkersvelos() {
  setAllMapvelos(null);
}
function showMarkersvelos() {
  setAllMapvelos(map);
}
function deleteMarkersvelos() {
  clearMarkersvelos();
  markersvelos = [];
}

function setAllMapautopis(map) {
  for (var i = 0; i < markersautopis.length; i++) {
    markersautopis[i].setMap(map);
  }
}
function clearMarkersautopis() {
  setAllMapautopis(null);
}
function showMarkersautopis() {
  setAllMapautopis(map);
}
function deleteMarkersautopis() {
  clearMarkersautopis();
  markersautopis = [];
}

function setAllMapparkings(map) {
  for (var i = 0; i < markersparkings.length; i++) {
    markersparkings[i].setMap(map);
  }
}
function clearMarkersparkings() {
  setAllMapparkings(null);
}
function showMarkersparkings() {
  setAllMapparkings(map);
}
function deleteMarkersparkings() {
  clearMarkersparkings();
  markersparkings = [];
}

function setAllMaptravauxs(map) {
  for (var i = 0; i < markerstravauxs.length; i++) {
    markerstravauxs[i].setMap(map);
  }
}
function clearMarkerstravauxs() {
  setAllMaptravauxs(null);
}
function showMarkerstravauxs() {
  setAllMaptravauxs(map);
}
function deleteMarkerstravauxs() {
  clearMarkertravauxs();
  markerstravauxs = [];
}

function setAllMapgares(map) {
  for (var i = 0; i < markersgares.length; i++) {
    markersgares[i].setMap(map);
  }
}
function clearMarkersgares() {
  setAllMapgares(null);
}
function showMarkersgares() {
  setAllMapgares(map);
}
function deleteMarkersgares() {
  clearMarkersgares();
  markersgares = [];
}

function setAllMaptrains(map) {
  for (var i = 0; i < markerstrains.length; i++) {
    markerstrains[i].setMap(map);
  }
}
function clearMarkerstrains() {
  setAllMaptrains(null);
}
function showMarkerstrains() {
  setAllMaptrains(map);
}
function deleteMarkerstrains() {
  clearMarkerstrain();
  markerstrains = [];
}

function addLine(i) {
  trace_route[i].setMap(map);
}
function removeLine() {
	if(trace_route.length > 0){
		for (var i = 0; i < trace_route.length; i++) {
    		trace_route[i].setMap(null);
  		}
	}
}

function param_url(param)
{
    window.location.hash = param;
    return false;
}

$(window).bind('hashchange', function () {
	    var hash = window.location.hash.slice(1);
	    console.log(hash);
});

function horaire_arret(id_ligne, stop_id, sens) {
	$.ajax({
        url: "/api/horaire/get_by_arret_current/"+id_ligne+"/"+stop_id+"/"+sens+"/3/",
        success: function(retour){

        	if(retour.horaires.length == undefined)
        	{
				var horaire_ligne_curent = "<ul><li>Pas d'horaire disponnible...</li></ul>";
        	}else{
				var horaire_ligne_curent = "<ul>";
				for (i=0;i<retour.horaires.length;i++) {
					horaire_ligne_curent += "<li>"+retour.horaires[i].arrival_time+"</li>"
				}
				horaire_ligne_curent += "</ul>";
			}

			$("#popin_"+stop_id+"-"+id_ligne).empty().append(horaire_ligne_curent);
        }, 
        timeout: function(){
        	console.log('expire');
        },
        error: function(){
        	console.log('error');
        }
    });
}

// 395, 113
function horaire_arret_rt(ligne_id, stop_id, sens)
{
	var date = get_date("rt", "-");
	var dir  = parseInt(sens) + 1;
	$.ajax({
        url: "http://openservice.stan.cityway.fr/api/timetables/v1/StopPassingTimes/json?key=ANSTAN&stopID="+ stop_id +"&refTime="+ date +"&direction="+ dir,
        success: function(retour){
        	if(retour.StopTimetableObj.Status.code == "0"){
        		var horaires = retour.StopTimetableObj.HourGroup.VehicleJourneyAtStop;

        		var horaire_ligne_curent = "<ul>";
        		var a = 0;
        		for (i=0;i<horaires.length;i++)
        		{
        			if(a == 4){
						break;
					}
					if(horaires[i].line.code == ligne_id)
					{
						horaire_ligne_curent += "<li>"+horaires[i].waitingTime.minute+" minutes</li>"
						a++;
					}
        		}
        		horaire_ligne_curent += "</ul>";
        		$("#popin_"+stop_id+"-"+ligne_id).empty().append(horaire_ligne_curent);
        	}
        	//console.log(retour);
        }, 
        timeout: function(){
        	console.log('expire');
        },
        error: function(){
        	console.log('error');
        }
    });
}


function horaire_sncf_arret(stop_id) {
	$.ajax({
        url: "/api/sncf/get_by_arret_current/"+stop_id+"/3/",
        success: function(retour){

        	if(retour.horaires.length == undefined)
        	{
				var horaire_ligne_curent = "<ul><li>Pas d'horaire disponnible...</li></ul>";
        	}else{
				var horaire_ligne_curent = "<ul>";
				for (i=0;i<retour.horaires.length;i++) {
					horaire_ligne_curent += "<li>"+retour.horaires[i].arrival_time+" - "+retour.horaires[i].route_long_name+" direction "+retour.horaires[i].direction_id+"</li>"
				}
				horaire_ligne_curent += "</ul>";
			}

			$("#popin_"+stop_id.replace(/ /g,"").replace(":","")).empty().append(horaire_ligne_curent);
        }, 
        timeout: function(){
        	console.log('expire');
        },
        error: function(){
        	console.log('error');
        }
    });
}

function realtime_toggle()
{
	if(realtime_on == 0)
	{
		realtime();
		realtime_bus = setInterval(function(){realtime();},25000);
		realtime_on = 1;
		$('#btn_realtime').empty().append('Désactiver les bus en temps réel');
		$('#img_toggle_tmpreel').attr("src", "/static/img/map/pack/bus-18@2x-stop.png");
	}else{
		realtime_desactive();
		realtime_on = 0;
		$('#btn_realtime').empty().append('Activer les bus en temps réel');
		$('#img_toggle_tmpreel').attr("src", "/static/img/map/pack/bus-18@2x-play.png");
	}
}

function gps_toggle()
{
	if(display_gps === 0){
		//realtime_gps = setInterval(function(){Geolocalisation();}, tps_gps);
		//$('#img_toggle_tmpreel').attr("src", "/static/img/map/pack/bus-18@2x-stop.png");
		Geolocalisation();
		display_gps = 1;
	}else{
		//clearInterval(realtime_gps);
		clearMarkersgps();
		navigator.geolocation.clearWatch(survId);
		//$('#img_toggle_tmpreel').attr("src", "/static/img/map/pack/bus-18@2x-stop.png");
		display_gps = 0;
	}
}

function realtime_desactive()
{
	clearMarkersbus();
	clearInterval(realtime_bus);
}

function realtime_sncf_toggle()
{
	if(realtime_train_on == 0)
	{
		display_trains();
		realtime_train = setInterval(function(){display_trains();},25000);
		realtime_train_on = 1;
		$('#btn_realtime').empty().append('Désactiver les bus en temps réel');
		$('#img_toggle_train').attr("src", "/static/img/map/train/rail-18@2x_stop.png");
	}else{
		realtime_sncf_desactive();
		realtime_train_on = 0;
		$('#btn_realtime').empty().append('Activer les bus en temps réel');
		$('#img_toggle_train').attr("src", "/static/img/map/train/rail-18@2x_play.png");
	}
}

function realtime_sncf_desactive()
{
	clearMarkerstrains();
	clearInterval(realtime_train);
}

$('#map').on('click', 'a.marker_prob', function(){
	$('#f_nom_ligne').val($(this).data('routeid'));
	$('#f_direction').val($(this).data('sens'));

	var tmp_id_stop = $(this).data('idstop');

	change_line($(this).data('routeid'), $(this).data('sens'), tmp_id_stop);
});

$('#map').on('click', '.open_modal_horaire', function(){
	$('#Modal_horaire').modal('toggle');

	$.ajax({
        url: "/api/horaire/get_by_arret/"+$(this).data('routeid')+"/"+$(this).data('idstop')+"/"+$(this).data('sens')+"/",
        success: function(retour){

			var horaire_ligne_curent = "<ul>";
			for (i=0;i<retour.horaires.length;i++) {
				horaire_ligne_curent += "<li>"+retour.horaires[i].arrival_time+"</li>"
			}
			horaire_ligne_curent += "</ul>";

			$("#modal_horaire_core").empty().append(horaire_ligne_curent);
        }, 
        timeout: function(){
        	console.log('expire');
        },
        error: function(){
        	console.log('error');
        }
    });

	return false;
});

$('#map').on('click', '.open_modal_sncf_horaire', function(){
	$('#Modal_horaire').modal('toggle');

	$.ajax({
        url: "/api/sncf/get_by_arret/"+$(this).data('idstop'),
        success: function(retour){

			var horaire_ligne_curent = "<ul>";
			for (i=0;i<retour.horaires.length;i++) {
				horaire_ligne_curent += "<li>"+retour.horaires[i].arrival_time+" - "+retour.horaires[i].route_long_name+" direction "+retour.horaires[i].direction_id+"</li>"
			}
			horaire_ligne_curent += "</ul>";

			$("#modal_horaire_core").empty().append(horaire_ligne_curent);
        }, 
        timeout: function(){
        	console.log('expire');
        },
        error: function(){
        	console.log('error');
        }
    });

	return false;
});


$("#f_nom_ligne").change(function(){
	var id_ligne = $('#f_nom_ligne').val();
	var sens     = $('#f_direction').val();

	change_line(id_ligne, sens, 0);
});

$("#f_direction").change(function(){
	var id_ligne = $('#f_nom_ligne').val();
	var sens     = $('#f_direction').val();

	change_line(id_ligne, sens, 0);
});

$("#f_probleme").change(function(){

	if($(this).val() == 'retard')
	{
		$("#zone_retard").fadeIn(300);
		$("#zone_avance").fadeOut(300);
	}else if($(this).val() == 'avance'){
		$("#zone_avance").fadeIn(300);
		$("#zone_retard").fadeOut(300);
	}else{
		$("#zone_retard").fadeOut(300);
		$("#zone_avance").fadeOut(300);
	}
});

$(document).on('submit','form#form_rapport',function(){

	var donnee = {
			nom_ligne 	: $('#f_nom_ligne option:selected').html(),
			nom_arret 	: $('#f_nom_arret option:selected').html(),
			nom_sens 	: $('#f_direction option:selected').html(),
			nom_prob	: $('#f_probleme option:selected').html(),
			id_ligne 	: $('#f_nom_ligne').val(),
			id_arret 	: $('#f_nom_arret').val(),
			sens 		: $('#f_direction').val(),
			probleme 	: $('#f_probleme').val(),
			tps_retard 	: $('#f_tps_retard').val(),
			tps_avance 	: $('#f_tps_avance').val(),
			heure 		: $('#f_heure').val(),
			min 		: $('#f_min').val(),
			num_bus 	: $('#f_num_bus').val(),
			email 		: $('#f_email').val(),
			remarque 	: $('#f_remarque').val(),
			date 		: $('#f_date').val()
		}

    $.ajax({
        url: "/api/map/rapport/",
        type : 'post',
        data : donnee,
        success: function(retour){
            if(retour.success == true)
            {
            	$('#retour_rapport').removeClass("alert-danger").addClass('alert-success');
            	$('#retour_rapport').empty().append(retour.msg);
				$('#retour_rapport').show();
            }else{
				$('#retour_rapport').removeClass("alert-success").addClass('alert-danger');
				$('#retour_rapport').empty().append(retour.msg);
				$('#retour_rapport').show();
            }
        }, 
        timeout: function(){
        	console.log('expire');
        },
        error: function(){
        	console.log('error');
        }
    });

	return false;

});

$('#on_toggle_line').on('click', function(){
	if(menu_left_on === 0){
		$( "#zone_left" ).fadeIn(300);
		menu_left_on = 1;
	}else{
		$( "#zone_left" ).fadeOut(300);
		menu_left_on = 0;
	}
});

$('#on_toggle_gps').on('click', function(){
	gps_toggle();
});

$('#on_toggle_velo').on('click', function(){
	if(display_velo === 0){
		display_velos();
		display_velo = 1;
	}else{
		clearMarkersvelos();
		display_velo = 0;
	}
});

$('#on_toggle_autopi').on('click', function(){
	if(display_autopi === 0){
		display_autopis();
		display_autopi = 1;
	}else{
		clearMarkersautopis();
		display_autopi = 0;
	}
});

$('#on_toggle_parking').on('click', function(){
	if(display_parking === 0){
		display_parkings();
		display_parking = 1;
	}else{
		clearMarkersparkings();
		display_parking = 0;
	}
});

$('#on_toggle_travaux').on('click', function(){
	if(display_travaux === 0){
		display_travauxs();
		display_travaux = 1;
	}else{
		clearMarkerstravauxs();
		display_travaux = 0;
	}
});

$('#on_toggle_gare').on('click', function(){
	if(display_gare === 0){
		display_gares();
		display_gare = 1;
	}else{
		clearMarkersgares();
		display_gare = 0;
	}
});

$('#on_toggle_train').on('click', function(){
	realtime_sncf_toggle();
});

/*
$('#on_toggle_menu').on('click', function(){
	if(menu_on === 0){
		$('body').css('padding-top', '50px');
		$('#menu_navigation').fadeIn(300);
		$('#zone_menu_right').fadeOut(300);
		menu_on = 1;
	}else{
		$('#menu_navigation').fadeOut(300);
		$('#zone_menu_right').fadeIn(300);
		$('body').css('padding-top', '0');
		menu_on = 0;
	}
});*/

$('#on_toggle_tmpreel').on('click', function(){
	realtime_toggle();
});

$('#liste_ligne').on('click', 'span.click_route', function(){
	var id_ligne = $(this).data('id-route');
	var sens     = $(this).data('sens-route');

	change_line(id_ligne, sens, 0);
	$('#Modal_lignesStan').modal('hide');
});

function change_line(id_ligne, sens, tmp_id_stop)
{
	$('#f_nom_ligne').val(id_ligne);
	$('#f_direction').val(sens);
	$('#f_nom_arret').empty();

    $.ajax({
    	url: "/api/arret/get_arrets/" + id_ligne + "/" + sens,
        dataType: 'jsonp',
        success: function(retour){
    		if(ligne_erase == 1)
    		{
				clearMarkers();
			}

			var coord 	   	= [];
			var road 	   	= [];

			var color_road 	= "#"+retour.color;
			//var color_road 	= "#FF0000";

			var lastID 	   		= retour.arrets.length - 1;

			var dir_aller 		= retour.arrets[0].stop_name;
			var dir_retour 		= retour.arrets[lastID].stop_name;
			if(sens == 1){
				$('#f_direction option[value="0"]').text(dir_aller);
				$('#f_direction option[value="1"]').text(dir_retour);
				var dir_name = dir_retour;
			}else{
				$('#f_direction option[value="0"]').text(dir_retour);
				$('#f_direction option[value="1"]').text(dir_aller);
				var dir_name = dir_retour;
			}

			$.ajax({
		    	url: "/api/ligne/chemin/" + id_ligne + "/" + sens,
		        dataType: 'jsonp',
		        success: function(retour){
					for (i=0;i<retour.chemin.length;i++) {
						road.push(new google.maps.LatLng(retour.chemin[i].lat,retour.chemin[i].lon));
					}

					if(ligne_erase == 1)
	        		{
						removeLine();
					}

					trace_route[init_route] = new google.maps.Polyline({
						path: road,
						geodesic: true,
						strokeColor: color_road,
						strokeOpacity: 1.0,
						strokeWeight: 2
					});

					addLine(init_route);

					init_route++;
		        }
		    });

			for (i=0;i<retour.arrets.length;i++) {
				
				$("#f_nom_arret").append("<option value='"+retour.arrets[i].stop_id+"'>"+retour.arrets[i].stop_name+"</option>");
        		if (i == lastID) {
        			if(tmp_id_stop != 0) {
        				$('#f_nom_arret').val(tmp_id_stop);
        			}
   				}

				coord = {"lat"  	 		: retour.arrets[i].stop_lat,
						 "lng"  	 		: retour.arrets[i].stop_lon,
						 "stop_name" 		: retour.arrets[i].stop_name,
						 "stop_id"   		: retour.arrets[i].stop_id,
						 "route_id"  		: id_ligne,
						 "sens"  			: sens,
						 "dirname"  		: dir_name
						};

				Addmarkers(coord);
			}
        }, 
        timeout: function(){
        	console.log('expire');
        },
        error: function(){
        	console.log('error');
        }
    });
}

function realtime()
{
	$('#img_toggle_tmpreel').attr("src", "/assets/img/ajax-loader.gif");
	$.ajax({
        url: "/api/realtime/bus",
        success: function(retour){
			clearMarkersbus();
			for (i=0;i<retour.bus.length;i++) {
				
				var next_arret_name = 'Terminus';

				if(retour.bus[i].next_arret[0] != undefined)
				{
					var next_arret_name = retour.bus[i].next_arret[0].stop_name;
				}

				coord = {"lat"  	 		: retour.bus[i].stop_lat,
						 "lng"  	 		: retour.bus[i].stop_lon,
						 "stop_name" 		: retour.bus[i].stop_name,
						 "stop_id"   		: retour.bus[i].stop_id,
						 "route_id"  		: retour.bus[i].route_id,
						 "sens"  			: retour.bus[i].direction_id,
						 "ligne_short_name" : retour.bus[i].route_short_name,
						 "ligne_name"  		: retour.bus[i].route_long_name,
						 "route_color"		: retour.bus[i].route_color,
						 "heure"		    : retour.bus[i].arrival_time,
						 "dirname" 			: retour.bus[i].direction,
						 "next_arret" 		: next_arret_name,
						 "status" 			: retour.bus[i].status
						};

				Addbus(coord);
				$('#img_toggle_tmpreel').attr("src", "/static/img/map/pack/bus-18@2x-stop.png");
			}
        }, 
        timeout: function(){
        	console.log('expire');
        },
        error: function(){
        	console.log('error');
        }
    });
}

function display_trains()
{
	$('#img_toggle_train').attr("src", "/assets/img/ajax-loader.gif");
	$.ajax({
        url: "/api/sncf/realtime",
        success: function(retour){
			clearMarkerstrains();
			for (i=0;i<retour.trains.length;i++) {
				
				var next_arret_name = 'Terminus';

				if(retour.trains[i].next_arret[0] != undefined)
				{
					var next_arret_name = retour.trains[i].next_arret[0].stop_name;
				}

				coord = {"lat"  	 		: retour.trains[i].stop_lat,
						 "lng"  	 		: retour.trains[i].stop_lon,
						 "stop_name" 		: retour.trains[i].stop_name,
						 "stop_id"   		: retour.trains[i].stop_id,
						 "route_id"  		: retour.trains[i].route_id,
						 "sens"  			: retour.trains[i].direction_id,
						 "ligne_short_name" : retour.trains[i].route_short_name,
						 "ligne_name"  		: retour.trains[i].route_long_name,
						 "route_color"		: retour.trains[i].route_color,
						 "heure"		    : retour.trains[i].arrival_time,
						 "dirname" 			: retour.trains[i].direction,
						 "next_arret" 		: next_arret_name,
						 "status" 			: retour.trains[i].status
						};

				Addtrains(coord);
				$('#img_toggle_train').attr("src", "/static/img/map/train/rail-18@2x_stop.png");
			}
        }, 
        timeout: function(){
        	console.log('expire');
        },
        error: function(){
        	console.log('error');
        }
    });
}

function display_gares()
{
	$('#img_toggle_gare').attr("src", "/assets/img/ajax-loader.gif");
    $.ajax({
    	url: "/api/sncf/liste_arret",
        dataType: 'jsonp',
        success: function(retour){
				clearMarkersgares();

				var coord 	   	= [];

				for (i=0;i<retour.arrets.length;i++) {

					coord = {
								"lat"  	 		: retour.arrets[i].stop_lat,
								"lng"  	 		: retour.arrets[i].stop_lon,
								"nom" 			: retour.arrets[i].stop_name,
								"stop_id"  		: retour.arrets[i].stop_id
							};

					Addmarkersgares(coord);
					$('#img_toggle_gare').attr("src", "/static/img/map/pack/rail-18@2x.png");
				}
        }, 
        timeout: function(){
        	console.log('expire');
        },
        error: function(){
        	alert('Impossible de chercher les données actuellement.')
        }
    });
}

function display_velos()
{
	$('#img_toggle_velo').attr("src", "/assets/img/ajax-loader.gif");
    $.ajax({
    	url: "/api/velo/rt_liste",
        dataType: 'jsonp',
        success: function(retour){
				clearMarkersvelos();

				var coord 	   	= [];

				for (i=0;i<retour.velos.length;i++) {
					
					coord = {
							"lat"  	 		: retour.velos[i].position.lat,
							 "lng"  	 	: retour.velos[i].position.lng,
							 "nom" 			: retour.velos[i].name,
							 "adresse"  	: retour.velos[i].address,
							 "total"  		: retour.velos[i].bike_stands,
							 "dispo"  		: retour.velos[i].available_bikes
							};

					Addmarkersvelos(coord);
					$('#img_toggle_velo').attr("src", "/static/img/map/pack/bicycle-18@2x.png");
				}
        }, 
        timeout: function(){
        	console.log('expire');
        },
        error: function(){
        	alert('Impossible de chercher les données actuellement.')
        }
    });
}

function display_autopis()
{
	$('#img_toggle_autopi').attr("src", "/assets/img/ajax-loader.gif");
    $.ajax({
    	url: "/api/autopis",
        dataType: 'jsonp',
        success: function(retour){
				clearMarkersautopis();

				var coord 	   	= [];

				//console.log(retour.autopis);

				for (i=0;i<retour.autopis.length;i++) {
					
					coord = {
							"lat"  	 	: retour.autopis[i].lat,
							 "lng"  	: retour.autopis[i].long,
							 "model" 	: retour.autopis[i].model,
							 "nom"   	: retour.autopis[i].nom,
							 "adresse"  : retour.autopis[i].adresse,
							 "site"  	: retour.autopis[i].site,
							};

					Addmarkersautopis(coord);
					$('#img_toggle_autopi').attr("src", "/static/img/map/pack/car-18@2x.png");
				}
        }, 
        timeout: function(){
        	console.log('expire');
        },
        error: function(){
        	alert('Impossible de chercher les données actuellement.')
        }
    });
}

function display_parkings()
{
	$('#img_toggle_parking').attr("src", "/assets/img/ajax-loader.gif");
    $.ajax({
    	url: "/api/parking/rt_liste",
        dataType: 'jsonp',
        success: function(retour){
				clearMarkersparkings();

				var coord 	   		= [],
					firstProjection = '+proj=lcc +lat_1=49 +lat_2=44 +lat_0=46.5 +lon_0=3 +x_0=700000 +y_0=6600000 +ellps=GRS80 +towgs84=0,0,0,0,0,0,0 +units=m +no_defs';

				for (i=0;i<retour.parkings.length;i++) {
								
					coord = {
							 "lat"  	: retour.parkings[i].lat,
							 "lng"  	: retour.parkings[i].lng,
							 "nom"   	: retour.parkings[i].nom,
							 "adresse"  : retour.parkings[i].adresse,
							 "places"  	: retour.parkings[i].places,
							 "capacite" : retour.parkings[i].capacite,
							 "complet"  : retour.parkings[i].complet,
							 "ferme"  	: retour.parkings[i].ferme,
							 "ouvert"  	: retour.parkings[i].ouvert
							};
							
							/*var LatLng = proj4(firstProjection).inverse([coord.lat, coord.lng]);
							coord.lat  = LatLng[1];
							coord.lng  = LatLng[0];*/

							//console.log(retour.parkings.features[i].attributes.nom, coord.lat, coord.lng, retour.parkings.features[i].geometry.x, retour.parkings.features[i].geometry.y);

					Addmarkersparkings(coord);
					$('#img_toggle_parking').attr("src", "/static/img/map/pack/parking-18@2x.png");
				}
        }, 
        timeout: function(){
        	console.log('expire');
        },
        error: function(){
        	alert('Impossible de chercher les données actuellement.')
        }
    });
}

function display_travauxs()
{
	$('#img_toggle_travaux').attr("src", "/assets/img/ajax-loader.gif");
    $.ajax({
    	url: "/api/travaux/rt_liste",
        dataType: 'jsonp',
        success: function(retour){
				clearMarkerstravauxs();

				var coord 	   		= [];

				for (i=0;i<retour.travaux.length;i++) {
								
					coord = {
							 "lat"  		: retour.travaux[i].lat,
							 "lng"  		: retour.travaux[i].lng,
							 "adresse"  	: retour.travaux[i].adresse,
							 "niveau_gen"  	: retour.travaux[i].niveau_gen,
							 "commune" 		: retour.travaux[i].commune,
							 "type_inter"  	: retour.travaux[i].type_inter,
							 "date_debut"  	: retour.travaux[i].date_debut,
							 "date_fin"  	: retour.travaux[i].date_fin,
							 "descr_gene"  	: retour.travaux[i].descr_gene,
							 "descr_ge_1"  	: retour.travaux[i].descr_ge_1,
							 "descr_ge_2"  	: retour.travaux[i].descr_ge_2
							};

					Addmarkerstravauxs(coord);
					$('#img_toggle_travaux').attr("src", "/static/img/map/pack/construction_icon.png");
				}
        }, 
        timeout: function(){
        	console.log('expire');
        },
        error: function(){
        	alert('Impossible de chercher les données actuellement.')
        }
    });
}

/**
 * Forge les differents type de date
 */
function get_date(type, separator)
{
	var d     = new Date();
 	var min   = d.getMinutes();
 	var mois  = d.getMonth()+1;
	var jour  = d.getDate();
	var heure = d.getHours();

 	if(d.getMinutes() < 10){
 		min = "0" + d.getMinutes();
 	}
 	if( mois < 10){
 		mois = "0" + mois;
 	}
 	if(d.getDate() < 10){
 		jour = "0" + d.getDate();
 	}
 	if(d.getHours() < 10){
 		heure = "0" + d.getHours();
 	}

	if(type === 'full')
	{
	 	var datetime =  jour + separator;
			datetime += mois + separator;
			datetime += d.getFullYear() + " ";
			datetime += heure + ":";
	 		datetime += min;
	}else if(type == "rt") {
		var	datetime = d.getFullYear() + "-";
			datetime += mois + "-";
		    datetime +=  jour + "_";
			datetime += heure + "-";
	 		datetime += min;	
	}else{
	 	var datetime =  jour + separator;
			datetime += mois + separator;
		 	datetime += d.getFullYear();
	}

	return datetime;
}

/*
* debouncedresize: special jQuery event that happens once after a window resize
*
* latest version and complete README available on Github:
* https://github.com/louisremi/jquery-smartresize
*
* Copyright 2012 @louis_remi
* Licensed under the MIT license.
*
* This saved you an hour of work?
* Send me music http://www.amazon.co.uk/wishlist/HNTU0468LQON
*/
(function($) {

var $event = $.event,
        $special,
        resizeTimeout;

		$special = $event.special.debouncedresize = {
        setup: function() {
                $( this ).on( "resize", $special.handler );
        },
        teardown: function() {
                $( this ).off( "resize", $special.handler );
        },
        handler: function( event, execAsap ) {
                // Save the context
                var context = this,
                        args = arguments,
                        dispatch = function() {
                                // set correct event type
                                event.type = "debouncedresize";
                                $event.dispatch.apply( context, args );
                        };

                if ( resizeTimeout ) {
                        clearTimeout( resizeTimeout );
                }

                execAsap ?
                        dispatch() :
                        resizeTimeout = setTimeout( dispatch, $special.threshold );
        },
        threshold: 150
};

})(jQuery);