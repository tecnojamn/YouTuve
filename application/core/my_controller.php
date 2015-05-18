<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Base_Controller
 *
 * @author Nicolás
 */
class MY_Controller extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    //Devuelve true si está logueado
    public function isAuthorized() {
        return (isset($this->session->userdata()["logged_in"]) && $this->session->userdata()["logged_in"] === TRUE);
    }

}
