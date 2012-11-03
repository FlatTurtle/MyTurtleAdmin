<?php

/**
 * FlatTurtle bvba
 * @author: Michiel Vancoillie 
 */
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Screen extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('infoscreen');
	}

	public function index() {
		redirect('/');
	}

	/**
	 * Infoscreen view
	 */
	public function show($alias) {
		$data['infoscreen'] = $this->infoscreen->get($alias);
		
		$this->load->view('header');
		$this->load->view('screen/single', $data);
		$this->load->view('footer');
	}
}

?>