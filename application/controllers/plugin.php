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
		$post_data['message'] = $this->db->escape($this->input->post('message'));
		echo $this->infoscreen->message($alias, $post_data);
	}

}

?>