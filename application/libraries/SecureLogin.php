<?php

/**
 * FlatTurtle bvba
 * @author: Michiel Vancoillie 
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once('phpass/PasswordHash.php');

define('PHPASS_HASH_STRENGTH', 8);
define('PHPASS_HASH_PORTABLE', true);

/**
 * SecureLogin Class
 *
 * Makes authentication simple and secure.
 */
class SecureLogin {

    var $CI;
    var $user_table = 'customer';

    /**
     * Create a user account
     */
    function create($user_name = '', $user_pass = '', $auto_login = true) {
        $this->CI = & get_instance();

        //Make sure account info was sent
        if ($user_name == '' OR $user_pass == '') {
            return false;
        }

        //Check against user table
        $this->CI->db->where('username', $user_name);
        $query = $this->CI->db->get_where($this->user_table);

        if ($query->num_rows() > 0) //user_email already exists
            return false;

        //Hash user_pass using phpass
        $hasher = new PasswordHash(PHPASS_HASH_STRENGTH, PHPASS_HASH_PORTABLE);
        $user_pass_hashed = $hasher->HashPassword($user_pass);

        //Insert account into the database
        $data = array(
            'username' => $user_name,
            'password' => $user_pass_hashed
        );

        $this->CI->db->set($data);

        if (!$this->CI->db->insert($this->user_table)) //There was a problem! 
            return false;

        if ($auto_login)
            $this->login($user_name, $user_pass);

        return true;
    }
    
    
    function change_password($user_id = '', $user_pass = ''){
        $this->CI = & get_instance();
        
         //Make sure account info was sent
        if ($user_id == '' OR $user_pass == '') {
            return false;
        }
        
         //Check against user table
        $this->CI->db->where('id', $user_id);
        $query = $this->CI->db->get_where($this->user_table);

        if ($query->num_rows() != 1)
            return false;
        
        //Hash user_pass using phpass
        $hasher = new PasswordHash(PHPASS_HASH_STRENGTH, PHPASS_HASH_PORTABLE);
        $user_pass_hashed = $hasher->HashPassword($user_pass);
        
        
        $this->CI->db->where('id', $user_id);
        $this->CI->db->update($this->user_table, array('password' => $user_pass_hashed));
        
        return true;

    }

    /**
     * Login and sets session variables
     */
	
    function login($user_name = '', $user_pass = '', $session_name='logged_in') {
        $this->CI = & get_instance();

        if ($user_name == '' OR $user_pass == '')
            return false;


        //Check if already logged in
        if ($this->CI->session->userdata('username') == $user_name && $this->CI->session->userdata('logged_in'))
            return true;

        //Check against user table
        $this->CI->db->where('username', $user_name);
        $query = $this->CI->db->get_where($this->user_table);


        if ($query->num_rows() > 0) {
            $user_data = $query->row_array();

            $hasher = new PasswordHash(PHPASS_HASH_STRENGTH, PHPASS_HASH_PORTABLE);

            if (!$hasher->CheckPassword($user_pass, $user_data['password']))
                return false;

            //Destroy old session
            $this->CI->session->sess_destroy();

            //Create a fresh, brand new session
            $this->CI->session->sess_create();
			
            //Set session data
			$user_data['password'] = $user_pass;
            $user_data[$session_name] = true;
            $this->CI->session->set_userdata($user_data);

            return true;
        }
        else {
            return false;
        }
    }

    /**
     * Logout user
     */
    function logout() {
        $this->CI = & get_instance();

        $this->CI->session->sess_destroy();
    }
}

?>
