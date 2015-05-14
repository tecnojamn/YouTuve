<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Video extends CI_Controller {

    const ACTIVE_DEFAULT_VALUE = '1';

    function __construct() {
        parent::__construct();
        //cargo librerias,helpers necesarios en constructor.
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
    }

    public function index() {
        //esta es la pagina se entra si se pone www.mipagina.com/Video 
    }

    /**
     * Muestra la pagina de el formulario de agregar videos
     */
    public function formAdd() {
        //no models needed.. obviously
        //
        //solo permitido si esta logeuado
        //muestra alguna pagina todavia no sabemos cual
        /* if(!logueado){
          //muestra alguna pagina todavia no sabemos cual
          $this->load->view('caca');
          }else{
          //muestra alguna pagina todavia no sabemos cual
          $this->load->view('mostrar formpage');
          } */
    }

    /**
     * Persiste un video en la BD 
     */
    public function add() {
        $this->load->model('video_model');
        $this->video_model->table="Video";
        //control
        //solo permitido si esta logeuado
        //
        //saco el id de user de la sesion
        //
        $user = "";
        //valido la data del form
        $this->form_validation->set_rules('name', 'name', 'required');
        $this->form_validation->set_rules('link', 'link', 'required');
        $this->form_validation->set_rules('duration', 'duration', 'required');
        //date= now();
        $date = date('Y-m-d H:i:s'); //no se si es la misma que sql hay que ver esto cuando se haga
        //asigno variables
        $name = $this->input->post('name');
        $link = $this->input->post('link');
        $durationInSec = $this->input->post('duration');
        $active = Video::ACTIVE_DEFAULT_VALUE; //ByDefault

        if ($this->form_validation->run() == FALSE) {
            //muestra alguna pagina todavia no sabemos cual
            $this->load->view('homePage');
        } else {
            //inserta y redirige a algun lado todavia no sabemos
            if ($this->video_model->push($idUser, $name, $link, $date, $durationInSec, $active)) {
                //muestra alguna pagina todavia no sabemos cual
                $this->load->view('homePage');
                exit; //andate de esta funcion
            }
            //muestra alguna pagina todavia no sabemos cual
            $this->load->view('homePage');
        }
    }

}
