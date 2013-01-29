<?php

/**
 * FlatTurtle bvba
 * @author: Michiel Vancoillie
 */
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Panes extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if (!$this->session->userdata('logged_in')) {
			redirect('login');
		}

		$this->load->model('infoscreen');
		$this->load->model('pane');
		$this->load->model('turtle');
	}

	/**
	 * Redirect to first enabled pane (when available)
	 */
	public function first($alias){
		$panes = array();
		try{
			$panes = $this->pane->get_all($alias, 'widget');
		}catch(Exception $e){}
		if(count($panes)> 0){
			redirect(site_url($alias.'/right/'.$panes[0]->template . '/' . $panes[0]->id . '#config'));
		}else{
			$data['panes'] = $panes;
			$data['infoscreen'] = $this->infoscreen->get($alias);
			$data['available_panes'] = $this->pane->panes;

			$this->load->view('header');
			$this->load->view('screen/panes', $data);
			$this->load->view('footer');
		}
	}

	/**
	 * Show pane details with turtles to configure
	 */
	public function index($alias, $pane_id){
		$data['infoscreen'] = $this->infoscreen->get($alias);
		$data['available_panes'] = $this->pane->panes;
		$data['turtles'] = array();
		$data['panes'] = $this->pane->get_all($alias, 'widget');

		try{
			$data['turtles'] = $this->turtle->get($alias, 'widget');
			foreach ($data['turtles'] as $turtle) {
				$turtle->content = $this->turtle->template($turtle);
			}
		}catch(Exception $e){}

		// Check language specific description
		$description_lang = "description_".$this->lang->lang();
		foreach($data['available_panes'] as $pane){
			if(!empty($pane->{$description_lang})){
				$pane->description = $pane->{$description_lang};
			}
		}

		// Get desciption an unset enabled panes, get selected pane
		foreach($data['panes'] as $pane){
			$pane->description = "";
			if(!empty($data['available_panes']->{strtolower($pane->template)})){
				$pane->description = $data['available_panes']->{strtolower($pane->template)}->description;
				unset($data['available_panes']->{strtolower($pane->template)});
			}
			if($pane_id == $pane->id){
				$data['current_pane'] = $pane;
			}
		}

		if(empty($data['current_pane'])){
			redirect(site_url($alias.'/right/'));
		}


		// Pane duration
		$duration_options = "";
		for ($i = 10; $i <= 60; $i+=5) {
			$selected = '';
			if ($i == $data['current_pane']->duration/1000)
				$selected = 'selected';
			$duration_options .= '<option ' . $selected . '>' . $i . '</option>';
		}
		$data['duration_options'] = $duration_options;

		$this->load->view('header');
		$this->load->view('screen/panes', $data);
		$this->load->view('footer');
	}

	/**
	 * Save general pane options
	 */
	public function save($alias, $pane_id){
		$pane = $this->pane->get($alias, $pane_id);

		if(empty($pane)){
			redirect(site_url($alias.'/right/'));
		}else{
			$post_data['duration'] = $this->input->post('duration')*1000;
			$post_data['title'] = ucfirst($this->input->post('title'));
			$this->pane->post($alias, $pane->id, $post_data);
			redirect(site_url($alias.'/right/'.$pane->template . '/' . $pane->id . '#config'));
		}
	}

	/**
	 * Add a pane with corresponding turtles
	 */
	public function add($alias, $pane_type){
		// Get pane specification
		$pane_types = $this->pane->panes;
		if(!empty($pane_types->{$pane_type})){
			// Add all required turtles
			if(!empty($pane_types->{$pane_type}->turtles)){
				$data = array();

				foreach($pane_types->{$pane_type}->turtles as $turtle){
					// Check order
					if(empty($turtle->order)){
						$turtle->order = 0;
					}
				}

				$data['turtles'] = json_encode($pane_types->{$pane_type}->turtles);
				$data['type'] = 'widget';
				$data['title'] = ucfirst($pane_type);
				$data['template'] = $pane_type;
				$pane = $this->pane->put($alias, $data);
				header('Cache-Control: no-cache, must-revalidate');
				header('Content-type: application/json');
				echo json_encode($pane);
			}
		}
	}

	/**
	 * Delete a pane
	 */
	public function delete($alias, $pane_id){
		$pane = $this->pane->delete($alias, $pane_id);

		redirect(site_url($alias.'/right/'));
	}
}

?>