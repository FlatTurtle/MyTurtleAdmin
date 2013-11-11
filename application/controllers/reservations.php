<?php

/**
 * FlatTurtle bvba
 * @author: Quentin Kaiser
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reservations extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        $this->load->model('infoscreen');
        $this->load->model('reservation');
        $this->load->model('room');
        $this->load->model('amenity');
    }

    /**
     *  Room page
     */
    public function index($alias) {
        $data = array();
        $data['infoscreen'] = $this->infoscreen->get($alias); 
        $data['reservations'] = $this->reservation->get_all($this->session->userdata('username'));
        $data['rooms'] = $this->room->get_all($this->session->userdata('username'));
        if($this->session->userdata('rights') == '100')
            $data['amenities'] = $this->amenity->get_all($this->session->userdata('username'));
        $this->load->view('header', $data);
        $this->load->view('screen/reservations', $data);
        $this->load->view('footer');
    }


    /**
     * Update a reservation
     */
    public function update($alias) {
        throw new Exception("Not yet implemented");
    }

    /**
     * Delete a reservation
     */
    public function delete($alias){
        throw new Exception("Not yet implemented");
    }

    /**
     * Create new reservation instance
     */
    public function create($alias){
        throw new Exception("Not yet implemented");
    }
}

?>