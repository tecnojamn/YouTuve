<?php

defined('BASEPATH') OR exit('No direct script access allowed.');
if (!function_exists('upload_user_thumb')) {

    /**
     * returns true si se puede subir la img
     */
    function upload_user_thumb($userName, $imgName = "thumb.png", $fieldName = "user_thumb") {
        $dir = FCPATH . USER_THUMB_IMAGE_UPLOAD . $userName;
        $upload_config = array('upload_path' => $dir, 'allowed_types' =>
            'jpg|jpeg|gif|png', 'max_size' => '2048000', 'max_width' => '1024', 'max_height' =>
            '768',);
        $upload_config['overwrite'] = TRUE;
        $upload_config['file_name'] = $imgName;

        $CI = & get_instance();
        $CI->load->library('upload', $upload_config);

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        if (!$CI->upload->do_upload($fieldName)) {
            return array('error' => true, 'error_msg' => $CI->upload->display_errors('', ''));
        } else {
            // upload success
            $upload_data = $CI->upload->data();
            return array('error' => false, 'data' => $upload_data);
        }
    }

}