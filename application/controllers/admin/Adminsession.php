<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AdminSession extends MY_Controller {

    protected $data = array();
    protected $authorizedActions = array('signin', 'signinpost');

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
        $action = $this->router->fetch_method();

        if($action=="signin" && $this->isAdminSignedIn()){
            redirect('admin/adminsession/index', 'refresh');
        }
        
        if (!$this->isAdminSignedIn() && !in_array($action, $this->authorizedActions)) {
            redirect('admin/adminsession/signin', 'refresh');
        }
        if($this->isAdminSignedIn()){
            $this->data["adminname"]=$this->session->userdata['username'];
        }
    }

    //Form de login para admin
    public function signIn() {
        $this->load->view('admin/sign_in_layout', $this->data);
        return;
    }

    //lógica de login para admin
    public function signInPost() {
        $username = $this->input->post('admin_user', TRUE);
        $password = $this->input->post('admin_password', TRUE);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('admin_user', 'User', 'required');
        $this->form_validation->set_rules('admin_password', 'Contraseña', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('admin/sign_in_layout', $this->data);
            return;
        } else {
            $this->load->model('admin_model');
            $admin = $this->admin_model->authorize($username, $password);
            if ($admin) {
                $session = array(
                    'admin' => TRUE,
                    'username' => $admin->username
                );
                $this->session->set_userdata($session); //guarda en session
                redirect('/admin/adminsession/index', 'refresh');
                return;
            } else {
                $this->session->set_flashdata('message', 'Usuario no encontrado.');
                $this->session->set_flashdata('error', 1);
                $this->load->view('admin/sign_in_layout', $this->data);
                return;
            }
        }
    }

    //
    public function index() {
        $this->load->model('user_model');
        $totalActiveUsers = $this->user_model->getTotalUsers();
        $totalInactiveUsers = $this->user_model->getTotalUsers(USER_INACTIVE);
        $userTotals['active'] = $totalActiveUsers;
        $userTotals['inactive']  = $totalInactiveUsers;
        $userTotals['total'] = $totalActiveUsers + $totalInactiveUsers;
        
        $this->load->model('video_model');
        $totalActiveVideos = $this->video_model->getTotalVideos();
        $totalInactiveVideos = $this->video_model->getTotalVideos(VIDEO_INACTIVE);
        $videoTotals['active'] = $totalActiveVideos;
        $videoTotals['inactive']  = $totalInactiveVideos;
        $videoTotals['total'] = $totalActiveVideos + $totalInactiveVideos;
        
        $this->load->model('comments_model');
        $totalActiveComments = $this->comments_model->getTotalComments();
        $totalInactiveComments = $this->comments_model->getTotalComments(COMMENT_INACTIVE);
        $commentTotals['active'] = $totalActiveComments;
        $commentTotals['inactive']  = $totalInactiveComments;
        $commentTotals['total'] = $totalActiveComments + $totalInactiveComments;
        
        $totals['users'] = $userTotals;
        $totals['videos'] = $videoTotals;
        $totals['comments'] = $commentTotals;
        
        $this->data['totals']= $totals;
        
        $this->load->view('admin/index_dashboard_layout', $this->data);
        return;
    }

    public function signout() {
        $this->load->view('admin/index_dashboard_layout');
        $this->session->sess_destroy();
        redirect('/admin/adminsession/index', 'refresh');
        return;
    }

}
