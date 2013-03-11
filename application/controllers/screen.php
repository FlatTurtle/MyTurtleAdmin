<?php

/**
 * FlatTurtle bvba
 * @author: Michiel Vancoillie
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Screen extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('option');
        $this->load->model('infoscreen');
        $this->load->library('my_formvalidation');
        $this->load->helper('directory');

        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        // Set validation rules
        $this->my_formvalidation->set_rules('title', 'title', 'required|trim|max_length[255]');
        $this->my_formvalidation->set_rules('location', 'location', 'required|trim');
        $this->my_formvalidation->set_rules('longitude', 'longitude', 'callback_check_geocode');
        $this->my_formvalidation->set_rules('color', 'color', 'callback_check_color');
        $this->my_formvalidation->set_error_delimiters('&bull;&nbsp;', '<br/>');
    }

    public function index() {
        redirect('/');
    }

    /**
     * Update an infoscreen
     */
    public function update($alias) {

        // Try to suggest color
        if (!preg_match('/^#/', $this->input->post('color'))) {
            $_POST['color'] = '#' . substr($_POST['color'], 0, 6);
        }

        // Only superadmin is allowed to update hostname
        if(!$this->session->userdata('rights'))
          unset($_POST['hostname']);

        // Get longitude and latitude of the location with google API
        $location = $this->input->post('location');
        if(!empty($location)){
            $http = curl_init();
            curl_setopt($http, CURLOPT_URL, 'https://maps.googleapis.com/maps/api/geocode/json?address='. urlencode($location) .'&sensor=false');
            curl_setopt($http, CURLOPT_RETURNTRANSFER, 1);

            $response = curl_exec($http);
            $http_status = curl_getinfo($http, CURLINFO_HTTP_CODE);
            curl_close($http);

            if($http_status == 200){
                $data = json_decode($response);
                if(!empty($data->results[0]->geometry->location)){
                    $result = $data->results[0]->geometry->location;
                    $_POST['latitude'] = $result->lat;
                    $_POST['longitude'] = $result->lng;
                }
            }
        }

        // Update the logo
        $footerdata['type']  = trim($this->input->post('footer_type'));
        if($footerdata['type'] == "message"){
            $footerdata['value']  = trim($this->input->post('footer_message'));
            if(empty($footerdata['value'])){
                $footerdata['value'] = ' ';
            }
        }else if($footerdata['type'] == "updates"){
            $footerdata['value']  = trim($this->input->post('footer_rss'));
        }else{
            $footerdata = null;
        }

        $this->infoscreen->footer($alias, $footerdata);
        unset($_POST['footer_type']);
        unset($_POST['footer_message']);
        unset($_POST['footer_rss']);


        // Handle the logo upload and resize
        if (!empty($_FILES['logo']['name'])) {
            $uploaddir = $this->config->item('upload_dir') . $alias;
            $uploadfile = $uploaddir . '/temp.' . pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);

            if (!file_exists($uploaddir)) {
                mkdir($uploaddir, 0777, true);
            }

            if (!move_uploaded_file($_FILES['logo']['tmp_name'], $uploadfile)) {
                $this->session->set_flashdata('file_error', '&bull;&nbsp;'. lang('error.logo_upload'));
            } else {
                // Resize the image
                list($source_image_width, $source_image_height, $source_image_type) = getimagesize($uploadfile);
                switch ($source_image_type) {
                    case IMAGETYPE_GIF:
                        $source_gd_image = imagecreatefromgif($uploadfile);
                        break;
                    case IMAGETYPE_JPEG:
                        $source_gd_image = imagecreatefromjpeg($uploadfile);
                        break;
                    case IMAGETYPE_PNG:
                        $source_gd_image = imagecreatefrompng($uploadfile);
                        break;
                }

                if ($source_gd_image) {
                    $source_aspect_ratio = $source_image_width / $source_image_height;
                    $logo_aspect_ratio = LOGO_MAX_WIDTH / LOGO_MAX_HEIGHT;
                    if ($source_image_width <= LOGO_MAX_WIDTH && $source_image_height <= LOGO_MAX_HEIGHT) {
                        $logo_image_width = $source_image_width;
                        $logo_image_height = $source_image_height;
                    } elseif ($logo_aspect_ratio > $source_aspect_ratio) {
                        $logo_image_width = (int) (LOGO_MAX_HEIGHT * $source_aspect_ratio);
                        $logo_image_height = LOGO_MAX_HEIGHT;
                    } else {
                        $logo_image_width = LOGO_MAX_WIDTH;
                        $logo_image_height = (int) (LOGO_MAX_WIDTH / $source_aspect_ratio);
                    }


                    $logo_gd_image = imagecreatetruecolor($logo_image_width, $logo_image_height);
                    imagesavealpha($logo_gd_image, true);
                    $color = imagecolorallocatealpha($logo_gd_image, 0, 0, 0, 127);
                    imagefill($logo_gd_image, 0, 0, $color);
                    imagecopyresampled($logo_gd_image, $source_gd_image, 0, 0, 0, 0, $logo_image_width, $logo_image_height, $source_image_width, $source_image_height);
                    imagepng($logo_gd_image, $uploaddir . '/logo.png');
                    imagedestroy($source_gd_image);
                    imagedestroy($logo_gd_image);
                }

                unlink($uploadfile);

                $_POST['logo'] = base_url().$uploaddir. '/logo.png';
            }
        }

        // Validate the input
        if ($this->my_formvalidation->run()) {
            $this->infoscreen->post($alias, $this->input->post());
        } else {
            $this->session->set_flashdata('post_title', $this->input->post('title'));
            $this->session->set_flashdata('post_color', $this->input->post('color'));
            $this->session->set_flashdata('all_errors', $this->my_formvalidation->error_string());
            $this->session->set_flashdata('errors', $this->my_formvalidation->error_array());
        }
        redirect($alias);
    }

    /**
     * Infoscreen view
     */
    public function show($alias) {
        $data['infoscreen'] = $this->infoscreen->get($alias);
        $data['errors'] = $this->session->flashdata('errors');
        $data['all_errors'] = $this->session->flashdata('all_errors');
        $data['file_error'] = $this->session->flashdata('file_error');

        $plugin_states = $this->infoscreen->plugin_states($alias);
        $data['state_clock'] = 1;
        $data['state_screen'] = 1;
        $data['footer'] = '';
        if(isset($plugin_states->clock))
            $data['state_clock'] = $plugin_states->clock;
        if(isset($plugin_states->power))
            $data['state_screen'] = $plugin_states->power;

        // Get footer data
        $data['footer'] = "";
        $data['footer_type'] = "none";
        $data['footer_types'] = array('none','message', 'updates');
        if(isset($plugin_states->footer_type)){
            $data['footer_type'] = $plugin_states->footer_type;
            if(isset($plugin_states->footer) && $data['footer_type'] != "none"){
                $data['footer'] = $plugin_states->footer;
                if($data['footer'] == " ") $data['footer'] = '';
            }
        }
        // Get available footer RSS links
        $data['rss_links'] = $this->option->get('footer_rss');

        $data['logo'] = "";
        $logo_url = $this->config->item('upload_dir') . $alias . "/logo.png";
        if (file_exists($logo_url)) {
            $data['logo'] = $logo_url;
        }

        if ($data['errors']) {
            $data['infoscreen']->title = $this->session->flashdata('post_title');
            $data['infoscreen']->color = $this->session->flashdata('post_color');
        }

        $this->load->view('header');
        $this->load->view('screen/single', $data);
        $this->load->view('footer');
    }

    /**
     * Check if a string is a valid hexadecimal color
     */
    public function check_color($value) {
        if (!preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $value)) {
            $message = str_replace('{{value}}', $value, lang('error.color_check_hex'));
            $this->my_formvalidation->set_message('check_color', $message);
            return false;
        }
        return true;
    }

    /**
     * Check if geocode could be resolved
     */
    public function check_geocode($value) {
        if ($value == null) {
            $this->my_formvalidation->set_message('check_geocode', lang('error.resolve_address'));
            return false;
        }
        return true;
    }

}

?>
