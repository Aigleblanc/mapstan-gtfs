<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
  *
  * @author Fabrice Simonet <fabrice.simonet@prodaction.com>
  *
  * @version 0.1
  *
 */

class Horaires_model extends CI_Model {

	function get_liste($id_ligne, $id_arret, $sens, $jour)
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

		$sql = 'SELECT s.arrival_time
					FROM stan_routes r
					INNER JOIN stan_trips t ON t.route_id = r.route_id
					INNER JOIN stan_stop_times s ON s.trip_id = t.trip_id
					INNER JOIN stan_stops a ON s.stop_id = a.stop_id
					INNER JOIN stan_calendar c ON c.service_id = t.service_id
				WHERE c.start_date <= CURDATE() AND c.end_date >= CURDATE() 
				AND r.route_id = "'.$id_ligne.'" AND a.stop_id = "'.$id_arret.'" AND t.direction_id = "'.$sens.'" 
				AND '.$rq_day.' AND s.arrival_time >= "00:00:00" AND s.departure_time <= "28:00:00" ORDER BY s.arrival_time';

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

	function get_liste_current($id_ligne, $id_arret, $sens, $nb, $jour)
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

		$sql = 'SELECT 	s.arrival_time
					FROM stan_routes r
					INNER JOIN stan_trips t ON t.route_id = r.route_id
					INNER JOIN stan_stop_times s ON s.trip_id = t.trip_id
					INNER JOIN stan_stops a ON s.stop_id = a.stop_id
					INNER JOIN stan_calendar c ON c.service_id = t.service_id
				WHERE c.start_date <= CURDATE() AND c.end_date >= CURDATE() 
					AND r.route_id = "'.$id_ligne.'" AND a.stop_id = "'.$id_arret.'" AND t.direction_id = "'.$sens.'" 
					AND '.$rq_day.' AND s.arrival_time >= "'.$heure.'" ORDER BY s.arrival_time LIMIT '.$nb;

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
