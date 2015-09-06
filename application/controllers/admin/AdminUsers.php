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
        //load model
        //load users
        //this->data=users
        //load view
        //set view data
        //return;
    }

    //logical delete
    public function delete() {
        
    }

    //logical undelete
    public function undelete() {
        
    }

    //reset user password setting active to 0 and sending email with new token
    public function resetPassword() {
        
    }

    //use banned until DB field ->example: banned_until="date()+1 month"
    public function ban() {
        
    }

}
