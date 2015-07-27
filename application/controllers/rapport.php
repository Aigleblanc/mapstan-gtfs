<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class rapport extends CI_Controller {

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
	public function index($id = FALSE)
	{
		if(!isset($id_rapport) && empty($id))
		{
			show_404();
		}

		$data['page'] 		= "rapport";

		$data['rapport'] 	= $this->rapport_model->get($id);

		if($data['rapport'] === FALSE)
		{
			show_404();
		}

		$data['head'] 				= $this->load->view('structure/header', $data, TRUE);
		$data['footer'] 			= $this->load->view('structure/footer', $data, TRUE);
		$data['scripts'] 			= $this->load->view('structure/scripts', $data, TRUE);
		
		$this->load->view('rapport', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */