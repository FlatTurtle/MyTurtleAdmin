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
        header('Content-type: application/json');
        $data = false;

        if(isset($_FILES['file-'.$file_id]['name'])){
            $filename = basename($_FILES['file-'.$file_id]['name']);

            if(!is_dir(SIGNAGE_UPLOAD_DIR. $turtle_id)){
                mkdir(SIGNAGE_UPLOAD_DIR. $turtle_id, 0777, true);
            }

            $uploaddir = SIGNAGE_UPLOAD_DIR;
            $uploadfile = $uploaddir . $turtle_id . "/" . $file_id . ".png";

           $data = $uploadfile;

            if (@move_uploaded_file($_FILES['file-'.$file_id]['tmp_name'], $uploadfile)) {
                $data = base_url() . "uploads/signage/" . $turtle_id . "/" . $file_id . ".png";

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
                    imagepng($logo_gd_image, $uploadfile);
                    imagedestroy($source_gd_image);
                    imagedestroy($logo_gd_image);
                }
            }
        }

        echo json_encode($data);
        exit();
    }


    /**
     * Uploads for signage turtle
     */
    public function signage_delete_logo($alias, $turtle_id, $file_id){
        header('Content-type: application/json');
        $data = false;

        $uploaddir = SIGNAGE_UPLOAD_DIR;
        $uploadfile = $uploaddir . $turtle_id . "/" . $file_id . ".png";

        if(is_file($uploadfile)){
           @unlink($uploadfile);
           $data = true;
        }

        echo json_encode($data);
        exit();
    }

    /*
     *  Deleting the uploaded image
     */
    public function delete_image($alias, $turtle_id, $file_id){
        header('Content-type: application/json');
        $data = false;

        $uploaddir = UPLOAD_DIR;
        $uploadfile = $uploaddir . $turtle_id . "/" . $file_id . ".png";

        if(is_file($uploadfile)){
            @unlink($uploadfile);
            $data = true;
        }

        echo json_encode($data);
        exit();
    }
}

?>