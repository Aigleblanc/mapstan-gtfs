<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Horaire extends CI_Controller {

	public function get_by_arret($id_ligne, $id_arret, $sens, $jour = NULL)
	{

		if(!is_numeric((int)$id_arret) || !is_numeric((int)$sens))
		{
			retour('Merci de vous rapporter à la notice de l\'api', FALSE);
		}
		
		$horaires['horaires'] = $this->horaires_model->get_liste($id_ligne, $id_arret, $sens, $jour);


		retour('Horaire à l\'arret', TRUE, $horaires);
	}

	public function get_by_arret_current($id_ligne, $id_arret, $sens, $nb, $jour = NULL)
	{
		if(!is_numeric((int)$id_arret) || !is_numeric((int)$sens))
		{
			retour('Merci de vous rapporter à la notice de l\'api', FALSE);
		}

		$horaires['horaires'] = $this->horaires_model->get_liste_current($id_ligne, $id_arret, $sens, $nb, $jour);

		retour('Horaire à l\'arret', TRUE, $horaires);
	}

}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */