<?php

/**
 * FlatTurtle bvba
 * @author: Michiel Vancoillie
 */
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Option extends CI_Model {

	private $API;

	public function __construct() {
		parent::__construct();
		$this->API = $this->config->item('api_url');
	}

	/**
	 * Get all panes
	 */
	public function get($name = null) {
		return json_decode($this->api->get($this->API . API_OPTION . "/?name=" . urlencode($name)));
	}

}

?>