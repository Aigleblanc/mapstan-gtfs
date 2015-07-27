<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

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
	 * So any other public methods not prefixedclient with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$data['page'] 				= "admin-home";
		$data['page_grp'] 			= "admin";

		$data['meta_title'] 		= "Admin";
		$data['meta_description'] 	= "Admin";

		$data['demo'] 				= "";

		$data['head'] 				= $this->load->view('admin/structure/header', $data, TRUE);
		$data['footer'] 			= $this->load->view('admin/structure/footer', $data, TRUE);
		$data['scripts'] 			= $this->load->view('admin/structure/scripts', $data, TRUE);

		$this->load->view('admin/home');
	}
	
	public function login()
	{
		$data['page'] 				= "admin-home";
		$data['page_grp'] 			= "admin";

		$data['meta_title'] 		= "Admin";
		$data['meta_description'] 	= "Admin";

		$data['demo'] 				= "";

		$data['head'] 				= $this->load->view('admin/structure/header', $data, TRUE);
		$data['footer'] 			= $this->load->view('admin/structure/footer', $data, TRUE);
		$data['scripts'] 			= $this->load->view('admin/structure/scripts', $data, TRUE);

		$this->load->view('admin/login');		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */