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
		$panes = $this->pane->get($alias, 'widget');
		if(count($panes)> 0){
			redirect(site_url($alias.'/right/'.$panes[0]->template . '/' . $panes[0]->id . '#config'));
		}
	}

	/**
	 * Show pane details with turtles to configure
	 */
	public function index($alias, $pane_id){
		$data['infoscreen'] = $this->infoscreen->get($alias);
		$data['available_panes'] = $this->pane->panes;
		$data['panes'] = $this->pane->get($alias, 'widget');
		$data['turtles'] = array();

		try{
			$data['turtles'] = $this->turtle->get($alias, 'widget');
			foreach ($data['turtles'] as $turtle) {
				$turtle->content = $this->turtle->template($turtle);
			}
		}catch(ErrorException $e){}

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
			if(!empty($data['available_panes']->{$pane->title})){
				$pane->description = $data['available_panes']->{$pane->title}->description;
				unset($data['available_panes']->{$pane->title});
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
}

?>