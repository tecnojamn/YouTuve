<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AdminSession extends MY_Controller {

    protected $data = [];
    protected $authorizedActions = ['signin', 'signinpost'];

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
        $action = $this->router->fetch_method();

        if (!$this->isAdminSignedIn() && !in_array($action, $this->authorizedActions)) {
            redirect('admin/adminSession/signin', 'refresh');
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
        //dashboard
    }

}
