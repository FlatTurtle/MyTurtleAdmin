<?php

/**
 * FlatTurtle bvba
 * @author: Michiel Vancoillie 
 */
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Turtle extends CI_Model {

	private $API;

	public function __construct() {
		parent::__construct();
		$this->API = $this->config->item('api_url');
	}

	/**
	 * Get all turtles types (primitives) 
	 */
	public function get_all_types(){
		return json_decode($this->api->get($this->API . API_TURTLE_TYPES));
	}
	
	/**
	 * Get all turtle instances
	 */
	public function get($alias, $pane_type = null){
		if($pane_type){
			return json_decode($this->api->get($this->API . API_INFOSCREENS . '/' . $alias . '/' . API_TURTLE_INSTANCES . '?pane_type='. urlencode($pane_type)));
		}else{
			return json_decode($this->api->get($this->API . API_INFOSCREENS . '/' . $alias . '/' . API_TURTLE_INSTANCES));
		}
	}
	
	/**
	 * Update turtle options 
	 */
	public function update($alias, $id, $data){
		json_decode($this->api->post($this->API . API_INFOSCREENS . '/' . $alias . '/' . API_TURTLE_INSTANCES .'/' . $id, $data));
	}
}

?>