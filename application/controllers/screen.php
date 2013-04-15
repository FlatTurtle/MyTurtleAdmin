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
        $this->load->model('option');
        $this->load->model('infoscreen');
        $this->load->library('my_formvalidation');

        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function index() {
        redirect('/');
    }

    /**
     * Update an infoscreen
     */
    public function update($alias) {
        // Update the footer
        $footerdata['type']  = trim($this->input->post('footer_type'));
        if($footerdata['type'] == "message"){
            $footerdata['value']  = trim($this->input->post('footer_message'));
            if(empty($footerdata['value'])){
                $footerdata['value'] = ' ';
            }
        }else if($footerdata['type'] == "updates"){
            $footerdata['value']  = trim($this->input->post('footer_rss'));
        }else{
            $footerdata = null;
        }

        $this->infoscreen->footer($alias, $footerdata);

        redirect($alias);
    }

    /**
     * Infoscreen view
     */
    public function show($alias) {
        $data['infoscreen'] = $this->infoscreen->get($alias);

        $plugin_states = $this->infoscreen->plugin_states($alias);
        $data['state_clock'] = 1;
        $data['state_screen'] = 1;
        $data['footer'] = '';
        if(isset($plugin_states->clock))
            $data['state_clock'] = $plugin_states->clock;
        if(isset($plugin_states->power))
            $data['state_screen'] = $plugin_states->power;

        // Get footer data
        $data['footer'] = "";
        $data['footer_type'] = "none";
        $data['footer_types'] = array('none','message', 'updates');
        if(isset($plugin_states->footer_type)){
            $data['footer_type'] = $plugin_states->footer_type;
            if(isset($plugin_states->footer) && $data['footer_type'] != "none"){
                $data['footer'] = $plugin_states->footer;
                if($data['footer'] == " ") $data['footer'] = '';
            }
        }
        // Get available footer RSS links
        $data['rss_links'] = $this->option->get('footer_rss');

        $data['back_link'] = "";

        $this->load->view('header');
        $this->load->view('screen/menu', $data);
        $this->load->view('screen/single', $data);
        $this->load->view('footer');
    }

    /**
     * Check if a string is a valid hexadecimal color
     */
    public function check_color($value) {
        if (!preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $value)) {
            $message = str_replace('{{value}}', $value, lang('error.color_check_hex'));
            $this->my_formvalidation->set_message('check_color', $message);
            return false;
        }
        return true;
    }

    /**
     * Check if geocode could be resolved
     */
    public function check_geocode($value) {
        if ($value == null) {
            $this->my_formvalidation->set_message('check_geocode', lang('error.resolve_address'));
            return false;
        }
        return true;
    }

}

?>
