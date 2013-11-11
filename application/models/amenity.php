<?php

/**
 * FlatTurtle bvba
 * @author: Quentin Kaiser
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Amenity extends CI_Model {

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
     * Get all amenity instances
     * @param $alias : the user's alias
     */
    public function get_all($alias) {
        return $this->reservations_api->get($alias . '/amenities');   
    }

    /**
     * Get amenity by name
     * @param $alias : the user's alias
     * @param $name : the amenity's name
     **/
    public function get_by_name($alias, $name) {
        return $this->reservations_api->get($alias . '/amenities/' . $name);
    }
    /**
     * Update amenity
     * @param $alias : the user's alias
     * @param $name : the amenity's name
     * @param $data : the amenity's data
     */
    public function update($alias, $name, $data) {
        return $this->reservations_api->post($alias . '/amenities/' . $name, $data);
    }


    /**
     * Create a new amenity
     * @param $alias : the user's alias
     * @param $name : the amenity's name
     * @param $data : the amenity's data
     */
    public function create($alias, $name, $data) {
        return $this->reservations_api->put($alias . '/amenities/' . $name, $data);
    }

    /**
     * Delete an amenity
     * @param $alias : the user's alias
     * @param $name : the amenity's name
     */
    public function delete($alias, $name){
        return $this->reservations_api->delete($alias . '/amenities/' . $name);
    }
    

    /**
     * Get template and fill out the data
     * @param $amenity : the amenity used to fill out the template
     * @return string containing the filled html template
     */
    public function template($amenity) {

        throw new Exception("Not yet implemented");
    }
}