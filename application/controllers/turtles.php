<?php

/**
 * FlatTurtle bvba
 * @author: Michiel Vancoillie 
 */
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Turtles extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		if (!$this->session->userdata('logged_in')) {
			redirect('login');
		}
		
		$this->load->model('infoscreen');
	}
	
	public function index($alias){
		$data['infoscreen'] = $this->infoscreen->get($alias);
		
		$this->load->view('header');
		$this->load->view('screen/turtles', $data);
		$this->load->view('footer');
	}
	
}

?>