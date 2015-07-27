<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Autopis extends CI_Controller {

	public function index()
	{
		$autopis['autopis'] = $this->autopis_model->get_liste();

		retour('liste des voitures de location Autopi', TRUE, $autopis);
	}

}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */