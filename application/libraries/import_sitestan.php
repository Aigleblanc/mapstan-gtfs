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

class import_sitestan
{
	var $CI;

	function __construct()
	{
		$this->CI =& get_instance();
		//$this->CI->load->library('dmcloud');
	}

	function import_arret($ligne, $sens)
	{
		$url 	= "http://www.reseau-stan.com/WebServices/RestService/api/map/v1/GetStopPointsByLineDirection/json?UID=STAN&idLine=".$ligne."&direction=".$sens."&langId=1";
		$retour = file_get_contents($url);

		$json 	= json_decode($retour);

		$ordre = 1;
		foreach ($json as $key => $item) {
			$directionname = NULL;
			foreach ($item->ListLines as $key => $arrets) {
				if($arrets->Direction === $sens && $arrets->Id === (Int)$ligne)
				{
					$directionname = $arrets->DirectionName;
				}
			}
			$this->CI->parse_model->add_arret($ligne, $sens, $item, $ordre, $directionname);
			$ordre++;
		}

    }

    function import_horaire($date, $lign_id, $arret_id, $sens)
    {
		$page = 'http://www.reseau-stan.com/horaires/arret/index.asp?rub_code=28&laDate='.$date.'&lheure=&laminute=&pointDep=&lign_id='.$lign_id.'&pa_id='.$arret_id.'&sens='.$sens;

		$doc 	= new DOMDocument();

		if (!@$doc->loadHTMLFile($page)) {
        	return FALSE;
		}
		
		$tableau 	= $doc->getElementsByTagName('tbody')->item(0);

		if (is_null($tableau)) {
			return FALSE;
		}

		$colonne 	= $tableau->getElementsByTagName('tr')->item(0);

		if (is_null($colonne)) {
			return FALSE;
		}	

		$heures 	= $colonne->getElementsByTagName('td');

		if (is_null($heures)) {
			return FALSE;
		}

		$i = 5;
		foreach ($heures as $heure) {
			$heure_matche = $doc->saveHTML($heure);
			preg_match_all('/<div style=\"background-color: #;\">([0-9]+)<span class=\"hidden\">/', $heure_matche, $matches);
			$horaire[$i] = $matches[1];
			//var_dump($horaire[$i]);
			$i++;
		}

		return $horaire;
    }


	
}