<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
  *
  * @author Fabrice Simonet <fabrice.simonet@prodaction.com>
  *
  * @version 0.1
  *
 */

class Parking_model extends CI_Model {

	function get_liste()
	{
		$query = $this->db->get('extra_parking_nancy');

		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$result[] = $row;
			}

			return $result;
		}

		return FALSE;		
	}

	function get($id)
	{
		$query = $this->db->get_where('extra_parking_nancy', array('id' => $id));

		if ($query->num_rows() > 0)
		{
			$row = $query->row();

			return $row;
		}

		return FALSE;		
	}

	function import()
	{
		$parkings = json_decode(file_get_contents("https://geoservices.grand-nancy.org/arcgis/rest/services/public/VOIRIE_Parking/MapServer/0/query?text=&geometry=&geometryType=esriGeometryEnvelope&inSR=&spatialRel=esriSpatialRelIntersects&relationParam=&objectIds=&where=1%3D1&time=&returnIdsOnly=false&returnGeometry=true&maxAllowableOffset=&outSR=4326&outFields=objectid%2C+nom%2C+adresse%2C+places%2C+capacite%2C+complet%2C+ferme%2C+ouvert&f=pjson"));

		foreach ($parkings->features as $value) {

			//$geo  = $this->geo_gps->lamber_to_latlon($value->geometry->x, $value->geometry->y);

			$data = array(
						'lat' 			=> $value->geometry->y,
						'lng' 			=> $value->geometry->x,
						'id' 			=> $value->attributes->OBJECTID,
						'nom' 			=> $value->attributes->NOM, 
						'adresse' 		=> $value->attributes->ADRESSE, 
						'places' 		=> $value->attributes->PLACES, 
						'capacite' 		=> $value->attributes->CAPACITE,
			);

			$this->db->insert('extra_parking_nancy', $data);

		}		
	}	

}
