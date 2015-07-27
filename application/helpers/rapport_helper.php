<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Form Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Simonet Fabrice
 * @link		http://codeigniter.com/user_guide/helpers/form_helper.html
 */

// ------------------------------------------------------------------------

/**
 * 
 * Formatage d'un retour json ou jsonp
 * 
 * @access	public
 * @param	string	message de retour
 * @param	bool	succes ou false du retour
 * @param	array	tableau des variable à retourner
 * @return	string json or jsonp
 */
if ( ! function_exists('rapport'))
{
	function rapport($type){

		$rapport = array(
						'retard' 		=> "Un bus en retard",
						'avance' 		=> "Un bus en avance",
						'never' 		=> "Un bus jamais passé",
						'pasarret' 		=> "un bus qui ne s'arrête pas",
						'compliment' 	=> "Un compliment pour un chauffeur",
						'controleur' 	=> "La présence de contrôleurs",
						'surpop' 		=> "Un bus surpeuplé",
						'incident' 		=> "Un incident",
						'accident' 		=> "Un accident à l'arret/sur la ligne",
						'bugcoord' 		=> "Un arret n'est pas à sa place sur la carte",
						'autre' 		=> "Une autre catégorie..."
					);

		if(isset($rapport[$type]))
		{
			return $rapport[$type];
		}

		return FALSE;
	}
}

// ------------------------------------------------------------------------

/* End of file form_helper.php */
/* Location: ./application/helpers/retour_helper.php */