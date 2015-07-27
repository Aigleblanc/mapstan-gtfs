<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ligne extends CI_Controller {

	public function liste()
	{
		$lignes['lignes'] = $this->lignes_model->get_liste();

		retour('liste des lignes', TRUE, $lignes);
	}

	public function get_by_id($id)
	{
		$ligne['ligne'] = $this->lignes_model->get_id($id);

		retour('Information sur la ligne', TRUE, $ligne);
	}

	public function get_by_shortname($name)
	{
		$ligne['ligne'] = $this->lignes_model->get($name);

		retour('Information sur la ligne', TRUE, $ligne);
	}

	public function chemin($id = FALSE, $direction = FALSE)
	{
		if(!is_numeric($id) ||!is_numeric($direction))
		{
			retour('Merci de vous rapporter à la notice de l\'api', FALSE);
		}		

		$ligne['chemin'] = $this->lignes_model->get_chemin($id, $direction);

 		$json = '{"success": true, "msg": "chemin", "chemin" : '.$ligne['chemin'].'}';

		if(isset($_GET['callback'])){
			header('Access-Control-Allow-Origin: *');
			header('content-type: application/json; charset=utf-8');
			echo $_GET['callback'] . '('.$json.')';
		}else{
			header('Access-Control-Allow-Origin: *');
			header('content-type: application/json; charset=utf-8');
			echo $json;
		}

		//retour('Chemin de la ligne', TRUE, $ligne);
	}	

}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */