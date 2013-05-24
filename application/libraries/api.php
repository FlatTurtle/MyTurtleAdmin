<?php

/**
 * FlatTurtle bvba
 * @author: Michiel Vancoillie
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

use Guzzle\Http\Client;
use Guzzle\Http\Exception\BadResponseException;

class API {

    var $CI;
    var $client;
    var $API_PATH;

    /**
     * Create HTTP Client
     */
    public function __construct(){
        // Get CI instance
        $this->CI = &get_instance();

        $this->API_PATH = $this->CI->config->item('api_url');

        // Create a client and provide a base URL
        $this->client = new Client($this->API_PATH);
    }

    /**
     * Get a new admin token
     */
    public function auth() {

        try{

            // Create auth request
            $request = $this->client->post(API_AUTH_ADMIN, null, array(
                'username' => $this->CI->session->userdata('username'),
                'password' => $this->CI->session->userdata('password'),
            ));

            // Send the request and get the response
            $response = $request->send();
            if($response->isSuccessful()){
                $this->CI->session->set_userdata('token', json_decode($response->getBody()));
            }

        }catch(BadResponseException $e){

            // Catch 4xx and 5xx
            if (ENVIRONMENT == 'production')
                show_error("We are doing something wrong here, if this problem persists, please contact us!", $e->getResponse()->getStatusCode());
            else
                echo "<pre>";
                throw new ErrorException($e->getMessage());

        }

    }

    /**
     * Various types of requests
     */
    public function get($uri) {
        return $this->request($uri);
    }

    public function post($uri, $data = null) {
        return $this->request($uri, 'POST', $data);
    }

    public function put($uri, $data = null) {
        return $this->request($uri, 'PUT', $data);
    }

    public function delete($uri) {
        return $this->request($uri, 'DELETE');
    }

    /**
     * Do a request with the admin token
     */
    private function request($uri, $method = 'GET', $data = null) {
        if ($this->CI->session->userdata('token') == null) {
            $this->auth();
        }

        // Create auth request
        $request = $this->client->createRequest(
            $method,
            $this->API_PATH . $uri,
            null,
            $data
        )->addHeader('Authorization', $this->CI->session->userdata('token'));

        try{
            // Send the request and get the response
            $response = $request->send();
            if($response->isSuccessful()){
                return json_decode($response->getBody());
            }

        }catch(BadResponseException $e){

            // Error handling
            $http_status = $e->getResponse()->getStatusCode();
            $response = $e->getResponse()->getBody();

            // Check response code
            switch ($http_status) {

                case 401:
                    // Not authorized
                   $message = "You aren't the owner of that!";
                   break;

                case 403:
                    // Forbidden
                    if (strpos($response, 'token') && strpos($response, 'not valid')) {
                        // Token expired, get new token and retry
                        $this->auth();
                        return $this->request($url, $method, $data);
                    } else {
                        $message = 'You are not authorized to do this!';
                    }
                    break;

                case 404:
                    // Not found
                    if (ENVIRONMENT == 'production'){
                        list($null, $alias, $remainder) = explode("/", $uri);
                        list($segment , $remainder) = explode("?", $remainder);

                        // Fix for when a user has no panes (yet)
                        if($segment == "panes"){
                            throw new ErrorException($http_status);
                        }

                        show_404();

                    }
                    break;

                default:
                    $message = "We are doing something wrong here, if this problem persists, please contact us!";
                    break;

            }

            if (ENVIRONMENT == 'production')
                show_error($message, $http_status);
            else
                throw new ErrorException("<pre>" . $http_status . " - " . $response . "</pre>");
        }

    }

}