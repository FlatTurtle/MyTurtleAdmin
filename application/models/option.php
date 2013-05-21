<?php

/**
 * FlatTurtle bvba
 * @author: Michiel Vancoillie
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Option extends CI_Model {

    /**
     * Get all panes
     */
    public function get($name = null) {
        return $this->api->get(API_OPTION . "/?name=" . urlencode($name));
    }

}
