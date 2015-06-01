<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Channel
 *
 * @author maxi
 */
class Channel extends MY_Controller {
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
    }

    public function index() {
        show_404();
        return;
    }
    
    public function view() {
        if ($this->isAuthorized())
            $data["log"] = 1;
        $this->load->model('channel_model');
        $id = $this->uri->segment(3, 0);
        if ($id !== null) {
            $channel_info = $this->channel_model->selectByIdChannel($id);
            if ($channel_info) {
                $data["channel"] = $channel_info;
                $this->load->view('channel_layout', $data);
                return;
            }
        }
        show_404();
        return;
    }
}
