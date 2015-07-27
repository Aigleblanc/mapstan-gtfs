<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Velo extends CI_Controller {

	public function rt_liste()
	{
		$velos['velos'] = json_decode(file_get_contents("https://api.jcdecaux.com/vls/v1/stations?contract=Nancy&apiKey=2ebd97b70c5dd5be57469b611c538c0d0789e9fe"));

		retour('liste des velos', TRUE, $velos);
	}

	public function rt_get($id)
	{
		$velos['velos'] = json_decode(file_get_contents("https://api.jcdecaux.com/vls/v1/stations/".$id."?contract=Nancy&apiKey=2ebd97b70c5dd5be57469b611c538c0d0789e9fe"));

		retour('Information de la sation', TRUE, $velos);
	}

	public function liste()
	{
		$velos['velos'] = $this->velos_model->get_liste();

		retour('liste des velos', TRUE, $velos);
	}

	public function get($id)
	{
		$velo['velo'] = $this->velos_model->get($id);

		retour('Velo', TRUE, $velo);
	}

}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */