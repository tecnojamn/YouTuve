<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AdminComments extends MY_Controller {

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
        //load comments
        //this->data=comments
        //load view
        //set view data
        $this->load->model('video_model');
        $videos = $this->video_model->getVideos();
        $data['videos'] = $videos;
        //var_dump($videos);
        $this->load->view('admin/comment_video_dashboard_layout', $data);
        return;
    }

    //logical delete
    public function delete() {
        $this->load->model('comments_model');
        $idComment = $this->uri->segment(4);
        if (isset($idComment)) {
            $success = $this->comments_model->deleteComment($idComment);
            if ($success == 1) {
                $this->session->set_flashdata('message', 'El comentario ha sido dado de baja.');
                $this->session->set_flashdata('error', 0);
            } else {
                $this->session->set_flashdata('message', 'Ha ocurrido un error');
                $this->session->set_flashdata('error', 1);
            }
        } else {
            $this->session->set_flashdata('message', 'Error');
            $this->session->set_flashdata('error', 1);
        }
        //Deja al usuario en la misma pagina de donde llamo a la funcion
        redirect($_SERVER['HTTP_REFERER']);
    }

    //logical undelete
    public function undelete() {
        $this->load->model('comments_model');
        $idComment = $this->uri->segment(4);
        if (isset($idComment)) {
            $success = $this->comments_model->undeleteComment($idComment);
            if ($success == 1) {
                $this->session->set_flashdata('message', 'El comentario ha sido dado de alta.');
                $this->session->set_flashdata('error', 0);
            } else {
                $this->session->set_flashdata('message', 'Ha ocurrido un error');
                $this->session->set_flashdata('error', 1);
            }
        } else {
            $this->session->set_flashdata('message', 'Error');
            $this->session->set_flashdata('error', 1);
        }
        //Deja al usuario en la misma pagina de donde llamo a la funcion
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function gotoComment() {
        
    }

    public function viewCommentsFromVideo() {
        $this->load->model('comments_model');
        $this->load->library('pagination');
        $page = 10;
        $idVideo = $this->uri->segment(4);
        $offset = $this->uri->segment(5);
        $configPager['base_url'] = base_url() . 'admin/admincomments/viewCommentsFromVideo/'.$idVideo;
        $configPager['total_rows'] = $this->comments_model->commentQuantityByVideo($idVideo);
        $configPager['per_page'] = $page;
        $configPager['uri_segment'] = 5;
        $this->pagination->initialize($configPager);    
        $this->data['pagerLinks'] = $this->pagination->create_links();
        $comments = $this->comments_model->selectByVideo($idVideo, $page, $offset);
        $this->data['comments'] = $comments;
        $this->load->view('admin/comments_dashboard_layout', $this->data);
        return;
    }

}
