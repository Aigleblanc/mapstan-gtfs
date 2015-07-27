<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mobile extends CI_Controller {

	public function index()
	{
		$data['page'] = "home";

		$data['arrets'] = $this->arrets_model->get_liste();
		$data['lignes'] = $this->lignes_model->get_liste();

		//$data['arrets'] = '';

		$data['head'] 				= $this->load->view('structure/header', $data, TRUE);
		$data['footer'] 			= $this->load->view('structure/footer', $data, TRUE);
		$data['scripts'] 			= $this->load->view('structure/scripts', $data, TRUE);
		
		$this->load->view('home', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */