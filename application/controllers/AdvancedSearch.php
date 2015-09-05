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
        $filters = explode(",", $filters, 20);
        $page = ($this->input->get("page") !== NULL) ? $this->input->get("page") : 1;
        $page = ($page > 0) ? $page : 1;
        $this->load->model('video_model');
        if (count($query) == "0") {
            $this->data["searching"] = 0;
            $this->data["searched_videos"] = null;
        } else {
            $this->data["searching"] = 1;
            $videos = $this->video_model->findAdvanced($query, $filters, 10, ($page - 1) * 10);
            $this->data["searched_videos"] = $videos;
        }
        $this->load->view('advanced_search_layout', $this->data);
        return;
    }

}
