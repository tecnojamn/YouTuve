<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AdminUsers extends MY_Controller {

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
        $this->load->model('user_model');
        $this->data["users"] = $this->user_model->getUsers(30, 0);
        $this->load->view('admin/users_dashboard_layout', $this->data);
        return;
    }

    //logical delete
    public function delete() {
        $this->load->model('user_model');
        $idUser = $this->uri->segment(4);
        if (isset($idUser)) {
            $success = $this->user_model->deleteUser($idUser);
            if ($success == 1) {
                $this->session->set_flashdata('message', 'Usuario dado de baja.');
                $this->session->set_flashdata('error', 0);
            } else {
                $this->session->set_flashdata('message', 'Usuario ya dado de baja');
                $this->session->set_flashdata('error', 1);
            }
        } else {
            $this->session->set_flashdata('message', 'Error');
            $this->session->set_flashdata('error', 1);
        }

        redirect('/admin/AdminUsers/index');
    }

    //logical undelete
    public function undelete() {
        $this->load->model('user_model');
        $idUser = $this->uri->segment(4);
        if (isset($idUser)) {
            $success = $this->user_model->undeleteUser($idUser);
            if ($success == 1) {
                $this->session->set_flashdata('message', 'Usuario dado de alta.');
                $this->session->set_flashdata('error', 0);
            } else {
                $this->session->set_flashdata('message', 'Usuario ya dado de alta');
                $this->session->set_flashdata('error', 1);
            }
        } else {
            $this->session->set_flashdata('message', 'Error');
            $this->session->set_flashdata('error', 1);
        }

        redirect('/admin/AdminUsers/index');
    }

    //reset user password setting active to 0 and sending email with new token
    public function resetPassword() {
        
    }

    //use banned until DB field ->example: banned_until="date()+1 month"
    public function ban() {
        $this->load->model('user_model');
        $idUser = $this->uri->segment(4);
        if (isset($idUser)) {
            $result = $this->user_model->ban($idUser);
            if ($result['success'] == 1) {
                $this->session->set_flashdata('message', 'Usuario ' . $result['nick'] . ' baneado hasta el día '.date("d/m/Y", strtotime($result['banned_until'])));
                $this->session->set_flashdata('error', 0);
            }
        } else {
            $this->session->set_flashdata('message', 'Error');
            $this->session->set_flashdata('error', 1);
        }

        redirect('/admin/AdminUsers/index');
    }
    
    public function unban() {
        $this->load->model('user_model');
        $idUser = $this->uri->segment(4);
        if (isset($idUser)) {
            $result = $this->user_model->unban($idUser);
            var_dump($result);
            if ($result['success'] == 1) {
                $this->session->set_flashdata('message', 'Usuario ' . $result['nick'] . ' ya no se encuentra baneado.');
                $this->session->set_flashdata('error', 0);
            }
        } else {
            $this->session->set_flashdata('message', 'Error');
            $this->session->set_flashdata('error', 1);
        }

        redirect('/admin/AdminUsers/index');
    }

}