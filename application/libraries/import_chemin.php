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

class import_chemin
{
	var $CI;
	var $_src = "static/kml/";
	var $_table;

	function __construct()
	{
		$this->CI =& get_instance();
	}

	public function chemin()
	{
		$this->_table 	= "add_autopi";
		$file 			= 'Plans_Lignes_Bus_Stan_2014-01_01.xml';

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

		foreach ($array->Document->Folder as $key => $value) {

			$infos_tab = array();
			foreach ($value->Placemark->ExtendedData->SchemaData->SimpleData as $SimpleData) {
			    $val 			= (String)$SimpleData[0];
			    $infos_tab[] 	= array($val);
			} 

			$short_name 	= $infos_tab[0][0];
			$id_ligne	 	= $infos_tab[1][0];
			$sens		 	= $infos_tab[2][0];


			$coords = (String)$value->Placemark->LineString->coordinates;

			$coord = explode(" ", $coords);

			$coo = array();
			foreach ($coord as $item) {
				$c = explode(",", $item);

				if( ! empty($c[0]))
				{
					$coo[] = array('lat' => $c[1], 'lon' => $c[0]);
				}
			}

			$route = json_encode($coo);

			if($sens == 'Aller')
			{
				$senss = 0;
			}else{
				$senss = 1;
			}

			$data = array(
						'id' 				=> NULL,
						'route_id' 			=> $id_ligne,
						'route_short_name' 	=> $short_name,
						'route' 			=> $route,
						'sens' 				=> $senss
			);
			var_dump($short_name);

			$this->CI->db->insert('stan_chemin', $data);
		}


		
	}
	
}