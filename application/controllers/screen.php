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
		$this->load->library('my_formvalidation');
		
		if (!$this->session->userdata('logged_in')) {
			redirect('login');
		}
		
		$this->my_formvalidation->set_rules('title', 'title', 'required|trim|max_length[255]');
		$this->my_formvalidation->set_rules('color', 'color', 'callback_check_color');
		$this->my_formvalidation->set_error_delimiters('&bull;&nbsp;', '<br/>');
	}

	public function index() {
		redirect('/');
	}
	
	public function update($alias){
		
		// Try to suggest color
		if(!preg_match('/^#/', $this->input->post('color'))){
			$_POST['color'] = '#'.substr($_POST['color'], 0, 6);
		}
		unset($_POST['hostname']);

		if ($this->my_formvalidation->run()){
			$this->infoscreen->post($alias, $this->input->post());
		}else{
			$this->session->set_flashdata('post_title',  $this->input->post('title'));
			$this->session->set_flashdata('post_color', $this->input->post('color'));
			$this->session->set_flashdata('all_errors',  $this->my_formvalidation->error_string());
			$this->session->set_flashdata('errors', $this->my_formvalidation->error_array());
		}
		redirect('screen/'.$alias);
	}

	/**
	 * Infoscreen view
	 */
	public function show($alias) {
		$data['infoscreen'] = $this->infoscreen->get($alias);
		$data['errors'] = $this->session->flashdata('errors');
		$data['all_errors'] = $this->session->flashdata('all_errors');
		
		if($data['errors']){
			$data['infoscreen']->title = $this->session->flashdata('post_title');
			$data['infoscreen']->color = $this->session->flashdata('post_color');
		}
		
		$this->load->view('header');
		$this->load->view('screen/single', $data);
		$this->load->view('footer');
	}
	
	public function check_color($value){
		if(!preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $value)){
			$this->my_formvalidation->set_message('check_color', "The %s '$value' is not a valid hexadecimal color.");
			return false;
		}
		return true;	
	}
}

?>