<?php

/**
 * FlatTurtle bvba
 * @author: Quentin Kaiser
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Room extends CI_Model {

    // Mustache engine
    private $m;

    public function __construct() {
        parent::__construct();
        $this->reservations_api = new API();
        $this->reservations_api->API_PATH = API_RESERVATIONS;
        // Init mustache engine
        $this->m = new Mustache_Engine;

    }


    /**
     * Get all room instances
     * @param $alias : the user's alias
     */
    public function get_all($alias) {
        $rooms = $this->reservations_api->get($alias);
        $_rooms = array();
        foreach($rooms as $room){
            if(!strcmp($room->type, 'room'))
                array_push($_rooms, $room);
        }   
        return $_rooms;
    }

    /**
     * Get room by name
     * @param $alias : the user's alias
     * @param $name : the room's name
     **/
    public function get_by_name($alias, $name) {
        return $this->reservations_api->get($alias . '/' . $name);
    }
    /**
     * Update room
     * @param $alias : the user's alias
     * @param $name : the room's name
     * @param $data : the room's data
     */
    public function update($alias, $name, $data) {
        return $this->reservations_api->post($alias . '/' . $name, $data);
    }


    /**
     * Create a new room
     * @param $alias : the user's alias
     * @param $name : the room's name
     * @param $data : the room's data
     */
    public function create($alias, $name, $data) {
        return $this->reservations_api->put($alias . '/' . $name, $data);
    }

    /**
     * Delete a room
     * @param $alias : the user's alias
     * @param $name : the room's name
     * @return
     */
    public function delete($alias, $name){
        return $this->reservations_api->delete($alias . '/' . $name);
    }
    

    /**
     * Get template and fill out the data
     * @param $room : the room used to fill out the template
     * @return string containing the filled html template
     */
    public function template($room) {

        throw new Exception("Not yet implemented");
    }
}