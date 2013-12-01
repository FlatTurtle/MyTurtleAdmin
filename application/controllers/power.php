<?php

    /**
     * FlatTurtle bvba
     * @author: Nik Torfs
     */
    if (!defined('BASEPATH'))
        exit('No direct script access allowed');

class Power extends CI_Controller {

    public function __construct(){
        parent::__construct();

    }

    public function index($alias){
        // todo this could be refactored higher up
        $data["infoscreens"] = getInfoscreens();
        foreach($data['infoscreens'] as $infoscreen){
            if($infoscreen->alias == $alias)
                $data['infoscreen'] = $infoscreen;
        }

        $data['menu_second_item'] = lang("term_screen_power");

        $this->load->view('header', $data);
        $this->load->view('screen/menu', $data);
        $this->load->view('screen/advanced/power', $data);
        $this->load->view('footer');
    }
}
