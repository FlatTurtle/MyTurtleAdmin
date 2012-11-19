<?php

/**
 * FlatTurtle bvba
 * @author: Michiel Vancoillie
 */
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Plugin extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('infoscreen');

		if (!$this->session->userdata('logged_in')) {
			redirect('login');
		}
	}

	public function message($alias) {
		$post_data['message'] = $this->input->post('message');
		$this->infoscreen->message($alias, $post_data);
	}

	public function clock($alias) {
		$post_data['action'] = $this->input->post('action');
		$this->infoscreen->clock($alias, $post_data);
	}

	public function screen_power($alias) {
		$post_data['action'] = $this->input->post('action');
		$this->infoscreen->screen_power($alias, $post_data);
	}

}

?>