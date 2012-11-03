<?php

class MY_FormValidation extends CI_Form_validation {

	function __construct($config = array()) {
		parent::__construct($config);
	}
	
	/**
	 * Returns the error messages as a string 
	 */
	public function error_string($prefix = '', $suffix = '') {
		return parent::error_string($prefix, $suffix);
	}

	/**
	 * Returns the error messages as an array
	 */
	public function error_array() {
		if (count($this->_error_array) === 0) {
			return FALSE;
		}
		else
			return $this->_error_array;
	}

}

?>