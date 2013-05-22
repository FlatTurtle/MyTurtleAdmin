<?php

/**
 * FlatTurtle bvba
 * @author: Michiel Vancoillie
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Advanced extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        $this->load->model('infoscreen');
        $this->load->library('my_formvalidation');
        $this->load->helper('directory');

        // Set validation rules
        if($this->session->userdata('rights') == 100){
            $this->my_formvalidation->set_rules('title', 'title', 'required|trim|max_length[255]');
            $this->my_formvalidation->set_rules('hostname', 'hostname', 'trim|max_length[50]');
            $this->my_formvalidation->set_rules('pincode', 'pincode', 'trim|max_length[20]');
        }
        $this->my_formvalidation->set_rules('location', 'location', 'required|trim');
        $this->my_formvalidation->set_rules('longitude', 'longitude', 'callback_check_geocode');
        $this->my_formvalidation->set_rules('color', 'color', 'callback_check_color');
        $this->my_formvalidation->set_error_delimiters('&bull;&nbsp;', '<br/>');
    }

    /**
     * Settings screen information
     */
    public function index($alias){
        $data['infoscreens'] = getInfoscreens();
        foreach($data['infoscreens'] as $infoscreen){
            if($infoscreen->alias == $alias)
                $data['infoscreen'] = $infoscreen;
        }

        $data['errors'] = $this->session->flashdata('errors');
        $data['all_errors'] = $this->session->flashdata('all_errors');
        $data['file_error'] = $this->session->flashdata('file_error');

        $data['menu_second_item'] = lang("term_settings");

        if ($data['errors']) {
            if($this->session->flashdata('post_title'))
            $data['infoscreen']->title = $this->session->flashdata('post_title');
            if($this->session->flashdata('post_address'))
            $data['infoscreen']->location = $this->session->flashdata('post_address');
            $data['infoscreen']->color = $this->session->flashdata('post_color');
            $data['infoscreen']->hostname = $this->session->flashdata('hostname');
            $data['infoscreen']->pincode = $this->session->flashdata('pincode');
        }

        $data['logo'] = "";
        $logo_url = $this->config->item('upload_dir') . $alias . "/logo.png";
        if (file_exists($logo_url)) {
            $data['logo'] = $logo_url;
        }

        $this->load->view('header', $data);
        $this->load->view('screen/menu', $data);
        $this->load->view('screen/advanced/index', $data);
        $this->load->view('footer');
    }

    /*
     * Settings information update
     */
    public function update($alias){
        // Try to suggest color
        if (!preg_match('/^#/', $this->input->post('color'))) {
            $_POST['color'] = '#' . substr($_POST['color'], 0, 6);
        }

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


        // Handle the logo upload and resize
        if (!empty($_FILES['logo']['name'])) {
            $uploaddir = $this->config->item('upload_dir') . $alias;
            $uploadfile = $uploaddir . '/temp.' . pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);

            if (!file_exists($uploaddir)) {
                mkdir($uploaddir, 0777, true);
            }

            if (!move_uploaded_file($_FILES['logo']['tmp_name'], $uploadfile)) {
                $this->session->set_flashdata('file_error', '&bull;&nbsp;'. lang('error_logo_upload'));
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
            $this->session->set_flashdata('post_address', $this->input->post('location'));
            $this->session->set_flashdata('post_title', $this->input->post('title'));
            $this->session->set_flashdata('post_color', $this->input->post('color'));
            $this->session->set_flashdata('pincode', $this->input->post('pincode'));
            $this->session->set_flashdata('hostname', $this->input->post('hostname'));
            $this->session->set_flashdata('all_errors', $this->my_formvalidation->error_string());
            $this->session->set_flashdata('errors', $this->my_formvalidation->error_array());
        }
        redirect(site_url($alias . '/settings'));
    }

    /**
     * Screenshots tab
     */
    public function shots($alias){
        $data['infoscreens'] = getInfoscreens();
        foreach($data['infoscreens'] as $infoscreen){
            if($infoscreen->alias == $alias)
                $data['infoscreen'] = $infoscreen;
        }

        $data['menu_second_item'] = lang("term_screenshots");

        $shots_path = $this->config->item('screenshots_path');
        $shots_path .=  $data['infoscreen']->hostname . "/thumbs/";
        if(!is_dir($shots_path)){
            redirect(site_url($alias));
        }

        $shots = array();
        // Get all screenshots
        if ($handle = opendir($shots_path)) {
            /* This is the correct way to loop over the directory. */
            while (false !== ($entry = readdir($handle))) {
                array_push($shots, $entry);
            }
            sort($shots);
            $shots = array_reverse($shots);
            closedir($handle);
        }

        // Only show last 16 shots
        $shots = array_slice($shots, 0, 20);

        // Get all image data
        $data['shots'] = array();
        foreach($shots as $shot){
            if(is_file($shots_path . $shot)){
                $image = @file_get_contents($shots_path . $shot);
                if($image){
                    $splitname = explode('.', $shot);
                    $title = @DateTime::createFromFormat("Ymd-Hi", $splitname[0]);

                    $shotObj = new stdClass();
                    $shotObj->name = $splitname[0];
                    $shotObj->title = $title->format('d/m/Y'). " &mdash; " .$title->format('H:i');
                    $image = base64_encode($image);
                    $shotObj->data = $image;

                    array_push($data['shots'], $shotObj);
                }
            }
        }
        $data['shots_path'] =  $shots_path;



        $this->load->view('header', $data);
        $this->load->view('screen/menu', $data);
        $this->load->view('screen/advanced/shots', $data);
        $this->load->view('footer');
    }

    /**
     * Screenshots detail
     */
    public function shot($alias, $name){
        $data['infoscreen'] = $this->infoscreen->get($alias);

        $shots_path = $this->config->item('screenshots_path');
        $shots_path .=  $data['infoscreen']->hostname . "/";
        $name .= ".jpg";

        if(is_file($shots_path . $name)){
            $image = @file_get_contents($shots_path . $name);
            if($image){
                header("Content-type: image/jpg");
                echo $image;
            }
        }else{
            redirect(site_url($alias . '/shots'));
        }
    }

}