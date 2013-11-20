<?php

/**
 * FlatTurtle bvba
 * @author: Nik Torfs
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Maps extends CI_Controller {

    public function __construct(){
        parent::__construct();

    }

    public function index(){
        

        $this->load->view('header', $data);
        $this->load->view('screen/menu', $data);
        $this->load->view('screen/maps/index', $data);
        $this->load->view('footer');
    }


}