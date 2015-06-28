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
       $loged_in_data =$this->session->userdata();
        return (isset($loged_in_data["logged_in"]) && $loged_in_data["logged_in"] === TRUE);
    }

    /**
     * Se fija si el user tiene un canal
     */
    public function getChannel($idUser) {
        $this->load->model('channel_model');
        $data = $this->channel_model->selectByIdUser($idUser);
        //var_dump($data);
        if ($data) {
            return $data->id;
        } else {
            return false;
        }
    }

}
