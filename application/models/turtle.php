<?php

/**
 * FlatTurtle bvba
 * @author: Michiel Vancoillie
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Turtle extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->model('option');
    }

    /**
     * Get all turtles types (primitives)
     */
    public function get_all_types() {
        return $this->api->get(API_TURTLE_TYPES);
    }

    /**
     * Get all turtle instances
     */
    public function get($alias, $pane_type = null) {
        if ($pane_type) {
            return $this->api->get(API_INFOSCREENS . '/' . $alias . '/' . API_TURTLE_INSTANCES . '?pane_type=' . urlencode($pane_type));
        } else {
            return $this->api->get(API_INFOSCREENS . '/' . $alias . '/' . API_TURTLE_INSTANCES);
        }
    }

    /**
     * Update turtle options
     */
    public function update($alias, $id, $data) {
        return $this->api->post(API_INFOSCREENS . '/' . $alias . '/' . API_TURTLE_INSTANCES . '/' . $id, $data);
    }


    /**
     * Change turtle order
     */
    public function order($alias, $id, $data) {
        return $this->api->post(API_INFOSCREENS . '/' . $alias . '/' . API_TURTLE_INSTANCES . '/' . API_TURTLE_ORDER . '/' . $id, $data);
    }

    /**
     * Create a new turtle
     */
    public function create($alias, $data) {
        return $this->api->put(API_INFOSCREENS . '/' . $alias . '/' . API_TURTLE_INSTANCES, $data);
    }

    /**
     * Delete a turtle
     */
    public function delete($alias, $id) {
        return $this->api->delete(API_INFOSCREENS . '/' . $alias . '/' . API_TURTLE_INSTANCES . '/' . $id);
    }

    /**
     * Get template and fill out the data
     */
    public function template($turtle) {
        // Fetch template files
        $contents = @file_get_contents(base_url() . 'assets/inc/turtles/options_' . $turtle->type . '.php');

        if(!$contents) {
            // Load notice when template is not found
            $contents = file_get_contents(base_url() . 'assets/inc/turtles/options_blank.php');
        }

        // Turtle specific replaces
        $contents = preg_replace('/{{id}}/', $turtle->id, $contents);
        $contents = preg_replace('/{{title}}/', $turtle->name, $contents);
        $contents = preg_replace('/{{type}}/', $turtle->type, $contents);

        // Language specific replaces
        preg_match_all('/{{(.*?)}}/', $contents, $matches, PREG_SET_ORDER);
        foreach($matches as $match){
            if(lang($match[1]) !== false){
                $contents = preg_replace('/'.$match[0].'/', lang($match[1]), $contents);
            }
        }

        // Get available RSS links
        if($turtle->type == "rss"){
            $rss_links = $this->option->get('turtle_rss_feed');

            $rss_links_html = "";
            $feed = "";
            $custom_class = "";
            if(!empty($turtle->options->feed)) $feed = $turtle->options->feed;

            foreach($rss_links as $rss_link){
                $rss_links_html .= "<option value='$rss_link->url'";
                if($feed == $rss_link->url){
                    $rss_links_html .= " selected='selected'";
                    $custom_class = "hide";
                }
                $rss_links_html .=  ">".$rss_link->name."</option>";
            }
            // Add custom option
            $rss_links_html .= "<option value='custom'";
            if(empty($custom_class)){
                $rss_links_html .= " selected='selected'";
            }
            $rss_links_html .= ">(".lang('turtle.rss_custom').")</option>";

            $contents = preg_replace('/{{rss-links}}/', $rss_links_html, $contents);
            $contents = preg_replace('/{{custom_hide}}/', $custom_class, $contents);
        }else if($turtle->type == "map" || $turtle->type == "mapbox"){
            // Mapbox and map location of screen or custom one
            $map_options = "";
            $location = "";
            $custom_class = "";
            if(!empty($turtle->options->location)) $location = $turtle->options->location;


            $map_options .= "<option value='screen'";
            if(empty($location)){
                $map_options .= " selected='selected'";
                $custom_class = "hide";
            }
            $map_options .= ">".lang('turtle.screen_location')."</option>";

            $map_options .= "<option value='custom'";
            if(empty($custom_class)){
                $map_options .= " selected='selected'";
            }
            $map_options .= ">(".lang('turtle.custom_location').")</option>";
            $contents = preg_replace('/{{map-options}}/', $map_options, $contents);
            $contents = preg_replace('/{{custom_hide}}/', $custom_class, $contents);
        }else if($turtle->type == "signage"){
            // Check for logo existance
            if(!empty($turtle->options->data)){
                $data = json_decode($turtle->options->data);
                foreach($data as $floor){
                    foreach($floor->floors as $floor_item){
                        if(file_exists(SIGNAGE_UPLOAD_DIR. $turtle->id . "/". $floor_item->id. ".png")){
                            $floor_item->logo = base_url(). "/uploads/signage/". $turtle->id . "/". $floor_item->id. ".png";
                        }
                    }
                }
                $data = json_encode($data);
                $contents = preg_replace('/{{data}}/', $data, $contents);
            }
        }

        // Type options
        $type_options = "";
        $selected_dep = "selected='selected'";
        $selected_arr = "";
        if(!empty($turtle->options->type) && $turtle->options->type == "arrivals"){
            $selected_dep = "";
            $selected_arr = "selected='selected'";
        }
        $type_options .= '<option ' . $selected_dep . ' value="departures">' . lang('term.departures') . '</option>';
        $type_options .= '<option ' . $selected_arr . ' value="arrivals">' . lang('term.arrivals') . '</option>';
        $contents = preg_replace('/{{type-options}}/', $type_options, $contents);


        // Limit options
        $limit_options = "";
        $limit = (!empty($turtle->options->limit))? $turtle->options->limit : 5;
        for ($i = 2; $i < 19; $i++) {
            $selected = '';
            if ($i == $limit)
                $selected = 'selected';
            $limit_options .= '<option ' . $selected . '>' . $i . '</option>';
        }
        $contents = preg_replace('/{{limit-options}}/', $limit_options, $contents);

        // Zoom options
        $zoom_options = "";
        if(!empty($turtle->options->zoom)){
            $zoom = (!empty($turtle->options->zoom))? $turtle->options->zoom : 12;
            for ($i = 10; $i <= 20; $i++) {
                $selected = '';
                if ($i == $zoom)
                    $selected = 'selected';
                $zoom_options .= '<option ' . $selected . '>' . $i . '</option>';
            }
            $contents = preg_replace('/{{zoom-options}}/', $zoom_options, $contents);
        }

        // Fill out known values
        foreach ($turtle->options as $key => $value) {
            $contents = preg_replace('/{{' . $key . '}}/', htmlentities($value), $contents);
        }
        return $contents;
    }
}