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
		$this->load->model('turtle');
	}

	public function index($alias) {
		$data['infoscreen'] = $this->infoscreen->get($alias);
		$data['turtle_instances'] = $this->turtle->get($alias, 'list');
		foreach($data['turtle_instances'] as $turtle){
			if (!$contents = file_get_contents(base_url() . 'assets/inc/turtles/options_' . $turtle->type . '.php')) {
				// Load notice when template is not found
				$contents = file_get_contents(base_url() . 'assets/inc/turtles/options_blank.php');
			}
			$contents = preg_replace('/{{title}}/', $turtle->name, $contents);
			foreach ($turtle->options as $key => $value) {
				$contents = preg_replace('/{{' . $key . '}}/', $value, $contents);
			}
			$turtle->content = $contents;
		}
		$data['turtle_types'] = $this->turtle->get_all_types();

		$this->load->view('header');
		$this->load->view('screen/turtles', $data);
		$this->load->view('footer');
	}

}

?>