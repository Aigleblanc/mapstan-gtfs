<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stats extends CI_Controller {

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
	public function arrets($id, $direction)
	{
		$arrets['arrets'] = $this->arrets_model->get_arrets($id, $direction);
		retour('liste des arrets', TRUE, $arrets);
	}

	public function ligne($id, $direction = 0)
	{
		$ligne['ligne'] = $this->lignes_model->get_arrets($id, $direction);
		retour('arrets de la ligne', TRUE, $ligne);
	}

	public function nb_rapport_by_ligne_total($id_ligne)
	{
		$retour = $this->stats_model->nb_rapport_by_ligne_total($id_ligne);
		retour('nb_rapport_by_ligne_total', TRUE, $retour);
	}

	public function nb_rapport_by_arret_total($id_arret)
	{
		$retour = $this->stats_model->nb_rapport_by_arret_total($id_arret);
		retour('nb_rapport_by_arret_total', TRUE, $retour);
	}

	public function nb_rapport_by_ligne($type, $id_ligne)
	{
		$retour = $this->stats_model->nb_rapport_by_arret_total($id_arret);
		retour('nb_rapport_by_ligne', TRUE, $retour);
	}

	public function nb_rapport_by_arret($type, $id_arret)
	{
		$retour = $this->stats_model->nb_rapport_by_arret_total($id_arret);
		retour('nb_rapport_by_arret', TRUE, $retour);
	}

	public function concentration()
	{
		$retour = $this->stats_model->concentration('retard');

		var_dump($retour);
	}

}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */