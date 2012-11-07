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
}

?>