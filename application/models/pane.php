<?php

/**
 * FlatTurtle bvba
 * @author: Michiel Vancoillie
 */
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Pane extends CI_Model {

	private $API;

	public function __construct() {
		parent::__construct();
		$this->API = $this->config->item('api_url');
	}

	/**
	 * Get all panes
	 */
	public function get($alias, $type = null) {
		if ($type) {
			return json_decode($this->api->get($this->API . API_INFOSCREENS . '/' . $alias . '/' . API_PANE_INSTANCES . '?type=' . urlencode($type)));
		} else {
			return json_decode($this->api->get($this->API . API_INFOSCREENS . '/' . $alias . '/' . API_PANE_INSTANCES));
		}
	}

}

?>