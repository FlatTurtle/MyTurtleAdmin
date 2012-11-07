<?php

/**
 * FlatTurtle bvba
 * @author: Michiel Vancoillie 
 */
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('infoscreen');
		$this->form_validation->set_rules('username', 'username', 'required');
		$this->form_validation->set_rules('password', 'password', 'required');
		$this->form_validation->set_error_delimiters('', '<br/>');
	}

	/**
	 * List infoscreens 
	 */
	public function index() {
		if (!$this->session->userdata('logged_in')) {
			redirect('login');
		}
		
		$data['infoscreens'] = $this->infoscreen->getAll();

		$this->load->view('header');
		$this->load->view('home', $data);
		$this->load->view('footer');
	}

	/**
	 * Login view
	 */
	public function login() {
		if ($this->session->userdata('logged_in')) {
			redirect('/');
		}
		
		$data['username'] = $this->session->flashdata('username');
		$data['form_error'] = $this->session->flashdata('form_error');

		$this->load->view('header');
		$this->load->view('login', $data);
		$this->load->view('footer');
	}

	/**
	 * Login
	 */
	public function login_post() {
		if ($this->form_validation->run()) {
			// Try to login
			if($this->securelogin->login($this->input->post('username'), $this->input->post('password'))){
				redirect('/');
			}else{
				$this->session->set_flashdata('form_error', ERROR_WRONG_USER_PASSWORD);
			}
		}else{
			$this->session->set_flashdata('form_error', validation_errors('', ''));
		}

		$this->session->set_flashdata('username', $this->input->post('username'));
		
		redirect('login');
	}

	/**
	 * Logout
	 */
	public function logout() {
		$this->securelogin->logout();
		redirect('/');
	}

}

?>