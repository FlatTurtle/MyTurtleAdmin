<?php

/**
 * FlatTurtle bvba
 * @author: Michiel Vancoillie
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Advanced extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        $this->load->model('infoscreen');
        $this->load->library('my_formvalidation');

        // Set validation rules
        $this->my_formvalidation->set_rules('hostname', 'hostname', 'required|trim|max_length[50]');
        $this->my_formvalidation->set_rules('pincode', 'pincode', 'required|trim|max_length[20]');
        $this->my_formvalidation->set_error_delimiters('&bull;&nbsp;', '<br/>');
    }

    /**
     * Advanced screen information
     */
    public function index($alias){
        $data['infoscreen'] = $this->infoscreen->get($alias);
        $data['errors'] = $this->session->flashdata('errors');
        $data['all_errors'] = $this->session->flashdata('all_errors');

        $data['menu_second_item'] = lang("term.advanced");

        if ($data['errors']) {
            $data['infoscreen']->hostname = $this->session->flashdata('hostname');
            $data['infoscreen']->pincode = $this->session->flashdata('pincode');
        }

        $this->load->view('header');
        $this->load->view('screen/menu', $data);
        $this->load->view('screen/advanced/index', $data);
        $this->load->view('footer');
    }

    /*
     * Advanced information update
     */
    public function update($alias){
        // Only for superadmins
        if ($this->session->userdata('rights') != 1) {
            redirect(site_url($alias . '/advanced'));
        }

        // Validate the input
        if ($this->my_formvalidation->run()) {
            $this->infoscreen->post($alias, $this->input->post());
        } else {
            $this->session->set_flashdata('pincode', $this->input->post('pincode'));
            $this->session->set_flashdata('hostname', $this->input->post('hostname'));
            $this->session->set_flashdata('all_errors', $this->my_formvalidation->error_string());
            $this->session->set_flashdata('errors', $this->my_formvalidation->error_array());
        }
        redirect(site_url($alias . '/advanced'));
    }

    /**
     * Screenshots tab
     */
    public function shots($alias){
        $data['infoscreen'] = $this->infoscreen->get($alias);
        $data['menu_second_item'] = lang("term.advanced");

        $shots_path = $this->config->item('screenshots_path');
        $shots_path .=  $data['infoscreen']->hostname . "/";
        if(!is_dir($shots_path)){
            redirect(site_url($alias . '/advanced'));
        }

        $shots = array();
        // Get all screenshots
        if ($handle = opendir($shots_path)) {
            /* This is the correct way to loop over the directory. */
            while (false !== ($entry = readdir($handle))) {
                array_push($shots, $entry);
            }
            sort($shots);
            $shots = array_reverse($shots);
            closedir($handle);
        }

        // Only show last 16 shots
        $shots = array_slice($shots, 0, 16);

        // Get all image data
        $data['shots'] = array();
        foreach($shots as $shot){
            if(is_file($shots_path . $shot)){
                $image = @file_get_contents($shots_path . $shot);
                if($image){
                    $image = base64_encode($image);
                    array_push($data['shots'], $image);
                }
            }
        }
        $data['shots_path'] =  $shots_path;



        $this->load->view('header');
        $this->load->view('screen/menu', $data);
        $this->load->view('screen/advanced/shots', $data);
        $this->load->view('footer');
    }

}