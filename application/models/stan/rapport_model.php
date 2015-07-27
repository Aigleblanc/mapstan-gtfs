<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
  *
  * @author Fabrice Simonet <fabrice.simonet@prodaction.com>
  *
  * @version 0.1
  *
 */

class Rapport_model extends CI_Model {

	function add($info)
	{
		//var_dump($info); exit;

		$data = array(
					'id'			 => NULL,
					'id_ligne' 		 => $info['id_ligne'],
					'id_arret' 		 => $info['id_arret'],
					'nom_ligne' 	 => $info['nom_ligne'],
					'nom_arret' 	 => $info['nom_arret'],
					'sens' 	 		 => $info['sens'],
					'nom_sens' 	 	 => $info['nom_sens'],
					'type_probleme'  => $info['probleme'],
					'tps_retard' 	 => $info['tps_retard'],
					'tps_avance' 	 => $info['tps_avance'],
					'passage_heure'  => $info['heure'],
					'passage_minute' => $info['min'],
					'num_bus' 		 => $info['num_bus'],
					'email' 		 => $info['email'],
					'remarque' 		 => $info['remarque'],
					'date_publi' 	 => $info['date'],
					'valide' 		 => 0
				);

		return $this->db->insert('signalement_bus', $data);
	}

	function get($id)
	{
		$query = $this->db->get_where('signalement_bus', array('id' => $id, 'valide' => 1));

		if ($query->num_rows() > 0)
		{
			$row = $query->row();

			return $row;
		}

		return FALSE;
	}

}
