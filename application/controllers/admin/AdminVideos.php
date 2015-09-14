<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AdminVideos extends MY_Controller {

    protected $data = [];
    protected $authorizedActions = [];

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
        $action = $this->router->fetch_method();

        if (!$this->isAdminSignedIn() && !in_array($action, $this->authorizedActions)) {
            redirect('admin/adminSession/signin', 'refresh');
        }
    }

    //the table view here
    public function index() {
        //esta es la pagina se entra si se pone www.mipagina.com/Video 
        /* $data["log"] = 0;
          if ($this->isAuthorized()) {
          $data["log"] = 1;
          } */
        $this->load->library('pagination');
        $this->load->model("admin_model");
        $this->load->model("video_model");
        $configPager['base_url'] = base_url() . 'admin/adminvideos/index';
        $configPager['total_rows'] = $this->video_model->getVideosQuantity();
        $configPager["uri_segment"] = 4;
        $configPager['per_page'] = 10;
        $this->pagination->initialize($configPager);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $data['links'] = $this->pagination->create_links();
        $videos = $this->video_model->getVideosForAdmin($page, $configPager['per_page']);
        $data['videos'] = $videos;
        $this->load->view('admin/videos_dashboard_layout', $data);
        return;
    }

    //logical delete
    public function activate() {
        $this->load->library('session'); //no necesario debido a que esta en el constructor
        $this->load->model("video_model");
        $this->load->model("admin_model");
        $id = $this->uri->segment(4, 0);
        $this->video_model->activate($id);
        redirect('admin/adminVideos/index', 'refresh');
        return;
    }

    //logical undelete
    public function deactivate() {
        $this->load->library('session'); //no necesario debido a que esta en el constructor
        $this->load->model("video_model");
        $this->load->model("admin_model");
        $id = $this->uri->segment(4, 0);
        $this->video_model->deactivate($id);
        redirect('admin/adminVideos/index', 'refresh');
        return;
    }

    public function gotoVideo() {
        
    }

}
