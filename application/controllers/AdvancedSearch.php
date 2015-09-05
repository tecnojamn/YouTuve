<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AdvancedSearch extends MY_Controller {

    protected $data = [];

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
        if ($this->isAuthorized()) {
            $this->data["log"] = 1;
        }
    }

    //
    public function index() {
        //get query and filters
        //if no query show nothing on videos
        $query = $this->input->get('query', TRUE);
        $filters = $this->input->get('filters', TRUE);
        $this->load->model('video_model');
        if (count($query) == "0") {
            $this->data["searching"] = 0;
        } else {
            $this->data["searching"] = 1;
        }
        $this->load->view('channel_layout', $this->data);
        return;
    }

}
