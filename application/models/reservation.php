<?php

/**
 * FlatTurtle bvba
 * @author: Quentin Kaiser
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reservation extends CI_Model {

    // Mustache engine
    private $m;

    public function __construct() {
        parent::__construct();

        $this->reservations_api = new API();
        $this->reservations_api->API_PATH = $this->config->item('reservations_api_url');
        // Init mustache engine
        $this->m = new Mustache_Engine;

    }


    /**
     * Get today's reservation instances
     * @param $alias : the user's alias
     * @param $day : a date formatted as 'dd-mm-YYYY' used to request reservations instance for that day
     * @return 
     */
    public function get_all($alias, $day=null) {
        if($day!=null)
            return $this->reservations_api->get($alias . '/reservations');   
        else
            return $this->reservations_api->get($alias . '/reservations'); //TODO(qkaiser) : add day parameter in GET request
    }

    /**
     * Get reservation by id
     * @param $alias : the user's alias
     * @param $id : the reservation's id that you want to retrieve
     * @return 
     **/
    public function get_by_id($alias, $id) {
        return $this->reservations_api->get($alias . '/reservations/' . $id);
    }


    /**
     * Create a new reservation
     * @param $alias : the user's alias
     * @param $data : the data POSTed to the API
     */
    public function create($alias, $data) {
        return $this->reservations_api->post($alias . '/reservations', $data);
    }


    /**
     * Update a reservation
     * @param $alias : the user's alias
     * @param $id : the reservation's id
     * @param $data : the updated value for this reservation
     * @return
     */
    public function update($alias, $id, $data) {
        return $this->reservations_api->post($alias . '/reservations/' . $id, $data);
    }


    /**
     * Delete a reservation
     * @param $alias : the user's alias
     * @param $id : the reservation's id that you want to delete
     */
    public function delete($alias, $id){
        return $this->reservations_api->delete($alias . '/reservations/' . $id);
    }
    

    /**
     * Get template and fill out the data
     * @param $reservation : the reservation used to fill out the template
     * @return string containing the filled html template
     */
    public function template($reservations) {

        throw new Exception("Not yet implemented");
    }
}