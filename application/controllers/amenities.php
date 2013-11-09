<?php

/**
 * FlatTurtle bvba
 * @author: Quentin Kaiser
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Amenities extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        $this->load->model('infoscreen');
        $this->load->model('amenity');
    }

    /**
     *  Room page
     */
    public function index($alias) {
        $data = array();

        $data['infoscreen'] = $this->infoscreen->get($alias); 
        $data['amenities'] = $this->amenity->get_all($this->session->userdata('username'));
        $this->load->view('header', $data);
        $this->load->view('screen/amenities', $data);
        $this->load->view('footer');
    }

    
    /**
     * Update an amenity instance
     */
    public function update($alias) {
        throw new Exception("Not yet implemented");
    }

    /**
     * Delete an amenity instance
     */
    public function delete($alias){
        throw new Exception("Not yet implemented");   

    }

    /**
     * Create new amenity instance
     */
    public function create($alias){
        throw new Exception("Not yet implemented");
    }
}

?>