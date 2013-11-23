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

    public function index($alias){
        $data['infoscreens'] = getInfoscreens();
        foreach($data['infoscreens'] as $infoscreen){
            if($infoscreen->alias == $alias)
                $data['infoscreen'] = $infoscreen;
        }

        $data['menu_second_item'] = lang("term_maps");

        $this->load->view('header', $data);
        $this->load->view('screen/menu', $data);
        $this->load->view('screen/advanced/maps', $data);
        $this->load->view('footer');
    }


}