<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sncf extends CI_Controller {

	public function liste_arret()
	{
		$arrets['arrets'] = $this->sncf_arrets_model->get_liste_region();

		retour('liste des arrets en Lorraine', TRUE, $arrets);
	}

	public function realtime()
	{
		$trains['trains'] = $this->sncf_realtime_model->get();

		retour('liste des trains en Lorraine', TRUE, $trains);
	}	

	public function get_by_arret($id_arret, $jour = NULL)
	{
		$horaires['horaires'] = $this->sncf_horaires_model->get_liste($id_arret, $jour);

		retour('Horaire à l\'arret', TRUE, $horaires);
	}

	public function get_by_arret_current($id_arret, $nb, $jour = NULL)
	{
		$horaires['horaires'] = $this->sncf_horaires_model->get_liste_current($id_arret, $nb, $jour);

		retour('Horaire à l\'arret', TRUE, $horaires);
	}
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */