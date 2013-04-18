<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Helper with infoscreen functions
 */
if ( ! function_exists('getInfoscreens')){
    function getInfoscreens(){
        $ci=& get_instance();
        $ci->load->model('infoscreen');

        // Fetch all screens
        $infoscreens = $ci->infoscreen->getAll();

        // Sort them
        foreach ($infoscreens as $key => $value) {
            $titles[$key]  = strtolower($value->title);
            $hostnames[$key] = (empty($value->hostname))? 1:0;
        }
        array_multisort($hostnames, SORT_ASC, $titles, SORT_ASC, $infoscreens);

        return $infoscreens;
    }
}