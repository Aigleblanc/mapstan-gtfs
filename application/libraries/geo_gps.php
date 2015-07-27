<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Parser Média
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 *
 * @author 		Fabrice Simonet
 * @version 	1.0
 * @license 	CeCile v2.1
 * @link 		http://www.cecill.info/licences/Licence_CeCILL_V2.1-fr.html
 * $geo  = $this->geo_gps->lamber_to_latlon($value->geometry->x, $value->geometry->y);
 * $geo1 = $this->geo_gps->latlon_to_lamber($geo['lat'], $geo['lon']);
 *
 */

class geo_gps
{
	var $CI;
	var $_config;

	function __construct()
	{
		$this->CI =& get_instance();

		require 		APPPATH.'libraries/math/GeographicPoint/Lambert.php';
		require_once 	APPPATH.'libraries/math/GeographicPoint/Lambert/Config.php';

		$config = new Math_GeographicPoint_Lambert_Config;

		$config->second_parallel 		= 49; // 38 40'
		$config->first_parallel 		= 44; // 33 20'
		$config->longitude_of_origin 	= 3;
		$config->latitude_of_origin 	= 46.5;
		$config->false_easting 			= 700000;
		$config->false_northing 		= 6600000;

		$this->_config = $config;

	}

	public function latlon_to_lamber($lat, $lon)
	{
		$lambert 			= new Math_GeographicPoint_LatitudeLongitude($lat, $lon);

		$geo['northing'] 	= $lambert->toLambert($this->_config)->getNorthing();
		$geo['easting'] 	= $lambert->toLambert($this->_config)->getEasting();

		return $geo;
	}

	public function lamber_to_latlon($easting, $northing)
	{
		$latlong 	= new Math_GeographicPoint_Lambert($easting, $northing, $this->_config);

		$geo['lat'] = $latlong->toLatitudeLongitude()->getLatitude();
		$geo['lon'] = $latlong->toLatitudeLongitude()->getLongitude();

		return $geo;
	}
	
}