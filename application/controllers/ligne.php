<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ligne extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index($id_ligne = FALSE, $direction = 0)
	{
		//$this->output->enable_profiler(TRUE);

		if( ! isset($id_ligne) || $id_ligne === FALSE ){
			show_404();
		}

		$data['ligne'] 				= $this->lignes_model->get($id_ligne);

		$data['arrets'] 			= $this->lignes_model->get_arrets($id_ligne, $direction);

		if( $data['ligne'] === FALSE){
			show_404();
		}		

		$data['head'] 				= $this->load->view('structure/header', $data, TRUE);
		$data['footer'] 			= $this->load->view('structure/footer', $data, TRUE);
		$data['scripts'] 			= $this->load->view('structure/scripts', $data, TRUE);
		
		$this->load->view('ligne/ligne', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */