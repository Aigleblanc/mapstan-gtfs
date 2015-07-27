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
 *
 */

class import_gtfs
{
	var $CI;
	var $_src = "files_default/";

	function __construct()
	{
		$this->CI =& get_instance();
		//$this->CI->load->library('dmcloud');
	}

	private function url($url)
	{
		$result = ROOT.$this->_src.$url;

		return $result;
	}

	private function load_file_txt($url)
	{
		$i 		= 1;
		$row 	= 0;
		if (($handle = fopen($url, "r")) !== FALSE) {
		    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 
		    {
		    	unset($ligne);
		    	$num = count($data);
				for ($c=0; $c < $num; $c++) 
				{
				    $ligne[] = $data[$c];
				}
				
				$table[$row] = $ligne;
		    	
		        $i++;
		        $row++;
		    }
		    fclose($handle);

		    unset($table[0]);

		    return $table;
		}
		return FALSE;
	}


	public function import_agency()
	{
		$file = "agency.txt";

		$array = $this->load_file_txt($this->url($file));
		$retour = $this->CI->parse_model->import_agency($array);

		return $retour;
	}

	public function import_calendar()
	{
		$file = "calendar.txt";
		
		$array = $this->load_file_txt($this->url($file));
		$retour = $this->CI->parse_model->import_calendar($array);

		return $retour;
	}

	public function import_calendar_dates()
	{
		$file = "calendar_dates.txt";
		
		$array = $this->load_file_txt($this->url($file));
		$retour = $this->CI->parse_model->import_calendar_dates($array);

		return $retour;
		return $array;
	}

	public function import_feed_info()
	{
		$file = "feed_info.txt";
		
		$array = $this->load_file_txt($this->url($file));
		$retour = $this->CI->parse_model->import_feed_info($array);

		return $retour;
		return $array;
	}

	public function import_routes()
	{
		$file = "routes.txt";
		
		$array = $this->load_file_txt($this->url($file));
		$retour = $this->CI->parse_model->import_routes($array);

		return $retour;
	}

	public function import_stops()
	{
		$file = "stops.txt";

		$array 	= $this->load_file_txt($this->url($file));
		$retour = $this->CI->parse_model->import_stops($array);

		return $retour;
	}

	public function import_stop_times()
	{
		$file = "stop_times.txt";

		$array  = $this->load_file_txt($this->url($file));
		$retour = $this->CI->parse_model->import_stop_times($array);

		return $retour;
	}
	
	public function import_trips()
	{
		$file = "trips.txt";

		$array  = $this->load_file_txt($this->url($file));
		$retour = $this->CI->parse_model->import_trips($array);

		return $retour;
	}
	
}