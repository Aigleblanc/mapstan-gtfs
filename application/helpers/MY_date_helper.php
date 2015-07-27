<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

if ( ! function_exists('explose_date'))
{
	/**
	  * Convertie un datetime UK en date FR
	  *
	  * @author Fabrice Simonet <fabrice.simonet@prodaction.com>
	  * @version 1
	  *
	  * @param date $date date
	  *
	  * @return array date format FR
	  *
	 */
	function explose_date($date)
	{
		$dh = explode(" ", $date);

		$d = explode("-", $dh[0]);
		$da['jour'] 	= $d[2];
		$da['mois'] 	= $d[1];
		$da['annee']	= $d[0];

		if(isset($dh[1]))
		{
			$time = explode(":", $dh[1]);
			$da['h'] = $time[0];
			$da['m'] = $time[1];
			$da['s'] = $time[2];
		}
		
		return $da;
	}
}

if ( ! function_exists('explose_date_fr'))
{
	/**
	  * Convertie un datetime UK en date FR
	  *
	  * @author Fabrice Simonet <fabrice.simonet@prodaction.com>
	  * @version 1
	  *
	  * @param date $date date
	  *
	  * @return array date format FR
	  *
	 */
	function explose_date_fr($date)
	{
		$dh = explode(" ", $date);

		$d = explode("-", $dh[0]);
		$da['jour'] 	= $d[0];
		$da['mois'] 		= $d[1];
		$da['annee']	= $d[2];

		if(isset($dh[1]))
		{
			$time = explode(":", $dh[1]);
			$da['h'] = $time[0];
			$da['m'] = $time[1];
			$da['s'] = $time[2];
		}
		
		return $da;
	}
}

if ( ! function_exists('heure_to_minute'))
{
	/**
	  * Convertie heure en minute
	  *
	  * @author Fabrice Simonet <fabrice.simonet@prodaction.com>
	  * @version 1
	  *
	  * @param date $date date
	  *
	  * @return array date format FR
	  *
	 */
	function heure_to_minute($time)
	{
		$time = explode(':', $time);
		return ($time[0]*60) + $time[1];
	}
}

if ( ! function_exists('date_mois_fr'))
{
	/**
	  * Recherche le nom du moi textuel depuis son numeric
	  *
	  * @author Fabrice Simonet <fabrice.simonet@prodaction.com>
	  * @version 1
	  *
	  * @param int $mois mois
	  *
	  * @return array moi
	  *
	 */
	function date_mois_fr($mois, $suffix = '')
	{
		$liste_mois = array('01' => 'janvier', '02' => 'fevrier', '03' => 'mars' , '04' => 'avril', '05' => 'mai', '06' => 'juin', '07' => 'juillet', '08' => 'aout', '09' => 'septembre', '10' => 'octobre', '11' => 'novembre', '12' => 'décembre' );
		$liste_cour = array('01' => 'jan', '02' => 'fev', '03' => 'mar' , '04' => 'avr', '05' => 'mai', '06' => 'juin', '07' => 'juil', '08' => 'aou', '09' => 'sept', '10' => 'oct', '11' => 'nov', '12' => 'déc' );

		if(array_key_exists($mois, $liste_mois))
		{
			$date['full']  = $liste_mois[$mois];
			$date['court'] = $liste_cour[$mois].$suffix;

			return $date;
		}

		return FALSE;
	}

}

if ( ! function_exists('date_fr_us'))
{
	/**
	  * Convertie une date du format FR au format US
	  *
	  * @author Fabrice Simonet <fabrice.simonet@prodaction.com>
	  * @version 1
	  *
	  * @param date $date date
	  *
	  * @return string date au format US
	  *
	 */
	function date_fr_us($date, $split = '-')
	{
		$d = explode($split, $date);
		$da['jour'] 	= $d[0];
		$da['moi'] 		= $d[1];
		$da['annee']	= $d[2];

		return $da['annee'].'-'.$da['moi'].'-'.$da['jour'];
	}
}

if ( ! function_exists('date_us_fr'))
{
	/**
	  * Convertie une date du format US au format FR
	  *
	  * @author Fabrice Simonet <fabrice.simonet@prodaction.com>
	  * @version 1
	  *
	  * @param date $date date
	  *
	  * @return string date au format FR
	  *
	 */
	function date_us_fr($date, $split = '-')
	{
		$d = explode($split, $date);
		$da['jour'] 	= $d[2];
		$da['moi'] 		= $d[1];
		$da['annee']	= $d[0];

		return $da['jour'].'-'.$da['moi'].'-'.$da['annee'];
	}	
}

if ( ! function_exists('date_compare'))
{
	/**
	  * Test si un événement est déjà passé ou non
	  *
	  * @author Fabrice Simonet <fabrice.simonet@prodaction.com>
	  * @version 1
	  *
	  * @param date $date 
	  *
	  * @return bool valide ou expiré
	  *
	 */
	function date_compare($date)
	{
		$now = date('Y-m-d');
		$expire = $date;
		 
		// format the 2 dates using DateTime
		$now 	= new DateTime( $now );
		$now 	= $now->format('Ymd');
		$expire = new DateTime( $expire );
		$expire = $expire->format('Ymd');

		return ($now < $expire)? "Evénement valide" : "Evénement expiré";
	}	
}

if ( ! function_exists('date_nbjours'))
{
	/**
	  * Nombre de jour restant entre la date donnée et la date actuelle
	  *
	  * @author Fabrice Simonet <fabrice.simonet@prodaction.com>
	  * @version 1
	  *
	  * @param date $date date
	  *
 	  * @return int nombre de jour
	  *
	 */
    function date_nbjours($date) {
        $nbSecondes= 60*60*24;
 
		$now = date('Y-m-d');

        $debut_ts 	= strtotime($now);
        $fin_ts 	= strtotime($date);
        $diff 		= $fin_ts - $debut_ts;

        return round($diff / $nbSecondes);
    }
}

if ( ! function_exists('isLundi'))
{
	function isLundi($date) {
	    return (date('N', strtotime($date)) == 1);
	}
}

if ( ! function_exists('isMardi'))
{
	function isMardi($date) {
	    return (date('N', strtotime($date)) == 2);
	}
}

if ( ! function_exists('isMercredi'))
{
	function isMercredi($date) {
	    return (date('N', strtotime($date)) == 3);
	}
}

if ( ! function_exists('isJeudi'))
{
	function isJeudi($date) {
	    return (date('N', strtotime($date)) == 4);
	}
}

if ( ! function_exists('isVendredi'))
{
	function isVendredi($date) {
	    return (date('N', strtotime($date)) == 5);
	}
}

if ( ! function_exists('isSamedi'))
{
	function isSamedi($date) {
	    return (date('N', strtotime($date)) == 6);
	}
}

if ( ! function_exists('isDimanche'))
{
	function isDimanche($date) {
	    return (date('N', strtotime($date)) == 7);
	}
}

if ( ! function_exists('isWeekend'))
{
	function isWeekend($date) {
	    return (date('N', strtotime($date)) >= 6);
	}
}

if ( ! function_exists('get_DayWeek'))
{
	function get_DayWeek($date, $lang = 'fr') {

		if($lang == 'fr')
		{
			$day[1] = "lundi";
			$day[2] = "mardi";
			$day[3] = "mercredi";
			$day[4] = "jeudi";
			$day[5] = "vendredi";
			$day[6] = "samedi";
			$day[7] = "dimanche";
		}elseif($lang == 'en') {
			$day[1] = "monday";
			$day[2] = "tuesday";
			$day[3] = "wednesday";
			$day[4] = "thursday";
			$day[5] = "friday";
			$day[6] = "saturday";
			$day[7] = "sunday";			
		}

		$day_current = date('N', strtotime($date));

	    return $day[$day_current];
	}
}

if ( ! function_exists('date_range'))
{
	/**
	  * Créer un tableau de table comprise entre deux dates données
	  *
	  * @author Fabrice Simonet <fabrice.simonet@prodaction.com>
	  * @version 1
	  *
	  * @param date $first date de debut
	  * @param date $last date de fin
	  * @param string $step ecart type
	  * @param string $format format date
	  *
	  * @return array dates
	  *
	 */
	function date_range($first, $last, $step = '+1 day', $format = 'Y-m-d') {

		$dates = array();
		$current = strtotime( $first );
		$last = strtotime( $last );

		if($current <= $last)
		{
			while( $current <= $last ) {

				$dates[] = date( $format, $current );
				$current = strtotime( $step, $current );
			}

			return $dates;
		}
		
		return FALSE;
	}
}

// ------------------------------------------------------------------------