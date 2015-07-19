<?php

/**
 * La idea es pedirle formularios via ajax
 *
 * @author nicolacio
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class AxForm extends CI_Controller {

    //put your code here

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
    }

    public function index() {
        show_404();
        return;
    }

    public function formUserEditInfo() {
        $data['name']= $this->input->post('name');
        $data['lastname'] = $this->input->post('lastname');
        $data['birthday'] = $this->input->post('birthday');
        $data['gender'] = $this->input->post('gender');
        
        $formString = $this->load->view('axviews/ax_edit_user_info_form', $data, true);
        $arr = array('result' => 'true', 'html' => $formString);
        echo json_encode($arr, JSON_HEX_QUOT | JSON_HEX_TAG);
        return;
    }

    public function formUserEditThumb() {
        $formString = $this->load->view('axviews/ax_edit_user_thumb_form', '', true);
        $arr = array('result' => 'true', 'html' => $formString);
        echo json_encode($arr, JSON_HEX_QUOT | JSON_HEX_TAG);
        return;
    }

  

}
