<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Import extends CI_Controller {

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

	public function __construct()
	{
		parent::__construct();
	}

/*

Id, jour ( S W V ), id_arret, id_ligne, heure (5:10)

*/

	public function arrets()
	{

		$liste_ligne = $this->lignes_model->get_liste();

		foreach ($liste_ligne as $key => $item) {
			$this->import_sitestan->import_arret($item->route_id, 1);
		}
		
		foreach ($liste_ligne as $key => $item) {
			$this->import_sitestan->import_arret($item->route_id, 2);
		}

	}

	public function update_horaire()
	{
		$jours = array('Se', 'Sa', 'Di');
		foreach ($jours as $k => $jour) {
			
			$liste_ligne = $this->lignes_model->get_liste();
			foreach ($liste_ligne as $key => $item) {
				
				$sens = 1;
				$liste_arrets = $this->arrets_model->get_arrets($item->route_id, $sens);
				foreach ($liste_arrets as $key1 => $arret) {	

					$horaires = $this->horaires_model->get_liste($item->route_id, $arret->id_arret, $sens, $jour);
					foreach ($horaires as $key2 => $time) {
						if(isset($liste_arrets[$key1+1]))
						{
							$next_time = $this->horaires_model->get_time($item->route_id, $liste_arrets[$key1+1]->id_arret, $sens, $jour, $time->heure);
							if($next_time !== FALSE)
							{
								$this->horaires_model->update_horaire($time->id_horaire, $item->route_id, $arret->id_arret, $sens, $jour, $next_time->id_arret, $next_time->heure);
							}
						}
						
					}
				}

				/*****************************/
				$sens = 2;
				$liste_arrets = $this->arrets_model->get_arrets($item->route_id, $sens);
				foreach ($liste_arrets as $key1 => $arret) {	

					$horaires = $this->horaires_model->get_liste($item->route_id, $arret->id_arret, $sens, $jour);
					foreach ($horaires as $key2 => $time) {
						if(isset($liste_arrets[$key1+1]))
						{
							$next_time = $this->horaires_model->get_time($item->route_id, $liste_arrets[$key1+1]->id_arret, $sens, $jour, $time->heure);
							if($next_time !== FALSE)
							{
								$this->horaires_model->update_horaire($time->id_horaire, $item->route_id, $arret->id_arret, $sens, $jour, $next_time->id_arret, $next_time->heure);
							}
						}
						
					}
				}	

			}

		}	
	}

	public function horaire_full()
	{
		//exit;

		//$this->parse_model->del_horaire();
		//exit;

		$liste_ligne = $this->lignes_model->get_liste();

		$date_dim 	  = '12%2F01%2F2014';
		$date_sam 	  = '11%2F01%2F2014';
		$date_sem 	  = '13%2F01%2F2014';
		$date_vac 	  = '13%2F01%2F2014';

/*
		// Aller en semaine
		foreach ($liste_ligne as $key => $item) {
			$liste_arrets = $this->arrets_model->get_arrets($item->route_id, 1);
			foreach ($liste_arrets as $key => $arret) {
			    $horaires = $this->import_sitestan->import_horaire($date_sem, $item->route_id, $arret->id_arret, 1);    
			    if($horaires !== FALSE)
			    {
			    	//echo "Insert > ligne : ".$item->route_id." arret : ".$arret->stop_id." sens 1 <br>";
				    foreach ($horaires as $heure => $heures) {
				    	foreach ($heures as $key => $minute) {
				    		$hour = $heure.':'.$minute;
							$this->parse_model->add_horaire($item->route_id, $arret->id_arret , 'Se', $hour, 1);
				    	}
				    }
				}else{
					echo "/!\ Erreur > ligne : ".$item->route_id." arret : ".$arret->id_arret." sens 1 <br>";
				}
			}
		}

		// Retour en semaine
		foreach ($liste_ligne as $key => $item) {
			$liste_arrets = $this->arrets_model->get_arrets($item->route_id, 2);
			foreach ($liste_arrets as $key => $arret) {
			    $horaires = $this->import_sitestan->import_horaire($date_sem, $item->route_id, $arret->id_arret, 2);    
			    if($horaires !== FALSE)
			    {
			    	//echo "Insert > ligne : ".$item->route_id." arret : ".$arret->id_arret." sens 1 <br>";
				    foreach ($horaires as $heure => $heures) {
				    	foreach ($heures as $key => $minute) {
				    		$hour = $heure.':'.$minute;
							$this->parse_model->add_horaire($item->route_id, $arret->id_arret , 'Se', $hour, 2);
				    	}
				    }
				}else{
					echo "/!\ Erreur > ligne : ".$item->route_id." arret : ".$arret->id_arret." sens 2 <br>";
				}
			}
		}
*/
/*
		// Aller en Dim
		foreach ($liste_ligne as $key => $item) {
			$liste_arrets = $this->arrets_model->get_arrets($item->route_id, 1);
			foreach ($liste_arrets as $key => $arret) {
			    $horaires = $this->import_sitestan->import_horaire($date_dim, $item->route_id, $arret->id_arret, 1);    
			    if($horaires !== FALSE)
			    {
			    	//echo "Insert > ligne : ".$item->route_id." arret : ".$arret->stop_id." sens 1 <br>";
				    foreach ($horaires as $heure => $heures) {
				    	foreach ($heures as $key => $minute) {
				    		$hour = $heure.':'.$minute;
							$this->parse_model->add_horaire($item->route_id, $arret->id_arret , 'Di', $hour, 1);
				    	}
				    }
				}else{
					echo "/!\ Erreur > ligne : ".$item->route_id." arret : ".$arret->id_arret." sens 1 <br>";
				}
			}
		}

		// Retour en Dim
		foreach ($liste_ligne as $key => $item) {
			$liste_arrets = $this->arrets_model->get_arrets($item->route_id, 2);
			foreach ($liste_arrets as $key => $arret) {
			    $horaires = $this->import_sitestan->import_horaire($date_dim, $item->route_id, $arret->id_arret, 2);    
			    if($horaires !== FALSE)
			    {
			    	//echo "Insert > ligne : ".$item->route_id." arret : ".$arret->id_arret." sens 2 <br>";
				    foreach ($horaires as $heure => $heures) {
				    	foreach ($heures as $key => $minute) {
				    		$hour = $heure.':'.$minute;
							$this->parse_model->add_horaire($item->route_id, $arret->id_arret , 'Di', $hour, 2);
				    	}
				    }
				}else{
					echo "/!\ Erreur > ligne : ".$item->route_id." arret : ".$arret->id_arret." sens 2 <br>";
				}
			}
		}
*/

		// Aller Samedi
		foreach ($liste_ligne as $key => $item) {
			$liste_arrets = $this->arrets_model->get_arrets($item->route_id, 1);
			foreach ($liste_arrets as $key => $arret) {
			    $horaires = $this->import_sitestan->import_horaire($date_sam, $item->route_id, $arret->id_arret, 1);    
			    if($horaires !== FALSE)
			    {
			    	echo "Insert > ligne : ".$item->route_id." arret : ".$arret->id_arret." sens 1 <br>";
				    foreach ($horaires as $heure => $heures) {
				    	foreach ($heures as $key => $minute) {
				    		$hour = $heure.':'.$minute;
							$this->parse_model->add_horaire($item->route_id, $arret->id_arret , 'Sa', $hour, 1);
				    	}
				    }
				}else{
					echo "/!\ Erreur > ligne : ".$item->route_id." arret : ".$arret->id_arret." sens 1 <br>";
				}
			}
		}

		// Retour Samedi
		foreach ($liste_ligne as $key => $item) {
			$liste_arrets = $this->arrets_model->get_arrets($item->route_id, 2);
			foreach ($liste_arrets as $key => $arret) {
			    $horaires = $this->import_sitestan->import_horaire($date_sam, $item->route_id, $arret->id_arret, 2);    
			    if($horaires !== FALSE)
			    {
			    	//echo "Insert > ligne : ".$item->route_id." arret : ".$arret->id_arret." sens 2 <br>";
				    foreach ($horaires as $heure => $heures) {
				    	foreach ($heures as $key => $minute) {
				    		$hour = $heure.':'.$minute;
							$this->parse_model->add_horaire($item->route_id, $arret->id_arret , 'Sa', $hour, 2);
				    	}
				    }
				}else{
					echo "/!\ Erreur > ligne : ".$item->route_id." arret : ".$arret->id_arret." sens 2 <br>";
				}
			}
		}

/*
		// Aller Vacances
		foreach ($liste_ligne as $key => $item) {
			$liste_arrets = $this->arrets_model->get_arrets($item->route_id, 1);
			foreach ($liste_arrets as $key => $arret) {
			    $horaires = $this->import_sitestan->import_horaire($date_vac, $item->route_id, $arret->id_arret, 1);    
			    if($horaires !== FALSE)
			    {
			    	//echo "Insert > ligne : ".$item->route_id." arret : ".$arret->id_arret." sens 1 <br>";
				    foreach ($horaires as $heure => $heures) {
				    	foreach ($heures as $key => $minute) {
				    		$hour = $heure.':'.$minute;
							$this->parse_model->add_horaire($item->route_id, $arret->id_arret , 'Vac', $hour, 1);
				    	}
				    }
				}else{
					//echo "/!\ Erreur > ligne : ".$item->route_id." arret : ".$arret->id_arret." sens 1 <br>";
				}
			}
		}

		// Retour Vacances
		foreach ($liste_ligne as $key => $item) {
			$liste_arrets = $this->arrets_model->get_arrets($item->route_id, 2);
			foreach ($liste_arrets as $key => $arret) {
			    $horaires = $this->import_sitestan->import_horaire($date_vac, $item->route_id, $arret->id_arret, 2);    
			    if($horaires !== FALSE)
			    {
			    	//echo "Insert > ligne : ".$item->route_id." arret : ".$arret->id_arret." sens 2 <br>";
				    foreach ($horaires as $heure => $heures) {
				    	foreach ($heures as $key => $minute) {
				    		$hour = $heure.':'.$minute;
							$this->parse_model->add_horaire($item->route_id, $arret->id_arret , 'Vac', $hour, 2);
				    	}
				    }
				}else{
					//echo "/!\ Erreur > ligne : ".$item->route_id." arret : ".$arret->id_arret." sens 2 <br>";
				}
			}
		}
		*/		
	}

	public function horaire_ligne()
	{
		
		$id_ligne = 116;
		/*
		$this->parse_model->del_horaire_ligne($id_ligne, 'S');
		$this->parse_model->del_horaire_ligne($id_ligne, 'W');
		$this->parse_model->del_horaire_ligne($id_ligne, 'Sa');
		$this->parse_model->del_horaire_ligne($id_ligne, 'Vac');
		*/
		$date_w 	  = '12%2F01%2F2014';
		$date_j 	  = '13%2F01%2F2014';


		$liste_arrets = $this->arrets_model->get_arrets($id_ligne, 1);
		foreach ($liste_arrets as $key => $arret) {
		    $horaires = $this->import_sitestan->import_horaire($date_j, $id_ligne, $arret->stop_id, 1);    
		    if($horaires !== FALSE)
		    {
		    	echo "Insert > ligne : ".$id_ligne." arret : ".$arret->stop_id." sens 1 <br>";
			    foreach ($horaires as $heure => $heures) {
			    	foreach ($heures as $key => $minute) {
			    		$hour = $heure.':'.$minute;
						$this->parse_model->add_horaire_import($id_ligne, $arret->stop_id , 'S', $hour, 1);
			    	}
			    }
			}else{
				echo "/!\ Erreur > ligne : ".$id_ligne." arret : ".$arret->stop_id." sens 1 <br>";
			}
		}
/*
		$liste_arrets = $this->arrets_model->get_arrets($id_ligne, 2);
		foreach ($liste_arrets as $key => $arret) {
		    $horaires = $this->import_sitestan->import_horaire($date_j, $id_ligne, $arret->stop_id, 2);
		    if($horaires !== FALSE)
		    {
		    	echo "insert > ligne : ".$id_ligne." arret : ".$arret->stop_id." sens 2 <br>";
			    foreach ($horaires as $heure => $heures) {
			    	foreach ($heures as $key => $minute) {
			    		$hour = $heure.':'.$minute;
						$this->parse_model->add_horaire($id_ligne, $arret->stop_id , 'S', $hour, 2);
			    	}
			    }
			}else{
				echo "/!\ Erreur > ligne : ".$id_ligne." arret : ".$arret->stop_id." sens 2 <br>";
			}
		}
*/

		/*	    
		$liste_arrets = $this->arrets_model->get_arrets($id_ligne, 1);
		foreach ($liste_arrets as $key => $arret) {
		    $horaires = $this->import_sitestan->import_horaire($date_w, $id_ligne, $arret->stop_id, 1);    
		    if($horaires !== FALSE)
		    {
		    	echo "Insert > ligne : ".$id_ligne." arret : ".$arret->stop_id." sens 1 <br>";
			    foreach ($horaires as $heure => $heures) {
			    	foreach ($heures as $key => $minute) {
			    		$hour = $heure.':'.$minute;
						$this->parse_model->add_horaire($id_ligne, $arret->stop_id , 'W', $hour, 1);
			    	}
			    }
			}else{
				echo "/!\ Erreur > ligne : ".$id_ligne." arret : ".$arret->stop_id." sens 1 <br>";
			}
		}

		$liste_arrets = $this->arrets_model->get_arrets($id_ligne, 2);
		foreach ($liste_arrets as $key => $arret) {
		    $horaires = $this->import_sitestan->import_horaire($date_w, $id_ligne, $arret->stop_id, 2);
		    if($horaires !== FALSE)
		    {
		    	echo "insert > ligne : ".$id_ligne." arret : ".$arret->stop_id." sens 2 <br>";
			    foreach ($horaires as $heure => $heures) {
			    	foreach ($heures as $key => $minute) {
			    		$hour = $heure.':'.$minute;
						$this->parse_model->add_horaire($id_ligne, $arret->stop_id , 'W', $hour, 2);
			    	}
			    }
			}else{
				echo "/!\ Erreur > ligne : ".$id_ligne." arret : ".$arret->stop_id." sens 2 <br>";
			}
		}
			*/	
	}

	public function chemin()
	{
		$this->import_chemin->chemin();

		$data['test'] =	'test';

		$data['head'] 				= $this->load->view('admin/structure/header', $data, TRUE);
		$data['footer'] 			= $this->load->view('admin/structure/footer', $data, TRUE);
		$data['scripts'] 			= $this->load->view('admin/structure/scripts', $data, TRUE);
		
		//$this->load->view('admin/autopie', $data);		
	}

	public function autopi()
	{
		$this->import_kml->autopi();

		$data['test'] =	'test';

		$data['head'] 				= $this->load->view('admin/structure/header', $data, TRUE);
		$data['footer'] 			= $this->load->view('admin/structure/footer', $data, TRUE);
		$data['scripts'] 			= $this->load->view('admin/structure/scripts', $data, TRUE);
		
		$this->load->view('admin/autopie', $data);		
	}

	public function velo()
	{
		$this->import_kml->velo();

		$data['test'] =	'test';

		$data['head'] 				= $this->load->view('admin/structure/header', $data, TRUE);
		$data['footer'] 			= $this->load->view('admin/structure/footer', $data, TRUE);
		$data['scripts'] 			= $this->load->view('admin/structure/scripts', $data, TRUE);
		
		$this->load->view('admin/autopie', $data);		
	}	


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */