<?php

/**
 * FlatTurtle bvba
 * @author: Michiel Vancoillie 
 */
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Infoscreen extends CI_Model {
	
	public function getAll(){
		return json_decode($this->api->get($this->config->item('api_url').API_INFOSCREENS));
	}
}
?>