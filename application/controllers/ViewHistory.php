<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ViewHistory
 *
 * @author maxi
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class ViewHistory extends MY_Controller {

    //put your code here
    function __construct() {
        parent::__construct();
//cargo librerias,helpers necesarios en constructor.
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    public function showHistory() {
        if (!$this->isAuthorized()) {
            $data["error"] = 1;
            $data["error_message"] = "No puedes acceder a esta seccion sin estar previamente logueado. PD: ¿Que haces por aqui picarón?";
        } else {
            $data['log'] = 1;
            $this->load->model('viewshistory_model');
            $userId = $this->session->userdata('userId');
            $history = $this->viewshistory_model->selectWatchedVideosByUser($userId,100,0); //definir limit y offset del history
            if ($history) {
                $data["history"] = $history;
                $this->load->view('history_layout', $data);
                return;
            }
            return; //andate de esta funcion
        }
        return;
    }

}
