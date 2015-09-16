<?php

defined('BASEPATH') && defined('APPPATH') OR exit('No direct script access allowed');
include_once APPPATH . 'classes/AdminDTO.php';

class Admin_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table = "admin";
    }

    public function authorize($email, $password) {
        $condition["username"] = $email;
        $condition["password"] = $password;
        $result = $this->search($condition, "admin", 1, 0);
        if (count($result) === 1) {
            $admin = new AdminDTO();
            $admin->username = $result[0]->username;
            return $admin;
        } else {
            return false;
        }
    }



}
