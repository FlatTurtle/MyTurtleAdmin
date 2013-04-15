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
        // Redirect when there is only one screen
        if(count($data['infoscreens']) == 1){
            redirect(site_url($data['infoscreens'][0]->alias));
        }

        $shots_path = $this->config->item('screenshots_path');
        $data['shots_path'] =  $shots_path;

        foreach($data['infoscreens'] as $infoscreen){
            // Get power state
            $plugin_states = $this->infoscreen->plugin_states($infoscreen->alias);
            $infoscreen->power = 1;
            if(isset($plugin_states->power))
                $infoscreen->power = $plugin_states->power;

            // Check screenshot availability
            $current_path = $shots_path . $infoscreen->hostname . "/thumbs/";
            $infoscreen->shot = false;

            if(is_dir($current_path)){
                $shots = array();
                // Get all screenshots
                if ($handle = opendir($current_path)) {
                    /* This is the correct way to loop over the directory. */
                    while (false !== ($entry = readdir($handle))) {
                        array_push($shots, $entry);
                    }
                    sort($shots);
                    $shots = array_reverse($shots);
                    closedir($handle);
                }

                if(count($shots) > 0){
                    // Only get last shot
                    $shot = $shots[0];

                    // Get image data
                    if(is_file($current_path . $shot)){
                        $image = @file_get_contents($current_path . $shot);
                        if($image){
                            $image = base64_encode($image);
                            $infoscreen->shot = $image;
                        }

                    }
                }
            }
        }

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