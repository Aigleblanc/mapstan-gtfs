<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function import_velo()
	{
		//$this->velos_model->import();
	}

	public function import_parking()
	{
		//$this->parking_model->import();
	}

	public function maj()
	{
		$this->arrets_model->update_titre();
	}
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */