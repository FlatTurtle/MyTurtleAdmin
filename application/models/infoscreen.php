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
	public function post($alias, $post_data) {
		$this->api->post($this->API . API_INFOSCREENS . '/' . $alias, $post_data);
	}

	/**
	 * Get all infoscreens from the API
	 */
	public function getAll() {
		return json_decode($this->api->get($this->API . API_INFOSCREENS));
	}

	/**
	 * Get an infoscreen from the API
	 */
	public function get($alias) {
		return json_decode($this->api->get($this->API . API_INFOSCREENS . '/' . $alias));
	}

	/**
	 * Get an infoscreen from the API
	 */
	public function plugin_states($alias) {
		return json_decode($this->api->get($this->API . API_INFOSCREENS . '/' . $alias. '/' . API_PLUGIN_STATES));
	}

	/**
	 * Sent a message
	 */
	public function message($alias, $post_data) {
		return json_decode($this->api->post($this->API . API_INFOSCREENS . '/' . $alias . '/' . API_PLUGIN_MESSAGE, $post_data));
	}
	
	/**
	 * Sent a clock
	 */
	public function clock($alias, $post_data) {
		if($post_data['action'] == 'off'){
			return json_decode($this->api->delete($this->API . API_INFOSCREENS . '/' . $alias . '/' . API_PLUGIN_CLOCK));
		}else{
			return json_decode($this->api->post($this->API . API_INFOSCREENS . '/' . $alias . '/' . API_PLUGIN_CLOCK));
		}		
	}

	/**
	 * Toggle screen power
	 */
	public function screen_power($alias, $post_data) {
		return json_decode($this->api->post($this->API . API_INFOSCREENS . '/' . $alias . '/' . API_PLUGIN_SCREEN_POWER, $post_data));
	}

}

?>