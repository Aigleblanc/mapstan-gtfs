<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
  *
  * @author Fabrice Simonet <fabrice.simonet@prodaction.com>
  *
  * @version 0.1
  *
 */

class Sncf_horaires_model extends CI_Model {

	function get_liste($id_arret, $jour = NULL)
	{

		$day['Lu'] = "monday";
		$day['Ma'] = "tuesday";
		$day['Me'] = "wednesday";
		$day['Je'] = "thursday";
		$day['Ve'] = "friday";
		$day['Sa'] = "saturday";
		$day['Di'] = "sunday";

		if($jour === NULL)
		{
			$date 			= date("Y-m-d");
			$jour_semaine 	= get_DayWeek($date, 'en');
			$rq_day 		= "c.".$jour_semaine." = 1";
		}else{
			$rq_day 		= "c.".$day[$jour]." = 1";
		}

		$sql = 'SELECT * 
					FROM sncf_routes r
					INNER JOIN sncf_trips t ON t.route_id = r.route_id
					INNER JOIN sncf_stop_times s ON s.trip_id = t.trip_id
					INNER JOIN sncf_stops a ON s.stop_id = a.stop_id
					INNER JOIN sncf_calendar c ON c.service_id = t.service_id
				WHERE a.stop_id = "'.urldecode($id_arret).'" 
					AND '.$rq_day.' AND s.arrival_time >= "00:00:00" AND s.departure_time <= "28:00:00" ORDER BY t.direction_id, s.arrival_time';

		$query = $this->db->query($sql);

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

	function get_liste_current($id_arret, $nb, $jour)
	{

		$day['Lu'] = "monday";
		$day['Ma'] = "tuesday";
		$day['Me'] = "wednesday";
		$day['Je'] = "thursday";
		$day['Ve'] = "friday";
		$day['Sa'] = "saturday";
		$day['Di'] = "sunday";

		$heure 	   = date("H:i:s");

		if($jour === NULL)
		{
			$date 			= date("Y-m-d");
			$jour_semaine 	= get_DayWeek($date, 'en');
			$rq_day 		= "c.".$jour_semaine." = 1";
		}else{
			$rq_day 		= "c.".$day[$jour]." = 1";
		}

		// Si retour d'heure a zero, on boucle pour choper le stop sequence d'avant
		//stop_sequence 

		$sql = 'SELECT * 
					FROM sncf_routes r
					INNER JOIN sncf_trips t ON t.route_id = r.route_id
					INNER JOIN sncf_stop_times s ON s.trip_id = t.trip_id
					INNER JOIN sncf_stops a ON s.stop_id = a.stop_id
					INNER JOIN sncf_calendar c ON c.service_id = t.service_id
				WHERE a.stop_id = "'.urldecode($id_arret).'"  
					AND '.$rq_day.' AND s.arrival_time >= "'.$heure.'" ORDER BY t.direction_id, s.arrival_time LIMIT '.$nb;

		$query = $this->db->query($sql);

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
}
