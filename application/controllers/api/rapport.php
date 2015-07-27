<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rapport extends CI_Controller {

	/**
	 * POST
	 *
	 * arguments : id_ligne, id_arret, probleme, nom_ligne, nom_arret, tps_retard, tps_avance, heure, min, email, remarque, date
	 *
	 */
	public function add()
	{
		$info = $this->input->post(NULL, TRUE);

		$erreur = FALSE;

		if($info['id_ligne'] === FALSE || empty($info['id_ligne']))
		{
			$erreur = TRUE;
			$retour['id_ligne'] = "";
		}
		if($info['id_arret'] === FALSE || empty($info['id_arret']))
		{
			$erreur = TRUE;
			$retour['id_arret'] = "";
		}
		if($info['probleme'] === FALSE || empty($info['probleme']) || $info['probleme'] === "null")
		{
			$erreur = TRUE;
			$retour['probleme'] = "";
		}

		if($erreur === TRUE)
		{
			retour('Merci de remplir les champs necessaire.', FALSE);
		}

		if( ! isset($info['nom_ligne']) || empty($info['nom_ligne']))
		{
			$info['nom_ligne'] = NULL;
		}
		if( ! isset($info['nom_arret'] ) || empty($info['nom_arret']))
		{
			$info['nom_arret'] = NULL;
		}
		if( ! isset($info['tps_retard'] ) || empty($info['tps_retard']))
		{
			$info['tps_retard'] = NULL;
		}
		if( ! isset($info['tps_avance'] ) || empty($info['tps_avance']))
		{
			$info['tps_avance'] = NULL;
		}		
		if( ! isset($info['heure']) || empty($info['heure']) || $info['heure'] === "h")
		{
			$info['heure'] = NULL;
		}
		if( ! isset($info['min'] )|| empty($info['min']) || $info['min'] === "min")
		{
			$info['min'] = NULL;
		}
		if( ! isset($info['num_bus'] ) || empty($info['num_bus']))
		{
			$info['num_bus'] = NULL;
		}
		if( ! isset($info['email'] ) || empty($info['email']))
		{
			$info['email'] = NULL;
		}
		if( ! isset($info['remarque']) || empty($info['remarque']))
		{
			$info['remarque'] = NULL;
		}
		if( ! isset($info['date']) || empty($info['date']))
		{
			$info['date'] = date('Y-m-d H:i:s',time());
		}else{

			$date = explose_date_fr($info['date']);
			$info['date'] = $date['annee'].'-'.$date['mois'].'-'.$date['jour'].' '.$date['h'].':'.$date['m'].':'.$date['s'];
		
			if($info['date'] > date('Y-m-d H:i:s',time()))
			{
				retour('Merci de ne pas anti-dater vos rapports.', FALSE);
			}
		}		

		$result = $this->rapport_model->add($info);

		if($result === TRUE)
		{

			$prob = array('retard', 'avance', 'never', 'pasarret', 'surpop', 'accident', 'controleur', 'compliment', 'remarque', 'incident');

			if(in_array($info['probleme'], $prob))
			{

				$numligne = explode("-",$info['nom_ligne']);

				$message = $info['nom_prob']." à l'arret ".$info['nom_arret']." ligne ".trim($numligne[0])." direction ".$info['nom_sens']." #ReseauStan";

				$connection = $this->twitteroauth->create();
				$data = array(
				    'status' => $message,
				);
				$result = $connection->post('statuses/update', $data);
			}

			retour('Votre rapport a bien été soumis.', TRUE, $info);
		}
		retour('erreur', FALSE, $info);
	}


}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */