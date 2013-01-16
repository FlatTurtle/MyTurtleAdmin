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
	}

	public function index($alias){
		$data['infoscreen'] = $this->infoscreen->get($alias);
		$data['available_panes'] = $this->pane->panes;
		$data['panes'] = $this->pane->get($alias, 'widget');

		foreach($data['panes'] as $pane){
			$pane->description = "";
			if(!empty($data['available_panes']->{$pane->title})){
				$pane->description = $data['available_panes']->{$pane->title}->description;
				unset($data['available_panes']->{$pane->title});
			}
		}

		$this->load->view('header');
		$this->load->view('screen/panes', $data);
		$this->load->view('footer');
	}
}

?>