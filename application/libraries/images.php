<?php

/**
 * FlatTurtle bvba
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Images {

    public function resize_crop($image,$width,$height) {
        $w = @imagesx($image); //current width
        $h = @imagesy($image); //current height
        if ((!$w) || (!$h)) { $GLOBALS['errors'][] = 'Image couldn\'t be resized because it wasn\'t a valid image.'; return false; }
        if (($w == $width) && ($h == $height)) { return $image; } //no resizing needed

        //try max width first...
        $ratio = $width / $w;
        $new_w = $width;
        $new_h = $h * $ratio;

        //if that created an image smaller than what we wanted, try the other way
        if ($new_h < $height) {
            $ratio = $height / $h;
            $new_h = $height;
            $new_w = $w * $ratio;
        }

        $image2 = imagecreatetruecolor ($new_w, $new_h);
        imagecopyresampled($image2,$image, 0, 0, 0, 0, $new_w, $new_h, $w, $h);

        //check to see if cropping needs to happen
        if (($new_h != $height) || ($new_w != $width)) {
            $image3 = imagecreatetruecolor ($width, $height);
            if ($new_h > $height) { //crop vertically
                $extra = $new_h - $height;
                $x = 0; //source x
                $y = round($extra / 2); //source y
                imagecopyresampled($image3,$image2, 0, 0, $x, $y, $width, $height, $width, $height);
            } else {
                $extra = $new_w - $width;
                $x = round($extra / 2); //source x
                $y = 0; //source y
                imagecopyresampled($image3,$image2, 0, 0, $x, $y, $width, $height, $width, $height);
            }
            imagedestroy($image2);
            return $image3;
        } else {
            return $image2;
        }
    }

    public function resize_max($image,$max_width,$max_height) {
        $w = @imagesx($image); //current width
        $h = @imagesy($image); //current height
        if ((!$w) || (!$h)) { $GLOBALS['errors'][] = 'Image couldn\'t be resized because it wasn\'t a valid image.'; return false; }

        if (($w <= $max_width) && ($h <= $max_height)) { return $image; } //no resizing needed

        //try max width first...
        $ratio = $max_width / $w;
        $new_w = $max_width;
        $new_h = $h * $ratio;

        //if that didn't work
        if ($new_h > $max_height) {
            $ratio = $max_height / $h;
            $new_h = $max_height;
            $new_w = $w * $ratio;
        }

        $new_image = imagecreatetruecolor ($new_w, $new_h);
        imagecopyresampled($new_image,$image, 0, 0, 0, 0, $new_w, $new_h, $w, $h);
        return $new_image;
    }

    public function resize_force($image,$width,$height) {
        $w = @imagesx($image); //current width
        $h = @imagesy($image); //current height
        if ((!$w) || (!$h)) { $GLOBALS['errors'][] = 'Image couldn\'t be resized because it wasn\'t a valid image.'; return false; }
        if (($w == $width) && ($h == $height)) { return $image; } //no resizing needed

        $image2 = imagecreatetruecolor ($width, $height);
        imagecopyresampled($image2,$image, 0, 0, 0, 0, $width, $height, $w, $h);

        return $image2;
    }

}