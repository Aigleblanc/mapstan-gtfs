<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Parking extends CI_Controller {

	public function rt_liste()
	{
		$parkings = json_decode(file_get_contents("https://geoservices.grand-nancy.org/arcgis/rest/services/public/VOIRIE_Parking/MapServer/0/query?text=&geometry=&geometryType=esriGeometryEnvelope&inSR=&spatialRel=esriSpatialRelIntersects&relationParam=&objectIds=&where=1%3D1&time=&returnIdsOnly=false&returnGeometry=true&maxAllowableOffset=&outSR=4326&outFields=objectid%2C+nom%2C+adresse%2C+places%2C+capacite%2C+complet%2C+ferme%2C+ouvert&f=pjson"));

		foreach ($parkings->features as $value) {

			//$geo  		= $this->geo_gps->lamber_to_latlon($value->geometry->x, $value->geometry->y);
			$result[] 	= array(
							'lat' 			=> $value->geometry->y,
							'lng' 			=> $value->geometry->x,
							'nom' 			=> $value->attributes->NOM, 
							'adresse' 		=> $value->attributes->ADRESSE, 
							'places' 		=> $value->attributes->PLACES, 
							'capacite' 		=> $value->attributes->CAPACITE, 
							'complet' 		=> $value->attributes->COMPLET, 
							'ferme' 		=> $value->attributes->FERME, 
							'ouvert' 		=> $value->attributes->OUVERT,
						);
		}

		$retour['parkings'] = $result;

		retour('liste des parkings', TRUE, $retour);
	}

	public function rt_get($id)
	{
		$parking = json_decode(file_get_contents("https://geoservices.grand-nancy.org/arcgis/rest/services/public/VOIRIE_Parking/MapServer/0/query?text=&geometry=&geometryType=esriGeometryEnvelope&inSR=&spatialRel=esriSpatialRelIntersects&relationParam=&objectIds=&where=objectid%3D".$id."&time=&returnIdsOnly=false&returnGeometry=true&maxAllowableOffset=&outSR=4326&outFields=objectid%2C+nom%2C+adresse%2C+places%2C+capacite%2C+complet%2C+ferme%2C+ouvert&f=pjson"));
		
		//$geo  		= $this->geo_gps->lamber_to_latlon($parking->features[0]->geometry->x, $parking->features[0]->geometry->y);

		$retour['parkings']	= array(
										'lat' 			=> $value->geometry->y,
										'lng' 			=> $value->geometry->x,
										'nom' 			=> $value->attributes->NOM, 
										'adresse' 		=> $value->attributes->ADRESSE, 
										'places' 		=> $value->attributes->PLACES, 
										'capacite' 		=> $value->attributes->CAPACITE, 
										'complet' 		=> $value->attributes->COMPLET, 
										'ferme' 		=> $value->attributes->FERME, 
										'ouvert' 		=> $value->attributes->OUVERT,
									);

		retour('Information sur le parking', TRUE, $retour);
	}

	public function liste()
	{
		$parkings['parkings'] = $this->parking_model->get_liste();

		retour('liste des parkings', TRUE, $parkings);
	}

	public function get($id)
	{
		$parking['parking'] = $this->parking_model->get($id);

		retour('parking', TRUE, $parking);
	}

}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */