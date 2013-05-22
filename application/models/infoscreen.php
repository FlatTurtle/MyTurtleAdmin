<?php

/**
 * FlatTurtle bvba
 * @author: Michiel Vancoillie
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Infoscreen extends CI_Model {

    /**
     * Update an infoscreen through the API
     */
    public function post($alias, $post_data) {
        $this->api->post(API_INFOSCREENS . '/' . $alias, $post_data);
    }

    /**
     * Get all infoscreens from the API
     */
    public function getAll() {
        return $this->api->get(API_INFOSCREENS);
    }

    /**
     * Get an infoscreen from the API
     */
    public function get($alias) {
        return $this->api->get(API_INFOSCREENS . '/' . $alias);
    }

    /**
     * Get an infoscreen from the API
     */
    public function plugin_states($alias) {
        return $this->api->get(API_INFOSCREENS . '/' . $alias. '/' . API_PLUGIN_STATES);
    }

    /**
     * Sent a message
     */
    public function message($alias, $post_data) {
        return $this->api->post(API_INFOSCREENS . '/' . $alias . '/' . API_PLUGIN_MESSAGE, $post_data);
    }

    /**
     * Sent a clock
     */
    public function clock($alias, $post_data) {
        if($post_data['action'] == 'off'){
            return $this->api->delete(API_INFOSCREENS . '/' . $alias . '/' . API_PLUGIN_CLOCK);
        }else{
            return $this->api->post(API_INFOSCREENS . '/' . $alias . '/' . API_PLUGIN_CLOCK);
        }
    }

    /**
     * Toggle screen power
     */
    public function screen_power($alias, $post_data) {
        return $this->api->post(API_INFOSCREENS . '/' . $alias . '/' . API_PLUGIN_SCREEN_POWER, $post_data);
    }


    /**
     * Reload screen
     */
    public function screen_reload($alias) {
        return $this->api->post(API_INFOSCREENS . '/' . $alias . '/' . API_PLUGIN_SCREEN_RELOAD);
    }

    /**
     * Place footer message
     */
    public function footer($alias, $post_data) {
        if($post_data == null){
            return $this->api->delete(API_INFOSCREENS . '/' . $alias . '/' . API_PLUGIN_FOOTER);
        }else{
            return $this->api->post(API_INFOSCREENS . '/' . $alias . '/' . API_PLUGIN_FOOTER, $post_data);
        }
    }

}
