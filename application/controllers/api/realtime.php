<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Realtime extends CI_Controller {

	public function bus()
	{
		$arrets = $this->realtime_model->get();
		
		retour('bus temps reel', TRUE, array('bus' => $arrets));
	}

}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */