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

	/**
	 * Turtle page
	 */
	public function index($alias) {
		$data['infoscreen'] = $this->infoscreen->get($alias);
		$data['turtle_instances'] = $this->turtle->get($alias, 'list');
		foreach ($data['turtle_instances'] as $turtle) {
			$turtle->content = $this->template($turtle);
		}
		$data['turtle_types'] = $this->turtle->get_all_types();

		$this->load->view('header');
		$this->load->view('screen/turtles', $data);
		$this->load->view('footer');
	}

	/**
	 * AJAX URI for updating order
	 */
	public function sort($alias) {
		$order = $this->input->post('order');
		if(!empty($order) && is_array($order)){
			$counter = 0;
			foreach($order as $id){
				$data['order'] = $counter;
				$this->turtle->update($alias, $id, $data);
				$counter++;
			}
			echo "true";
			return;
		}
		echo "false";
	}

	/**
	 * AJAX URI for updating turtle options
	 */
	public function update($alias) {
		$id = $this->input->post('id');
		unset($_POST['id']);
		if(!empty($id) && is_numeric($id)){
			
			if($this->input->post('options'))
				$data['options'] = json_encode($this->input->post('options'));

			$this->turtle->update($alias, $id, $data);
			echo "true";
			return;
		}
		echo "false";
	}

	/**
	 * Get template and fill out the data
	 */
	public function template($turtle) {
		if (!$contents = file_get_contents(base_url() . 'assets/inc/turtles/options_' . $turtle->type . '.php')) {
			// Load notice when template is not found
			$contents = file_get_contents(base_url() . 'assets/inc/turtles/options_blank.php');
		}
		$contents = preg_replace('/{{id}}/', $turtle->id, $contents);
		$contents = preg_replace('/{{title}}/', $turtle->name, $contents);
		$contents = preg_replace('/{{type}}/', $turtle->type, $contents);
		
		$limit_options = "";
		$limit = (!empty($turtle->options->limit))? $turtle->options->limit : 5;
		for ($i = 2; $i < 19; $i++) {
			$selected = '';
			if ($i == $limit)
				$selected = 'selected';
			$limit_options .= '<option ' . $selected . '>' . $i . '</option>';
		}
		$contents = preg_replace('/{{limit-options}}/', $limit_options, $contents);
		
		foreach ($turtle->options as $key => $value) {
			$contents = preg_replace('/{{' . $key . '}}/', $value, $contents);
		}
		return $contents;
	}

}

?>