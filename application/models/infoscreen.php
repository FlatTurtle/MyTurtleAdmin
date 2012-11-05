<?php

/**
 * FlatTurtle bvba
 * @author: Michiel Vancoillie 
 */
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Infoscreen extends CI_Model {
	private $API;
	
	public function __construct() {
		parent::__construct();
		$this->API = $this->config->item('api_url');
	}
	
	/**
	 * Update an infoscreen through the API
	 */
	public function post($alias, $post_data){
		$this->api->post($this->API.API_INFOSCREENS.'/'.$alias, $post_data);
	}	
	
	/**
	 * Get all infoscreens from the API
	 */
	public function getAll(){
		return json_decode($this->api->get($this->API.API_INFOSCREENS));
	}
	
	/**
	 * Get an infoscreen from the API
	 */
	public function get($alias){
		return json_decode($this->api->get($this->API.API_INFOSCREENS.'/'.$alias));
	}
	
	/**
	 * 
	 */
	public function message($alias, $post_data){
		return json_decode($this->api->post($this->API.API_INFOSCREENS.'/'.$alias . '/'. API_PLUGIN_MESSAGE, $post_data));
	}
}
?>