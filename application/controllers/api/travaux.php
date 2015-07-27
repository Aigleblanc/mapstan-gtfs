<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Travaux extends CI_Controller {

	public function rt_liste()
	{	
		$args 		= "objectid,type_intervention,commune,adresse,niveau_gene,descr_gene1,descr_gene2,descr_gene3,date_debut,date_fin";
		$travaux 	= json_decode(file_get_contents("https://geoservices.grand-nancy.org/arcgis/rest/services/public/VOIRIE_Info_Travaux_Niveau/MapServer/0/query?text=&geometry=&geometryType=esriGeometryEnvelope&inSR=&spatialRel=esriSpatialRelIntersects&relationParam=&objectIds=&where=1%3D1&time=&returnIdsOnly=false&returnGeometry=true&maxAllowableOffset=&outSR=4326&outFields=".$args."&f=pjson"));

		foreach ($travaux->features as $value) {

			$date = new DateTime();
			$date->setTimestamp(substr($value->attributes->DATE_DEBUT, 0, -3));
			$date_debut = $date->format('Y-m-d H:i');

			$date->setTimestamp(substr($value->attributes->DATE_FIN, 0, -3));
			$date_fin = $date->format('Y-m-d H:i');

			$result[] 	= array(
							'lat' 			=> $value->geometry->y,
							'lng' 			=> $value->geometry->x,				
							'niveau_gen' 	=> $value->attributes->NIVEAU_GENE, 
							'adresse' 		=> $value->attributes->ADRESSE, 
							'commune' 		=> $value->attributes->COMMUNE,
							'type_inter' 	=> $value->attributes->TYPE_INTERVENTION, 
							'date_debut' 	=> $date_debut, 
							'date_fin' 		=> $date_fin, 
							'descr_gene' 	=> $value->attributes->DESCR_GENE1, 
							'descr_ge_1' 	=> $value->attributes->DESCR_GENE2,
							'descr_ge_2' 	=> $value->attributes->DESCR_GENE3,
						);
		}

		$retour['travaux'] = $result;

		retour('liste des travaux', TRUE, $retour);	
	}

}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */