<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
  *
  * @author Fabrice Simonet <fabrice.simonet@prodaction.com>
  *
  * @version 0.1
  *
 */

class Sncf_arrets_model extends CI_Model {

	function get_liste_region()
	{
		$geoc['lat']	= "48.6855064";
		$geoc['long']	= "6.2057226";
		$geoc['km']		= "75";

		$this->db->select("*, ( 6371 * acos( cos( radians('".$geoc['lat']."') ) * cos( radians( stop_lat ) ) * cos( radians( stop_lon ) - radians('".$geoc['long']."') ) + sin( radians('".$geoc['lat']."') ) * sin( radians( stop_lat ) ) ) ) AS distance");
		$this->db->from('sncf_stops');
		$this->db->having("distance < '".$geoc['km']."'");
		$this->db->order_by('distance');

		$query = $this->db->get();

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

	function get_liste()
	{
		$query = $this->db->get('sncf_stops');

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
		$query = $this->db->get_where('sncf_stops', array('stop_id' => $id));

		if ($query->num_rows() > 0)
		{
			$row = $query->row();

			return $row;
		}

		return FALSE;		
	}

	/**
	 * Affiche les informations de l'arret ainsi que la route à laquel il appartient
	 */
	function get_stop($id)
	{
		$query = $this->db->query('SElECT * FROM (
									   SELECT stop_id, stop_name, stop_lat, stop_lon 
									   FROM sncf_stops WHERE stop_id = "'.$id.'"
									) a INNER JOIN (
									   select st.stop_id, GROUP_CONCAT( distinct rt.route_short_name) as sncf_routes
									   from sncf_routes rt, sncf_trips tr, sncf_stop_times st
									   where rt.route_id = tr.route_id
									   and tr.trip_id = st.trip_id
									   and st.stop_id = "'.$id.'"
									) b ON a.stop_id = b.stop_id');

		if ($query->num_rows() > 0)
		{
			$row = $query->row();

			return $row;
		}

		return FALSE;		
	}

	/**
	 * route_id
	 */
	function get_arrets($id, $direction = 1)
	{
		$this->db->select('sncf_trips.trip_id, sncf_routes.route_color');
		$this->db->from('sncf_trips');
		$this->db->join('sncf_routes', 'sncf_routes.route_id = sncf_trips.route_id');
		$this->db->where('sncf_trips.route_id = "'.$id.'" AND sncf_trips.direction_id = '.$direction.' LIMIT 1');

		$query = $this->db->get();

		if ($query->num_rows() > 0)
		{
			$row = $query->result();

			
			$trips 	= $this->chemin($row[0]->trip_id);

			$chemin['arrets']	= $trips;

			$nb = count($trips)-1;

			if($direction == 0){
				$chemin['aller']['name'] 	= $trips[$nb]->stop_name;
				$chemin['aller']['value'] 	= 0;

				$chemin['retour']['name'] 	= $trips[0]->stop_name;
				$chemin['retour']['value'] 	= 1;
			}else{
				$chemin['aller']['name'] 	= $trips[0]->stop_name;
				$chemin['aller']['value'] 	= 0;

				$chemin['retour']['name'] 	= $trips[$nb]->stop_name;
				$chemin['retour']['value'] 	= 1;
			}

			$chemin['color'] 	= $row[0]->route_color;

			return $chemin;
		}
	}

	function chemin($trip_id)
	{
		$this->db->select('*');
		$this->db->from('sncf_stop_times');
		$this->db->join('sncf_stops', 'sncf_stops.stop_id = sncf_stop_times.stop_id');
		$this->db->where('sncf_stop_times.trip_id = "'.$trip_id.'"');
		$this->db->order_by("stop_sequence");

		$query = $this->db->get();

		if ($query->num_rows() > 0)
		{
            foreach ($query->result() as $row)
            {
            	$info 						= new stdClass();
            	$info->stop_id 				= $row->stop_id;
            	$info->stop_sequence 		= $row->stop_sequence;
            	$info->shape_dist_traveled 	= $row->shape_dist_traveled;
            	$info->stop_name 			= $row->stop_name;
            	$info->stop_lat 			= $row->stop_lat;
            	$info->stop_lon 			= $row->stop_lon;        	

                $result[] 		= $info;
            }

            return $result;
		}	
	}
}