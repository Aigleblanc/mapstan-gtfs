<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Arret extends CI_Controller {

	public function liste()
	{
		$arrets['arrets'] = $this->arrets_model->get_liste();

		retour('liste des arrets', TRUE, $arrets);
	}

	public function get($id = FALSE)
	{
		if(!is_numeric($id))
		{
			retour('Merci de vous rapporter à la notice de l\'api', FALSE);
		}

		$ligne['arret'] = $this->arrets_model->get($id);

		retour('Information sur l\'arret', TRUE, $ligne);
	}

	public function get_arrets($id = FALSE, $direction = FALSE)
	{
		if(!is_numeric($id) ||!is_numeric($direction))
		{
			retour('Merci de vous rapporter à la notice de l\'api', FALSE);
		}

		$chemin = $this->arrets_model->get_arrets($id, $direction );
	
		retour('Arrets de la ligne', TRUE, $chemin);
	}

	public function get_arrets_test($id = FALSE, $direction = FALSE)
	{

		$chemin = $this->arrets_model->get_arrets_test($id, $direction );
	
		var_dump($chemin);
	}	

	public function chemin($trip_id = FALSE)
	{

		$chemin = $this->arrets_model->chemin($trip_id);
	
		var_dump($chemin);
	}	


}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */