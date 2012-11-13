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
	
}

?>