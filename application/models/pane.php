<?php

/**
 * FlatTurtle bvba
 * @author: Michiel Vancoillie
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pane extends CI_Model {

    public $panes;

    public function __construct() {
        $this->loadJSON();
    }


    private function loadJSON(){
        $configfile = APPPATH.'config/panes.json';
        $this->panes = json_decode(file_get_contents($configfile));
        if($this->panes == NULL){
            throw new Exception("Couldn't read config/panes.json, is it formatted as valid JSON?");
        }
    }

    /**
     * Get all panes
     */
    public function get_all($alias, $type = null) {
        if ($type) {
            return $this->api->get(API_INFOSCREENS . '/' . $alias . '/' . API_PANE_INSTANCES . '?type=' . urlencode($type));
        } else {
            return $this->api->get(API_INFOSCREENS . '/' . $alias . '/' . API_PANE_INSTANCES);
        }
    }

    /**
     * Get specific panes
     */
    public function get($alias, $pane_id) {
        return $this->api->get(API_INFOSCREENS . '/' . $alias . '/' . API_PANE_INSTANCES . '/' . $pane_id);
    }


    /**
     * Update pane information
     */
    public function post($alias, $pane_id, $post_data){
        return $this->api->post(API_INFOSCREENS . '/' . $alias . '/' . API_PANE_INSTANCES . '/'. $pane_id, $post_data);
    }

    /**
     * Delete pane
     */
    public function delete($alias, $pane_id) {
        return $this->api->delete(API_INFOSCREENS . '/' . $alias . '/' . API_PANE_INSTANCES . '/'. $pane_id);
    }

    /**
     * Add a pane
     */
    public function put($alias, $put_data) {
        return $this->api->put(API_INFOSCREENS . '/' . $alias . '/' . API_PANE_INSTANCES . '/', $put_data);
    }

    /**
     * Change turtle order
     */
    public function order($alias, $id, $data) {
        return $this->api->post(API_INFOSCREENS . '/' . $alias . '/' . API_PANE_INSTANCES . '/' . API_PANE_ORDER . '/' . $id, $data);
    }
}
