<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Statistique extends CI_Controller {

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
	public function index()
	{
		$data['page'] = "home";

		$data['lignes'] 		= $this->lignes_model->get_liste();

		$data['nb_retard'] 		= $this->stats_model->nb_rapport('retard');
		$data['nb_avance'] 		= $this->stats_model->nb_rapport('avance');
		$data['nb_incident'] 	= $this->stats_model->nb_rapport('incident');
		$data['nb_never'] 		= $this->stats_model->nb_rapport('never');
		$data['nb_surpop'] 		= $this->stats_model->nb_rapport('surpop');
		$data['nb_pasarret'] 	= $this->stats_model->nb_rapport('pasarret');
		$data['nb_controleur'] 	= $this->stats_model->nb_rapport('controleur');
		$data['nb_autre'] 		= $this->stats_model->nb_rapport('autre');
		$data['nb_compliment'] 	= $this->stats_model->nb_rapport('compliment');
		$data['nb_accident'] 	= $this->stats_model->nb_rapport('accident');
		$data['nb_bugcoord'] 	= $this->stats_model->nb_rapport('bugcoord');

		$data['nb_total'] 		= $this->stats_model->nb_rapport_total();
		$data['nb_validation'] 	= $this->stats_model->nb_rapport_validation();

		$lignes = $this->lignes_model->get_liste();

		$i = 1;
		foreach ($lignes as $ligne)
		{
			if($i === 20){
				break;
			}
			$retard[] = $this->stats_model->nb_rapport_by_ligne('retard', $ligne->route_id);
			$avance[] = $this->stats_model->nb_rapport_by_ligne('avance', $ligne->route_id);
			$never[]  = $this->stats_model->nb_rapport_by_ligne('never', $ligne->route_id);

			$i++;
		}

		$r = "";
		foreach ($retard as $value) {
			 $r .= $value.',';
		}
		$a = "";
		foreach ($avance as $value) {
			$a .= $value.',';
		}
		$n = "";
		foreach ($never as $value) {
			$n .= $value.',';
		}

		$data['ligne_retard'] = rtrim($r, ",");
		$data['ligne_avance'] = rtrim($a, ",");
		$data['ligne_never']  = rtrim($n, ",");

		unset($retard);
		unset($avance);
		unset($never);

		$i = 1;
		foreach ($lignes as $ligne)
		{
			if($i < 20){
				$i++;
				continue;
			}
	
			$retard[] = $this->stats_model->nb_rapport_by_ligne('retard', $ligne->route_id);
			$avance[] = $this->stats_model->nb_rapport_by_ligne('avance', $ligne->route_id);
			$never[]  = $this->stats_model->nb_rapport_by_ligne('never', $ligne->route_id);

			if($i === 24){
				break;
			}
			$i++;
		}

		$r = "";
		foreach ($retard as $value) {
			 $r .= $value.',';
		}
		$a = "";
		foreach ($avance as $value) {
			$a .= $value.',';
		}
		$n = "";
		foreach ($never as $value) {
			$n .= $value.',';
		}

		$data['ligne_p_retard'] = rtrim($r, ",");
		$data['ligne_p_avance'] = rtrim($a, ",");
		$data['ligne_p_never']  = rtrim($n, ",");

		unset($retard);
		unset($avance);
		unset($never);

		$i = 1;
		foreach ($lignes as $ligne)
		{
			if($i < 25){
				$i++;
				continue;
			}

			$retard[] = $this->stats_model->nb_rapport_by_ligne('retard', $ligne->route_id);
			$avance[] = $this->stats_model->nb_rapport_by_ligne('avance', $ligne->route_id);
			$never[]  = $this->stats_model->nb_rapport_by_ligne('never', $ligne->route_id);

			$i++;
		}

		$r = "";
		foreach ($retard as $value) {
			 $r .= $value.',';
		}
		$a = "";
		foreach ($avance as $value) {
			$a .= $value.',';
		}
		$n = "";
		foreach ($never as $value) {
			$n .= $value.',';
		}

		$data['ligne_s_retard'] = rtrim($r, ",");
		$data['ligne_s_avance'] = rtrim($a, ",");
		$data['ligne_s_never']  = rtrim($n, ",");		

		$data['head'] 			= $this->load->view('structure/header', $data, TRUE);
		$data['footer'] 		= $this->load->view('structure/footer', $data, TRUE);
		$data['scripts'] 		= $this->load->view('structure/scripts', $data, TRUE);
		
		$this->load->view('statistique', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */