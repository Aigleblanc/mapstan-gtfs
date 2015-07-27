<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
  *
  * @author Fabrice Simonet <fabrice.simonet@prodaction.com>
  *
  * @version 0.1
  *
 */

class Stats_model extends CI_Model {

	/*
		retard
		avance
		incident
		never
		surpop
		pasarret
		autre
	*/
	function nb_rapport($type)
	{
		$query = $this->db->get_where('signalement_bus', array('type_probleme' => $type, 'valide' => 1));

		return $query->num_rows();
	}

	function nb_rapport_total()
	{
		$query = $this->db->get_where('signalement_bus', array('valide' => 1));

		return $query->num_rows();
	}	

	function nb_rapport_validation()
	{
		$query = $this->db->get_where('signalement_bus', array('valide' => 0));

		return $query->num_rows();
	}

	function nb_rapport_by_ligne($type, $id_ligne)
	{
		$query = $this->db->get_where('signalement_bus', array('type_probleme' => $type, 'id_ligne' => $id_ligne, 'valide' => 1));

		return $query->num_rows();
	}
	function nb_rapport_by_ligne_total($id_ligne)
	{
		$query = $this->db->get_where('signalement_bus', array('id_ligne' => $id_ligne, 'valide' => 1));

		return $query->num_rows();
	}

	function nb_rapport_by_arret($type, $id_arret)
	{
		$query = $this->db->get_where('signalement_bus', array('type_probleme' => $type, 'id_arret' => $id_arret, 'valide' => 1));

		return $query->num_rows();
	}

	function nb_rapport_by_arret_total($id_arret)
	{
		$query = $this->db->get_where('signalement_bus', array('id_arret' => $id_arret, 'valide' => 1));

		return $query->num_rows();
	}

	public function concentration($type)
	{
		//$query = $this->db->get_where('signalement_bus', array('type_probleme' => $type, 'valide' => 1));
		$sql = "SELECT *, COUNT(*) as compte FROM signalement_bus WHERE type_probleme = ? AND valide = ? GROUP BY id_arret";

		$query = $this->db->query($sql, array($type, 1)); 

		if ($query->num_rows() > 0)
		{
            foreach ($query->result() as $row)
            {
            	$reponse 			= $row;
            	$reponse->info 		= $this->arrets_model->get($row->id_arret);
            	$reponse->compte 	= $row->compte;

                $result[] 	= $reponse;
            }

            return $result;
		}

		return FALSE;
	}	
}
