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
        $this->load->library('session'); //no necesario debido a que esta en el constructor
        /*$data["log"] = 0;
        if ($this->isAuthorized()) {
            $data["log"] = 1;
        }*/
        $this->load->model("admin_model");
        $this->load->model("video_model");
        $videos = $this->video_model->getVideosForAdmin(0,20);
        $data=array('videos'=>$videos);
        $this->load->view('admin/videos_dashboard_layout', $data);
        return;
    }
    
    //logical delete
    public function delete() {
        if (!$this->isAuthorized()) {
            $data["error"] = 1;
            $data["error_message"] = "Es necesario tener una cuenta de administrador para acceder a esta sección.";
            redirect('/admin/adminsession/index', 'refresh');
            return; //andate de esta funcion
        }
        else{
                    $data["log"] = 1;
                            $idVideo = $this->input->get("id");
        if ($search == NULL) {
            $this->load->view("home_layout", $data);
            return;
        }

        }
    }

    //logical undelete
    public function undelete() {
        
    }

    public function gotoVideo() {
        
    }

}
