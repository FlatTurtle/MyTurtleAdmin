<?php

/**
 * FlatTurtle bvba
 * @author: Quentin Kaiser
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Rooms extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        $this->load->model('infoscreen');
        $this->load->model('room');
    }

    /**
     *  Room page
     */
    public function index($alias) {
        $data = array();
        $data['infoscreen'] = $this->infoscreen->get($alias); 
        $data['rooms'] = $this->room->get_all($this->session->userdata('username'));
        $this->load->view('header', $data);
        $this->load->view('screen/rooms', $data);
        $this->load->view('footer');
    }

    public function get($alias, $name, $edit=false) {
        $data = array();
        $data['infoscreen'] = $this->infoscreen->get($alias); 
        $data['room'] = $this->room->get_by_name($this->session->userdata('username'), $name);
        $data['edit'] = $edit;
        $this->load->view('header', $data);
        $this->load->view('screen/room', $data);
        $this->load->view('footer');
    }

    /**
     * Update a room instance
     */
    public function update($alias) {
        throw new Exception("Not yet implemented");
    }

    /**
     * Delete room instance
     */
    public function delete($alias){
        throw new Exception("Not yet implemented");
    }

    /**
     * Create new room instance
     */
    public function create($alias){

        print_r($this->input->post());

        $data['name'] = $this->input->post('name'); 
        $data['type'] = 'room';
        $data['body'] = array();
        $data['body']['name'] = $this->input->post('name');
        $data['body']['description'] = $this->input->post('description');
        $data['body']['type'] = 'room';
        $data['body']['opening_hours'] = array();
        $data['body']['price'] = array();
        $data['body']['price']['currency'] = 'EUR';
        $data['body']['price']['hourly'] = 5;
        $data['body']['price']['daily'] = 40;
        $data['body']['location'] = array();
        $data['body']['location']['map'] = array();
        $data['body']['location']['map']['img'] = $this->input->post('location_map_img');
        $data['body']['location']['map']['reference'] = $this->input->post('location_map_reference');
        $data['body']['location']['floor'] = $this->input->post('location_floor');
        $data['body']['location']['building_name'] = 'main';
        $data['body']['contact'] = $this->input->post('contact');
        $data['body']['support'] = $this->input->post('support');
        $data['body']['amenities'] = array();

        if(True){
            $room = $this->room->create($alias, $this->input('name'), $data);
            echo $this->room->template($room);
            return;    
        }
        echo "false";
    }

    /**
     * Uploads for room map
     */
    public function map_upload_image($alias, $turtle_id, $file_id){
        $this->upload_image_auto_crop($alias, $turtle_id, $file_id, MAP_UPLOAD_DIR, LOGO_MAX_WIDTH, LOGO_MAX_HEIGHT, "uploads/map/");
    }


    /**
     * Uploads for room map
     */
    public function map_delete_image($alias, $turtle_id, $file_id){
        header('Content-type: application/json');
        $data = true;
        if(!$this->delete_image($alias, $turtle_id, $file_id, MAP_UPLOAD_DIR)){
            $data = false;
        }
        echo json_encode($data);
        exit();
    }


    /**
     * Crop an image to specified coordinates and save with specified filename in specified directory.
     *
     * @param $image
     * @param $coords : associative array with x1, y1, x2, y2
     * @param $filename
     * @param $directory
     * @return bool
     */
    private function crop($image, $coords, $filename, $directory){
        $x1 = $coords->x1;
        $y1 = $coords->y1;
        $x2 = $coords->x2;
        $y2 = $coords->y2;

        // target width and height
        $width = $x2 - $x1;
        $height = $y2 - $y1;

        //removing the 0 values if the image is smaller
        if($x1 < 0) $x1 = 0;
        if($y1 < 0) $y1 = 0;
        if($x2 < 0) $x2 = 0;
        if($y2 < 0) $y2 = 0;


        // quality
        $png_quality = 0;


        list($source_image_width, $source_image_height, $source_image_type) = getimagesize($image);
        switch ($source_image_type) {
            case IMAGETYPE_GIF:
                $original_image = imagecreatefromgif($image);
                break;
            case IMAGETYPE_JPEG:
                $original_image = imagecreatefromjpeg($image);
                break;
            case IMAGETYPE_PNG:
                $original_image = imagecreatefrompng($image);
                break;
        }
        $new_image = ImageCreateTrueColor( $width, $height);


        $dst_x1 = 0;
        $dst_y1 = 0;
        // center horizontally
        if($source_image_width < $width){
            $dst_x1 = ($width - $source_image_width)/2;
            $width = $source_image_width;
        }
        //center vertically
        if($source_image_height < $height){
            $dst_y1 = ($height - $source_image_height)/2;
            $height = $source_image_height;
        }

        imagecopyresampled($new_image,$original_image,$dst_x1,$dst_y1,$x1,$y1,
            $width,$height,$width,$height);

        if(imagepng($new_image, $directory . $filename, $png_quality)){
            return true;
        }
        return false;
    }
    /**
     * @param $alias
     * @param $turtle_id
     * @param $file_id
     * @param $upload_dir : upload dir with trailing slash
     * @param $upload_path : path to return to the client
     *
     * @return file path relative to the application root
     */
    private function upload_image($alias, $turtle_id, $file_id, $upload_dir, $upload_path){
        if(isset($_FILES['slide-upload'])){

            if(!is_dir($upload_dir)){
                mkdir($upload_dir, 0777, true);
            }

            if(!is_dir($upload_dir . $alias)){
                mkdir($upload_dir . $alias, 0777, true);
            }

            if(!is_dir($upload_dir . $alias . "/" . $turtle_id)){
                mkdir($upload_dir . $alias . "/" . $turtle_id, 0777, true);
            }

            $uploaded_file = $upload_dir . $alias . "/" . $turtle_id . "/" . $file_id . ".png";
            if(@move_uploaded_file($_FILES['slide-upload']['tmp_name'], $uploaded_file )){
                $file_path =  $upload_path. $alias . "/" . $turtle_id . "/" . $file_id . ".png";


                list($source_image_width, $source_image_height, $source_image_type) = getimagesize($uploaded_file);

                return array("url"=>base_url() . $file_path, "width"=>$source_image_width, "height"=>$source_image_height);
            }

        }
        return false;
    }

    /*
     * Generic upload image function that auto crops the file to the specified max width and height
     */
    private function upload_image_auto_crop($alias, $turtle_id, $file_id, $upload_dir, $max_width, $max_height, $upload_path){
        header('Content-type: application/json');
        $data = false;

        if(isset($_FILES['file-'.$file_id]['name'])){
            $filename = basename($_FILES['file-'.$file_id]['name']);

            if(!is_dir($upload_dir. $turtle_id)){
                mkdir($upload_dir. $turtle_id, 0777, true);
            }

            $uploaddir = $upload_dir;
            $uploadfile = $uploaddir . $turtle_id . "/" . $file_id . ".png";

            $data = $uploadfile;

            if (@move_uploaded_file($_FILES['file-'.$file_id]['tmp_name'], $uploadfile)) {
                $data = base_url() . $upload_path . $turtle_id . "/" . $file_id . ".png";

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
                    $logo_aspect_ratio = $max_width / $max_height;
                    if ($source_image_width <= $max_width && $source_image_height <= $max_height) {
                        $image_width = $source_image_width;
                        $image_height = $source_image_height;

                    }
                    // adding a small value to source aspect ratio to accommodate for very small differences in aspect ratio
                    elseif ($logo_aspect_ratio > $source_aspect_ratio + 0.0005) {
                        $image_width = (int) ($max_width * $source_aspect_ratio);
                        $image_height = $max_height;
                    } else {
                        $image_width = $max_width;
                        $image_height = (int) ($max_width / $source_aspect_ratio);
                    }


                    $gd_image = imagecreatetruecolor($image_width, $image_height);
                    imagesavealpha($gd_image, true);
                    $color = imagecolorallocatealpha($gd_image, 0, 0, 0, 127);
                    imagefill($gd_image, 0, 0, $color);
                    imagecopyresampled($gd_image, $source_gd_image, 0, 0, 0, 0, $image_width, $image_height, $source_image_width, $source_image_height);
                    imagepng($gd_image, $uploadfile);
                    imagedestroy($source_gd_image);
                    imagedestroy($gd_image);
                }
            }
        }

        echo json_encode($data);
        exit();
    }

    /*
     * Generic image delete function
     */
    private function delete_image($alias, $turtle_id, $file_id, $upload_dir){
        $uploaddir = $upload_dir;
        $uploadfile = $uploaddir . $alias . "/" . $turtle_id . "/" . $file_id . ".png";

        if(is_file($uploadfile)){
            @unlink($uploadfile);
            return true;
        }
        return false;
    }
}

?>