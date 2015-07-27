<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
  *
  * @author Fabrice Simonet <fabrice.simonet@prodaction.com>
  *
  * @version 0.1
  *
 */

class Arrets_model extends CI_Model {

	function get_liste()
	{
		$query = $this->db->get('stan_stops');

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
		$query = $this->db->get_where('stan_stops', array('stop_id' => $id));

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
									   FROM stan_stops WHERE stop_id = '.$id.'
									) a INNER JOIN (
									   select st.stop_id, GROUP_CONCAT( distinct rt.route_short_name) as stan_routes
									   from stan_routes rt, stan_trips tr, stan_stop_times st
									   where rt.route_id = tr.route_id
									   and tr.trip_id = st.trip_id
									   and st.stop_id = '.$id.'
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
		$this->db->select('stan_trips.trip_id, stan_routes.route_color');
		$this->db->from('stan_trips');
		$this->db->join('stan_routes', 'stan_routes.route_id = stan_trips.route_id');
		$this->db->where('stan_trips.route_id = '.$id.' AND stan_trips.direction_id = '.$direction.' LIMIT 1');

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
		$this->db->from('stan_stop_times');
		$this->db->join('stan_stops', 'stan_stops.stop_id = stan_stop_times.stop_id');
		$this->db->where('stan_stop_times.trip_id = "'.$trip_id.'"');
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


	function get_arrets_test($id, $direction = 1)
	{
		$date 			= date("Y-m-d");
		$jour_semaine 	= get_DayWeek($date, 'en');

		$this->db->select('stan_trips.trip_id, stan_routes.route_color');
		$this->db->from('stan_trips');
		$this->db->join('stan_routes', 'stan_routes.route_id = stan_trips.route_id');
		$this->db->join('stan_calendar', 'stan_calendar.service_id = stan_trips.service_id');
		
		$this->db->where('stan_trips.route_id = '.$id.' AND stan_trips.direction_id = '.$direction.' AND stan_calendar.'.$jour_semaine.'=1');

		$query = $this->db->get();

		if ($query->num_rows() > 0)
		{
		    foreach ($query->result() as $row)
            {
				var_dump($row->trip_id);
			}
		}
	}

	function update_titre()
	{
		$query = $this->db->get('stan_stops');

		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$name = ucfirst(strtolower($row->stop_name));
				$array = array( 'stop_name'	=> $name);

				$this->db->where('stop_id', $row->stop_id);
				$this->db->update('stan_stops', $array);				
			}
		}
	}

}