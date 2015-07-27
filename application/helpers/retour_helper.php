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
if ( ! function_exists('retour'))
{
	function retour($msg, $success = TRUE, $options = FALSE){
		if(is_array($options))
		{
			$opts = ' ,';
			foreach ($options as $key => $value) {
				$opts .= '"'.$key.'":'.json_encode($value).',';
			}
			$opts = substr($opts,0,-1);
		}elseif($options !== FALSE ){
			$opts = ', "infos" : "'.$options.'"';
		}else{
			$opts = '';
		}
		$success = ($success == TRUE)? 'true' : 'false';

 		$json = '{"success":'.$success.', "msg":'.json_encode($msg).$opts.'}';

		if(isset($_GET['callback'])){
			header('Access-Control-Allow-Origin: *');
			header('content-type: application/json; charset=utf-8');
			echo $_GET['callback'] . '('.$json.')';
		}else{
			header('Access-Control-Allow-Origin: *');
			header('content-type: application/json; charset=utf-8');
			echo $json;
		}
		exit;
	}
}

// ------------------------------------------------------------------------

/* End of file form_helper.php */
/* Location: ./application/helpers/retour_helper.php */