<?php

/**
 * FlatTurtle bvba
 * @author: Michiel Vancoillie
 */
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class API {
	
	var $CI;

	public function auth() {
		$this->CI = &get_instance();
		$http = curl_init();
		curl_setopt($http, CURLOPT_URL, $this->CI->config->item('api_url').API_AUTH_ADMIN);
		curl_setopt($http, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($http, CURLOPT_POST, true);
		$data = array(
			'username' => $this->CI->session->userdata('username'),
			'password' => $this->CI->session->userdata('password')
		);
		curl_setopt($http, CURLOPT_POSTFIELDS, $data);

		$response = curl_exec($http);
		$http_status = curl_getinfo($http, CURLINFO_HTTP_CODE);
		curl_close($http);
		
		if($http_status == 200){
			$this->CI->session->set_userdata('token', json_decode($response));
		}else{
			throw new ErrorException($response);
		}
	}

	public function get($url) {
		return $this->request($url);
	}

	public function post($url) {
		return $this->request($url, 'POST');
	}

	public function put($url) {
		return $this->request($url, 'PUT');
	}

	public function delete($url) {
		return $this->request($url, 'DELETE');
	}

	/**
	 * Do a request with the admin token
	 */
	private function request($url, $method = "GET") {
		$this->CI = &get_instance();
		if($this->CI->session->userdata('token') == null){
			$this->auth();
		}
		
		$http = curl_init();
		curl_setopt($http, CURLOPT_URL, $url);
		curl_setopt($http, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($http, CURLOPT_CUSTOMREQUEST, $method);
		// Set headers
		curl_setopt($http, CURLOPT_HTTPHEADER, array(
			'Authorization: ' . $this->CI->session->userdata('token')
		));
		$response = curl_exec($http);
		$http_status = curl_getinfo($http, CURLINFO_HTTP_CODE);
		curl_close($http);


		switch ($http_status) {
			case 200:
				return $response;
				break;
			case 403:
				if (strpos($response,'token') && strpos($response,'not valid')) {
					// Token expired, get new token and retry
					$this->auth();
					$this->request($url, $method);
				}else{		
					throw new ErrorException($response);
				}
				break;
			default:
				throw new ErrorException($response);
				break;
		}
	}

}

?>
