<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
  *
  * @author Fabrice Simonet <fabrice.simonet@prodaction.com>
  *
  * @version 0.1
  *
 */

class Velos_model extends CI_Model {

	function get_liste()
	{
		$query = $this->db->get('extra_velo_nancy');

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
		$query = $this->db->get_where('extra_velo_nancy', array('num_station' => $id));

		if ($query->num_rows() > 0)
		{
			$row = $query->row();

			return $row;
		}

		return FALSE;		
	}

	function import()
	{
		$velos = json_decode(file_get_contents("https://api.jcdecaux.com/vls/v1/stations?contract=Nancy&apiKey=2ebd97b70c5dd5be57469b611c538c0d0789e9fe"));

		foreach ($velos as $key => $velo) {
			$data = array(
						'id' 			=> NULL,
						'nom' 			=> $velo->name,
						'num_station' 	=> $velo->number,
						'adresse' 		=> $velo->address,
						'nb_velo' 		=> $velo->bike_stands,
						'lat' 			=> $velo->position->lat,
						'lon' 			=> $velo->position->lng
			);

			$this->db->insert('extra_velo_nancy', $data);

		}		
	}	

}
