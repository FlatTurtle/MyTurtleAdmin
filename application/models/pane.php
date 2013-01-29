<?php

/**
 * FlatTurtle bvba
 * @author: Michiel Vancoillie
 */
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Pane extends CI_Model {

	private $API;
	public $panes;

	public function __construct() {
		parent::__construct();
		$this->API = $this->config->item('api_url');

		$this->loadJSON();
	}


	private function loadJSON(){
		$configfile = APPPATH.'config/panes.json';
		$this->panes = json_decode(file_get_contents($configfile));
		if($this->panes == NULL){
			throw new Exception("Couldn't read config/panes.json, is it formatted as valid JSON?");
		}
	}

	/**
	 * Get all panes
	 */
	public function get_all($alias, $type = null) {
		if ($type) {
			return json_decode($this->api->get($this->API . API_INFOSCREENS . '/' . $alias . '/' . API_PANE_INSTANCES . '?type=' . urlencode($type)));
		} else {
			return json_decode($this->api->get($this->API . API_INFOSCREENS . '/' . $alias . '/' . API_PANE_INSTANCES));
		}
	}

	/**
	 * Get specific panes
	 */
	public function get($alias, $pane_id) {
		return json_decode($this->api->get($this->API . API_INFOSCREENS . '/' . $alias . '/' . API_PANE_INSTANCES . '/' . $pane_id));
	}


	/**
	 * Update pane information
	 */
	public function post($alias, $pane_id, $post_data){
		return json_decode($this->api->post($this->API . API_INFOSCREENS . '/' . $alias . '/' . API_PANE_INSTANCES . '/'. $pane_id, $post_data));
	}

	/**
	 * Delete pane
	 */
	public function delete($alias, $pane_id) {
		return json_decode($this->api->delete($this->API . API_INFOSCREENS . '/' . $alias . '/' . API_PANE_INSTANCES . '/'. $pane_id));
	}

	/**
	 * Add a pane
	 */
	public function put($alias, $put_data) {
		return json_decode($this->api->put($this->API . API_INFOSCREENS . '/' . $alias . '/' . API_PANE_INSTANCES . '/', $put_data));
	}
}

?>