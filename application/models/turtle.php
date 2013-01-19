<?php

/**
 * FlatTurtle bvba
 * @author: Michiel Vancoillie
 */
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Turtle extends CI_Model {

	private $API;

	public function __construct() {
		parent::__construct();
		$this->API = $this->config->item('api_url');
	}

	/**
	 * Get all turtles types (primitives)
	 */
	public function get_all_types() {
		return json_decode($this->api->get($this->API . API_TURTLE_TYPES));
	}

	/**
	 * Get all turtle instances
	 */
	public function get($alias, $pane_type = null) {
		if ($pane_type) {
			return json_decode($this->api->get($this->API . API_INFOSCREENS . '/' . $alias . '/' . API_TURTLE_INSTANCES . '?pane_type=' . urlencode($pane_type)));
		} else {
			return json_decode($this->api->get($this->API . API_INFOSCREENS . '/' . $alias . '/' . API_TURTLE_INSTANCES));
		}
	}

	/**
	 * Update turtle options
	 */
	public function update($alias, $id, $data) {
		return json_decode($this->api->post($this->API . API_INFOSCREENS . '/' . $alias . '/' . API_TURTLE_INSTANCES . '/' . $id, $data));
	}


	/**
	 * Change turtle order
	 */
	public function order($alias, $id, $data) {
		return json_decode($this->api->post($this->API . API_INFOSCREENS . '/' . $alias . '/' . API_TURTLE_INSTANCES . '/' . API_TURTLE_ORDER . '/' . $id, $data));
	}

	/**
	 * Create a new turtle
	 */
	public function create($alias, $data) {
		return json_decode($this->api->put($this->API . API_INFOSCREENS . '/' . $alias . '/' . API_TURTLE_INSTANCES, $data));
	}

	/**
	 * Delete a turtle
	 */
	public function delete($alias, $id) {
		return json_decode($this->api->delete($this->API . API_INFOSCREENS . '/' . $alias . '/' . API_TURTLE_INSTANCES . '/' . $id));
	}

	/**
	 * Get template and fill out the data
	 */
	public function template($turtle) {
		$http = curl_init();
		curl_setopt($http, CURLOPT_URL, base_url() . 'assets/inc/turtles/options_' . $turtle->type . '.php');
		curl_setopt($http, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($http, CURLOPT_SSL_VERIFYPEER, false);
		$contents = curl_exec($http);
		$http_status = curl_getinfo($http, CURLINFO_HTTP_CODE);

		if ($http_status != 200) {
			// Load notice when template is not found
			curl_setopt($http, CURLOPT_URL, base_url() . 'assets/inc/turtles/options_blank.php');
			$contents = curl_exec($http);
			$contents = preg_replace('/{{turtles.error_blank}}/', lang('turtles.error_blank'), $contents);
		}
		curl_close($http);

		$contents = preg_replace('/{{id}}/', $turtle->id, $contents);
		$contents = preg_replace('/{{title}}/', $turtle->name, $contents);
		$contents = preg_replace('/{{type}}/', $turtle->type, $contents);

		// Language specific replaces
		$contents = preg_replace('/{{term.save}}/', lang('term.save'), $contents);
		$contents = preg_replace('/{{term.location}}/', lang('term.location'), $contents);
		$contents = preg_replace('/{{term.primary}}/', lang('term.primary'), $contents);
		$contents = preg_replace('/{{term.secondary}}/', lang('term.secondary'), $contents);
		$contents = preg_replace('/{{term.search}}/', lang('term.search'), $contents);
		$contents = preg_replace('/{{turtles.option_number_of_items}}/', lang('turtles.option_number_of_items'), $contents);
		$contents = preg_replace('/{{turtles.option_zoom}}/', lang('turtles.option_zoom'), $contents);


		$contents = preg_replace('/{{turtle.airport_alt}}/', lang('turtle.airport_alt'), $contents);
		$contents = preg_replace('/{{turtle.delijn_alt}}/', lang('turtle.delijn_alt'), $contents);
		$contents = preg_replace('/{{turtle.mivb_alt}}/', lang('turtle.mivb_alt'), $contents);
		$contents = preg_replace('/{{turtle.nmbs_alt}}/', lang('turtle.nmbs_alt'), $contents);
		$contents = preg_replace('/{{turtle.velo_alt}}/', lang('turtle.velo_alt'), $contents);
		$contents = preg_replace('/{{turtle.villo_alt}}/', lang('turtle.villo_alt'), $contents);
		$contents = preg_replace('/{{turtle.mapbox_alt}}/', lang('turtle.mapbox_alt'), $contents);
		$contents = preg_replace('/{{turtle.finance_primary_alt}}/', lang('turtle.finance_primary_alt'), $contents);
		$contents = preg_replace('/{{turtle.finance_secondary_alt}}/', lang('turtle.finance_secondary_alt'), $contents);
		$contents = preg_replace('/{{turtle.finance_primary_note}}/', lang('turtle.finance_primary_note'), $contents);
		$contents = preg_replace('/{{turtle.finance_secondary_note}}/', lang('turtle.finance_secondary_note'), $contents);
		$contents = preg_replace('/{{turtle.twitter_search_alt}}/', lang('turtle.twitter_search_alt'), $contents);


		// Get RSS links
		if($turtle->type == "rss"){

		}

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

		foreach ($turtle->options as $key => $value) {
			$contents = preg_replace('/{{' . $key . '}}/', $value, $contents);
		}
		return $contents;
	}
}