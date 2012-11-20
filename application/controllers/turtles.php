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
		$this->load->model('pane');
	}

	/**
	 * Turtle page
	 */
	public function index($alias) {
		$data['infoscreen'] = $this->infoscreen->get($alias);
		$data['pane'] = $this->pane->get($alias, 'list');
		$data['pane'] = $data['pane'][0];
		$data['turtle_instances'] = array();
		try{
			$data['turtle_instances'] = $this->turtle->get($alias, 'list');
			foreach ($data['turtle_instances'] as $turtle) {
				$turtle->content = $this->_template($turtle);
			}
		}catch(ErrorException $e){}
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
			$counter = 1;
			foreach($order as $id){
				$data['order'] = $counter;
				$this->turtle->order($alias, $id, $data);
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
	 * Delete turtle instance
	 */
	public function delete($alias){
		$id = $this->input->post('id');
		if(!empty($id) && is_numeric($id)){
			$this->turtle->delete($alias, $id);
			echo "true";
			return;
		}
		echo "false";

	}

	/**
	 * Create new turtle instance
	 */
	public function create($alias){
		$data['type'] = $this->input->post('type');
		$data['pane'] = $this->input->post('pane');
		$data['options'] = '';

		if(!empty($data['type']) && is_numeric($data['pane'])){
			$turtle = $this->turtle->create($alias, $data);
			echo $this->_template($turtle);
			return;
		}
		echo "false";
	}

	/**
	 * Get template and fill out the data
	 */
	private function _template($turtle) {
		$http = curl_init();
		curl_setopt($http, CURLOPT_URL, base_url() . 'assets/inc/turtles/options_' . $turtle->type . '.php');
		curl_setopt($http, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($http, CURLOPT_SSL_VERIFYPEER, false);
		$contents = curl_exec($http);
		$http_status = curl_getinfo($http, CURLINFO_HTTP_CODE);

		if ($http_status != 200) {
			// Load notice when template is not found
			curl_setopt($http, CURLOPT_URL, base_url() . 'assets/inc/turtles/options_blank.php');
			$contents = curl_exec($http);
		}
		curl_close($http);

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