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
        $formString = $this->load->view('axviews/ax_edit_user_info_form', '', true);
        $arr = array('result' => 'true', 'html' => $formString);
        echo json_encode($arr, JSON_HEX_QUOT | JSON_HEX_TAG);
        return;
    }

}
