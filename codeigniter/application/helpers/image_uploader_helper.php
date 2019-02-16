<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function upload_image($controller) {

    $config['upload_path'] = dirname($_SERVER["SCRIPT_FILENAME"]) . UPLOADED_IMAGES_PATH;
    $config['allowed_types'] = 'jpg|png';
//    $config['max_size'] = '2000';
//    $config['max_width'] = '2024';
//    $config['max_height'] = '1768';
    // $config['file_name'] = 'ssss';
    $controller->load->library('upload', $config);

    if (!$controller->upload->do_upload()) {
        $error = $controller->upload->display_errors();
//        var_dump($error); die();
        throw new Exception($error);
    } else {
        $data = $controller->upload->data();
        return $data;
    }
}
