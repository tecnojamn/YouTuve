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
        //return;
    }

    //logical delete
    public function delete() {
        
    }

    //logical undelete
    public function undelete() {
        
    }

    public function gotoComment() {
        
    }

}
