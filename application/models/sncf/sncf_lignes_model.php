<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
  *
  * @author Fabrice Simonet <fabrice.simonet@prodaction.com>
  *
  * @version 0.1
  *
 */

class Sncf_lignes_model extends CI_Model {

	function get_liste($limite = FALSE, $offset = FALSE)
	{
		if($limite !== FALSE && $offset !== FALSE)
		{
			$this->db->limit($limite, $offset);
		}

		//$this->db->order_by('ordre');
		$query = $this->db->get('sncf_routes');

		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$direction 		= $this->sncf_arrets_model->get_arrets($row->route_id, 0);

				$info 			= $row;
				$info->aller 	= $direction['aller'];
				$info->retour 	= $direction['retour'];

				$result[] 	= $info;
			}

			return $result;
		}

		return FALSE;		
	}

	function get($id)
	{
		$query = $this->db->get_where('sncf_routes', array('route_short_name' => $id));

		if ($query->num_rows() > 0)
		{
			$row = $query->row();

			return $row;
		}

		return FALSE;		
	}

	function get_id($id)
	{
		$query = $this->db->get_where('sncf_routes', array('route_id' => $id));

		if ($query->num_rows() > 0)
		{
			$row = $query->row();

			return $row;
		}

		return FALSE;		
	}
}
