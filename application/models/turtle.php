<?php

/**
 * FlatTurtle bvba
 * @author: Michiel Vancoillie
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Turtle extends CI_Model {

    // Mustache engine
    private $m;

    public function __construct() {
        parent::__construct();

        // Init mustache engine
        $this->m = new Mustache_Engine;

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
        $template = @file_get_contents(base_url() . 'assets/inc/turtles/options_' . $turtle->type . '.php');

        if(!$template) {
            // Load notice when template is not found
            $template = file_get_contents(base_url() . 'assets/inc/turtles/options_blank.php');
        }

        // Start create data array to fill template
        $data = array();

        // Fill out known values
        foreach ($turtle->options as $key => $value) {
            $data[$key] = htmlspecialchars($value);
        }

        // Limit options
        $limit_options = "";
        $limit = (!empty($turtle->options->limit))? $turtle->options->limit : 5;
        for ($i = 2; $i < 34; $i++) {
            $selected = '';
            if ($i == $limit)
                $selected = 'selected';
            $limit_options .= '<option ' . $selected . '>' . $i . '</option>';
        }
        $data['limit_options'] = $limit_options;

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
            $data['zoom_options'] = $zoom_options;
        }

        $zoomalt_options = "";
        if(!empty($turtle->options->zoomalt)){
            $zoom = (!empty($turtle->options->zoomalt))? $turtle->options->zoomalt : 12;
            for ($i = 10; $i <= 20; $i++) {
                $selected = '';
                if ($i == $zoom)
                    $selected = 'selected';
                $zoomalt_options .= '<option ' . $selected . '>' . $i . '</option>';
            }
            $data['zoomalt_options'] = $zoomalt_options;
        }

        // Type options
        $type_options = "";
        $selected_dep = "selected='selected'";
        $selected_arr = "";
        if(!empty($turtle->options->type) && $turtle->options->type == "arrivals"){
            $selected_dep = "";
            $selected_arr = "selected='selected'";
        }
        $type_options .= '<option ' . $selected_dep . ' value="departures">' . lang('term_departures') . '</option>';
        $type_options .= '<option ' . $selected_arr . ' value="arrivals">' . lang('term_arrivals') . '</option>';
        $data['type_options'] = $type_options;


        if($turtle->type == "rss"){

            // Get available RSS links
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
            $rss_links_html .= ">(".lang('turtle_rss_custom').")</option>";

            $data['rss_links'] = $rss_links_html;
            $data['custom_hide'] = $custom_class;

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
            $map_options .= ">".lang('turtle_screen_location')."</option>";

            $map_options .= "<option value='custom'";
            if(empty($custom_class)){
                $map_options .= " selected='selected'";
            }
            $map_options .= ">(".lang('turtle_custom_location').")</option>";
            $data['map_options'] = $map_options;
            $data['custom_hide'] = $custom_class;

        }else if($turtle->type == "signage"){

            // Check for logo existance
            if(!empty($turtle->options->data)){
                $floor_data = json_decode($turtle->options->data);
                foreach($floor_data as $floor){
                    foreach($floor->floors as $floor_item){
                        if(file_exists(SIGNAGE_UPLOAD_DIR. $turtle->id . "/". $floor_item->id. ".png")){
                            $floor_item->logo = base_url(). "/uploads/signage/". $turtle->id . "/". $floor_item->id. ".png";
                        }
                    }
                }
                $data['data'] = json_encode($floor_data);
            }
        }else if($turtle->type == "pricelist"){
            if(!empty($turtle->options->data)){
                $data['data'] = $turtle->options->data;
            }
        }else if($turtle->type == "weekmenu"){
            if(!empty($turtle->options->data)){
                $data['data'] = $turtle->options->data;
            }
        }else if($turtle->type == "offers"){
            if(!empty($turtle->options->data)){
                $data['data'] = $turtle->options->data;
            }
        }else if($turtle->type == "image"){
            if(!empty($turtle->options->urls)){
                $data['data'] = $turtle->options->urls;
            }
        }

        // Language specific data
        $lang_data = $this->lang->language;

        // Turtle specific data
        $turtle_data = array(
            'id'    => $turtle->id,
            'title' => $turtle->name,
            'type'  => $turtle->type,
        );

        // Overwrite in order
        $data = array_replace($lang_data, $data, $turtle_data);

        // Render the template
        return $this->m->render($template, $data);
    }
}
