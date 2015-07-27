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

class import_kml
{
	var $CI;
	var $_src = "files_default/";
	var $_table;

	function __construct()
	{
		$this->CI =& get_instance();
		//$this->CI->load->library('dmcloud');
	}

	public function autopi()
	{
		$this->_table 	= "add_autopi";
		$file 			= 'AUTOPI_KML.kml';

		$this->import($file);	
	}

	public function velo()
	{
		$this->_table 	= "add_velo";
		$file 			= 'VELO_STATION_KML.kml';

		$this->import($file);
	}

	private function load_file($fichier)
	{
		$file = ROOT.$this->_src.$fichier;
		if (file_exists($file)) {
		    $xml = simplexml_load_file($file);

		    return $xml;
		}
	}	

	public function import($file)
	{
		$array = $this->load_file($file);

		foreach ($array->Document->Folder->Placemark as $key => $value) {
			$donnee['id'] = $value['id'];

			foreach ($value->ExtendedData->SchemaData->SimpleData as $SimpleData) {
			    $val 			= (String)$SimpleData;
			    $inf  			= (String)$SimpleData['name'][0];
			    $infos_tab[] 	= array($inf => $val);
			} 

			$donnee['infos'] = $infos_tab;
			unset($infos_tab);

			$coordonees = explode(",", $value->Point->coordinates);

			$donnee['coordonees'] = array('lat' => $coordonees[0], 'long' => $coordonees[1]);	
			
			$table  = $this->_table;
			$retour = $this->CI->parse_model->$table($donnee);
		}


		return $retour;
	}
	
}