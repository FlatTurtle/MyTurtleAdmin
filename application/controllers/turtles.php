<?php

/**
 * FlatTurtle bvba
 * @author: Michiel Vancoillie
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Turtles extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        $this->load->model('infoscreen');
        $this->load->model('turtle');
        $this->load->model('pane');
    }

    /**
     * Turtle page
     */
    public function index($alias) {
        $data['infoscreen'] = $this->infoscreen->get($alias);
        $data['panes'] = $this->pane->get_all($alias, 'list');
        $data['turtle_instances'] = array();
        try{
            $data['turtle_instances'] = $this->turtle->get($alias, 'list');
            foreach ($data['turtle_instances'] as $turtle) {
                $turtle->content = $this->turtle->template($turtle);
            }
        }catch(ErrorException $e){}
        $data['turtle_types'] = $this->turtle->get_all_types();

        $this->load->view('header');
        $this->load->view('screen/turtles', $data);
        $this->load->view('footer');
    }

    /**
     * AJAX URI for updating order
     */
    public function sort($alias) {
        $order = $this->input->post('order');
        if(!empty($order) && is_array($order)){
            $counter = 1;
            foreach($order as $id){
                $data['order'] = $counter;
                $this->turtle->order($alias, $id, $data);
                $counter++;
            }
            echo "true";
            return;
        }
        echo "false";
    }

    /**
     * AJAX URI for updating turtle options
     */
    public function update($alias) {
        $id = $this->input->post('id');
        unset($_POST['id']);
        if(!empty($id) && is_numeric($id)){

            if($this->input->post('options'))
                $data['options'] = json_encode($this->input->post('options'));

            $this->turtle->update($alias, $id, $data);
            echo "true";
            return;
        }
        echo "false";
    }

    /**
     * Delete turtle instance
     */
    public function delete($alias){
        $id = $this->input->post('id');
        if(!empty($id) && is_numeric($id)){
            $this->turtle->delete($alias, $id);
            echo "true";
            return;
        }
        echo "false";

    }

    /**
     * Create new turtle instance
     */
    public function create($alias){
        $data['type'] = $this->input->post('type');
        $data['pane'] = $this->input->post('pane');
        $data['options'] = '';

        if(!empty($data['type']) && is_numeric($data['pane'])){
            $turtle = $this->turtle->create($alias, $data);
            echo $this->turtle->template($turtle);
            return;
        }
        echo "false";
    }
}

?>