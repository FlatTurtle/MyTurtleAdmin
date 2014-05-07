<?php

/**
 * FlatTurtle bvba
 * @author: Michiel Vancoillie
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Turtles extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        $this->load->model('infoscreen');
        $this->load->model('turtle');
        $this->load->model('pane');
    }

    /**
     * Turtle page
     */
    public function index($alias) {
        $data['infoscreens'] = getInfoscreens();
        foreach($data['infoscreens'] as $infoscreen){
            if($infoscreen->alias == $alias)
                $data['infoscreen'] = $infoscreen;
        }

        $data['panes'] = $this->pane->get_all($alias, 'list');
        $data['turtle_instances'] = array();
        try{
            $data['turtle_instances'] = $this->turtle->get($alias, 'list');
            foreach ($data['turtle_instances'] as $turtle) {
                $turtle->content = $this->turtle->template($turtle);
            }
        }catch(ErrorException $e){}
        $data['turtle_types'] = $this->turtle->get_all_types();

        $data['menu_second_item'] = lang("term_left");

        $this->load->view('header', $data);
        $this->load->view('screen/menu', $data);
        $this->load->view('screen/turtles', $data);
        $this->load->view('footer');
    }

    /**
     * AJAX URI for updating order
     */
    public function sort($alias) {
        $order = $this->input->post('order');
        if(!empty($order) && is_array($order)){
            $counter = 1;
            foreach($order as $id){
                $data['order'] = $counter;
                $this->turtle->order($alias, $id, $data);
                $counter++;
            }
            echo "true";
            return;
        }
        echo "false";
    }

    /**
     * AJAX URI for updating turtle options
     */
    public function update($alias) {
        $id = $this->input->post('id');
        unset($_POST['id']);
        if(!empty($id) && is_numeric($id)){

            if($this->input->post('options'))
                $data['options'] = json_encode($this->input->post('options'));

            $this->turtle->update($alias, $id, $data);
            echo "true";
            return;
        }
        echo "false";
    }

    /**
     * Delete turtle instance
     */
    public function delete($alias){
        $id = $this->input->post('id');
        if(!empty($id) && is_numeric($id)){
            $this->turtle->delete($alias, $id);
            echo "true";
            return;
        }
        echo "false";

    }

    /**
     * Create new turtle instance
     */
    public function create($alias){
        $data['type'] = $this->input->post('type');
        $data['pane'] = $this->input->post('pane');
        $data['options'] = '';

        if(!empty($data['type']) && is_numeric($data['pane'])){
            $turtle = $this->turtle->create($alias, $data);
            echo $this->turtle->template($turtle);
            return;
        }
        echo "false";
    }

    /**
     * Uploads for signage turtle
     */
    public function signage_upload_logo($alias, $turtle_id, $file_id){
        $this->upload_image_crop_hack($alias, $turtle_id, $file_id, SIGNAGE_UPLOAD_DIR, LOGO_MAX_WIDTH, LOGO_MAX_HEIGHT, "uploads/signage/");
    }


    /**
     * Uploads for signage turtle
     */
    public function signage_delete_logo($alias, $turtle_id, $file_id){
        header('Content-type: application/json');
        $data = true;
        if(!$this->delete_image($alias, $turtle_id, $file_id, SIGNAGE_UPLOAD_DIR)){
            $data = false;
        }
        echo json_encode($data);
        exit();
    }


    /**
     * Uploads an image for pricelist/weekmenu
     */
    public function upload_menu_image($alias, $turtle_id, $file_id){
        $this->upload_image_auto_crop($alias, $turtle_id, $file_id, MENU_IMAGE_UPLOAD_DIR, MENU_IMAGE_MAX_WIDTH, MENU_IMAGE_MAX_HEIGHT, "uploads/menu_images/");
    }


    /*
     *  Deleting the uploaded pricelist/weekmenu image
     */
    public function delete_menu_image($alias, $turtle_id, $file_id){
        header('Content-type: application/json');
        $data = true;
        if(!$this->delete_image($alias, $turtle_id, $file_id, MENU_IMAGE_UPLOAD_DIR)){
            $data = false;
        }
        echo json_encode($data);
        exit();
    }

    public function slideshow_delete($alias, $turtle_id, $file_id){
        header('Content-type: application/json');
        $data = true;

        if(!$this->delete_image($alias, $turtle_id, $file_id, SLIDESHOW_UPLOAD_DIR)){
            $data = false;
        }
        if(!$this->delete_image($alias, $turtle_id, $file_id . "-portrait", SLIDESHOW_UPLOAD_DIR)){
            $data = false;
        }

        if(!$this->delete_image($alias, $turtle_id, $file_id . "-landscape", SLIDESHOW_UPLOAD_DIR)){
            $data = false;
        }

        echo json_encode($data);
        exit();
    }

    /**
     * upload an image for the slideshow
     *
     * @param $alias
     * @param $turle_id
     * @param $file_id
     */
    public function slideshow_upload($alias, $turle_id, $file_id){
        header('Content-type: application/json');
        $data = false;

        $result = $this->upload_image($alias, $turle_id, $file_id, SLIDESHOW_UPLOAD_DIR, "uploads/slideshow_images/");
        if($result){
            $data = $result;
        }
        echo json_encode($data);
        exit();
    }

    public function slideshow_crop($alias, $turtle_id, $file_id){
        header('Content-type: application/json');
        $data = false;

        $directory = SLIDESHOW_UPLOAD_DIR . $alias . "/" . $turtle_id . "/";

        //find file with id
        $original_image = $directory . $file_id . ".png";

        //post data
        // _POST not populated so using input..
        $post_data = json_decode(file_get_contents('php://input'));

        //crop portrait
        $portrait_coords = $post_data->portrait;
        $portrait_crop = $this->crop($original_image, $portrait_coords, $file_id . "-portrait.png", $directory);

        //crop landscape
        $landscape_coords = $post_data->landscape;
        $landscape_crop = $this->crop($original_image, $landscape_coords, $file_id . "-landscape.png", $directory);

        if($landscape_crop && $portrait_crop){
            // return portrait uri (temp)
            $data = base_url() . "uploads/slideshow_images/" . $alias . "/" . $turtle_id . "/" . $file_id . "-portrait.png";
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
     * Special upload image function hack. Fix the actual issue and remove this one...
     */
    private function upload_image_crop_hack($alias, $turtle_id, $file_id, $upload_dir, $max_width, $max_height, $upload_path){
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

                    $old_x = imageSX($source_gd_image);
                    $old_y = imageSY($source_gd_image);

                    if ($old_x > $old_y) {
                        $percentage = ($max_width / $old_x);
                    } else {
                        $percentage = ($max_height / $old_y);
                    }   

                    $new_width = round($old_x * $percentage);
                    $new_height = round($old_y * $percentage);

                    $gd_image = imagecreatetruecolor($new_width, $new_height);
                    imagesavealpha($gd_image, true);
                    $color = imagecolorallocatealpha($gd_image, 0, 0, 0, 127);
                    imagefill($gd_image, 0, 0, $color);

                    imagecopyresampled($gd_image,$source_gd_image,0,0,0,0,$new_width,$new_height,$old_x,$old_y); 

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
