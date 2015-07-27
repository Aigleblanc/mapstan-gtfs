<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
  *
  * @author Fabrice Simonet <fabrice.simonet@prodaction.com>
  *
  * @version 0.1
  *
 */

class Realtime_model extends CI_Model {

	function get()
	{
		$date 			= date("Y-m-d");
		$heure 			= date("H:i:s");

		//$heure 			= date('H:i:s', mktime(18, 0, 0, 0, 0, 0));

		$jour_semaine 	= get_DayWeek($date, 'en');
		$rq_day 		= "c.".$jour_semaine." = 1";
		$next_heure 	= date("H:i:s", strtotime("+2 min"));

		//$next_heure 	= date("H:i:s",  mktime(18, 2, 0, 0, 0, 0));

		$sql = 'SELECT 	r.route_id,
						r.route_short_name,
						r.route_long_name,
						r.route_color,
						t.trip_id,
						t.direction_id,
						s.arrival_time,
						s.departure_time,
						a.stop_id,
						s.stop_sequence,
						a.stop_name,
						a.stop_lat,
						a.stop_lon
					FROM stan_routes r
					INNER JOIN stan_trips t ON t.route_id = r.route_id
					INNER JOIN stan_stop_times s ON s.trip_id = t.trip_id
					INNER JOIN stan_stops a ON s.stop_id = a.stop_id
					INNER JOIN stan_calendar c ON c.service_id = t.service_id

				WHERE '.$rq_day.' AND s.arrival_time >= "'.$heure.'" AND s.departure_time <= "'.$next_heure.'"';

		$query = $this->db->query($sql);

		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$info		 			= $row;
				$info->jour 			= $jour_semaine;

				if(strtotime($row->arrival_time) === strtotime($heure))
				{
					$status = 'Sur place';
				}elseif(strtotime($row->arrival_time) > strtotime($heure)){
					$status = 'Arrive bientot';
				}

				$direction 					= $this->arrets_model->get_arrets($row->route_id, $row->direction_id);

				//$info->direction 			= array($direction['aller'], $direction['retour']);

				$info->direction            = ($row->direction_id == 0)? $direction['aller']['name'] : $direction['retour']['name']; 

				$next 						= $this->get_next_arret($row->trip_id, $row->direction_id, $row->stop_sequence+1);
				$info->next_arret 			= $next;
				$info->status 				= $status;

				$result[] 					= $info;
			}
			
			return $result;
		}

		return FALSE;		
	}

	function calcule_latlong($curent, $next)
	{
		$heure 			= date("H:i:s");
		//$heure 			= date('H:i:s', mktime(18, 0, 0, 0, 0, 0));


		if(strtotime($curent->arrival_time) > strtotime($heure) && !is_null($next[0])){	

			/*$dump['curent_arrival_time'] 	= $curent->arrival_time;
			$dump['next_arrival_time'] 	= $next[0]->arrival_time;
			$dump['next_heure_to_minute']  = heure_to_minute($next[0]->arrival_time);
			$dump['heure_heure_to_minute'] = heure_to_minute($curent->arrival_time);*/

			$ratio_a =  heure_to_minute($curent->arrival_time) - heure_to_minute($next[0]->arrival_time);
			$ratio_b =  heure_to_minute($curent->arrival_time) - heure_to_minute($heure);

			$ratio_time = $ratio_a / $ratio_b;

			$lat  = ($curent->stop_lat + $next[0]->stop_lat) / $ratio_time;
			$lon  = ($curent->stop_lon + $next[0]->stop_lon) / $ratio_time;

			if($ratio_time > 2){
				$lat = $lat + $curent->stop_lat;
				$lon = $lon + $curent->stop_lon;
			}

			$retour['lat']  = $lat;
			$retour['lon']  = $lon;

			return $retour;
		}

		return FALSE;
	}

	function get_next_arret($trip_id, $dir, $sequence)
	{
		$date 			= date("Y-m-d");
		$jour_semaine 	= get_DayWeek($date, 'en');
		$rq_day 		= "c.".$jour_semaine." = 1";

		$sql = 'SELECT 	t.trip_id,
						t.direction_id,
						s.arrival_time,
						s.departure_time,
						a.stop_id,
						s.stop_sequence,
						a.stop_name,
						a.stop_lat,
						a.stop_lon
					FROM stan_trips t 
					INNER JOIN stan_stop_times s ON s.trip_id = t.trip_id
					INNER JOIN stan_stops a ON s.stop_id = a.stop_id
					INNER JOIN stan_calendar c ON c.service_id = t.service_id

				WHERE '.$rq_day.' AND t.trip_id = "'.$trip_id.'" AND t.direction_id = "'.$dir.'" AND s.stop_sequence = "'.$sequence.'"';
				//WHERE '.$rq_day.' AND t.trip_id = "'.$trip_id.'" AND t.direction_id = "'.$dir.'" AND s.stop_sequence >= "'.$sequence.'" AND s.arrival_time != "00:00:00"';

		$query = $this->db->query($sql);

		if ($query->num_rows() > 0)
		{	
			return $query->result();
		}

		return FALSE;			
	}

}
