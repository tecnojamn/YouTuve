<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    function __construct() {
        parent::__construct();
//cargo librerias,helpers necesarios en constructor.
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function index() {
//esta es la pagina se entra si se pone www.mipagina.com/User 
//Es el perfil de usuario
//solo permitido SI esta logeuado
        if (!$this->isAuthorized()) {
            $data["error"] = 1;
            $data["error_message"] = "Que haces por acá Picaron?.";
            $this->load->view('home_layout', $data);
            exit; //andate de esta funcion
        } else {
//aca lo mandaria a un nuevo layout
        }
    }

    /**
     * Desloguea al usuario conectado
     */
    public function logOut() {
        $this->session->sess_destroy();
        redirect('/', 'refresh');
    }

    /**
     * Muestra el loginForm
     */
    public function loginForm() {
        $data["error"] = 0;
        $this->load->view('login_layout', $data);
    }

    /**
     * Muestra el loginForm
     */
    public function registerForm() {
        $data["error"] = 0;
        $this->load->view('register_layout', $data);
    }

    /**
     * user login
     */
    public function doLogin() {
        $this->load->model('user_model');
        $user = "";
//solo permitido si NO esta logeuado
        if ($this->isAuthorized()) {

            $data["error"] = 1;
            $data["error_message"] = "Que haces por acá Picaron?.";
            $this->load->view('home_layout', $data);
            return; //andate de esta funcion
        }

//valido la data del form
        $this->form_validation->set_rules('email', 'email', 'required');
        $this->form_validation->set_rules('password', 'password', 'required');

        if ($this->form_validation->run() == FALSE) {

            $data["error"] = 1;
            $data["error_message"] = "Asegurese que escribió correctamente.";
            $this->load->view('login_layout', $data);
        } else {
            $email = $this->input->post('email');
            $password = do_hash($this->input->post('password'), 'md5');

            $user = $this->user_model->authorize($email, $password);
            if ($user) {

//armo session 
                $session = array(
                    'userId' => $user->id,
                    'email' => $user->email,
                    'logged_in' => TRUE
                );
                $this->session->set_userdata($session); //guarda en session
//mando a homepage
                redirect('/', 'refresh');
                return;
            }
            $data["error"] = 1;
            $data["error_message"] = "Email o contraseña invalidos.";
            $this->load->view('login_layout', $data);
        }
    }

//Devuelve true si está logueado
    public function isAuthorized() {
        return (isset($this->session->userdata()["logged_in"]) && $this->session->userdata()["logged_in"] === TRUE);
    }

    /**
     * Persiste un user en la BD 
     */
    public function register() {
        $this->load->model('user_model');
//control
//solo permitido si NO esta logeuado
        if ($this->isAuthorized()) {
            $data["error"] = 1;
            $data["error_message"] = "Que haces por acá Picaron?.";
            $this->load->view('home_layout', $data);
            exit; //andate de esta funcion
        }
//valido la data del form
        $this->form_validation->set_rules('email', 'email', 'required');
        $this->form_validation->set_rules('name', 'name', 'required');
        $this->form_validation->set_rules('password', 'password', 'required');
        $this->form_validation->set_rules('lastname', 'lastname', 'required');
        $this->form_validation->set_rules('birthday', 'birthday', 'required');
        $this->form_validation->set_rules('gender', 'gender', 'required');
//$this->form_validation->set_rules('thumbUrl', 'thumbUrl', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data["error"] = 1;
            $data["error_message"] = "Asegurese que escribió correctamente.";
            $this->load->view('home_layout', $data);
        } else {
            $email = $this->input->post('email');
            $name = $this->input->post('name');
            $nick = $this->input->post('nick');
            $password = do_hash($this->input->post('password'), 'md5');
            $lastname = $this->input->post('lastname');
            $birthday = $this->input->post('birthday');
            $gender = $this->input->post('gender');
            $thumbUrl = "";
//inserta y redirige a algun lado todavia no sabemos
            if ($this->user_model->push($email, $nick, $name, $password, $lastname, $birthday, $gender, $thumbUrl)) {
//muestra alguna pagina todavia no sabemos cual
                $data["error"] = 0;
                redirect('/', 'refresh');
                return;
            }
            $data["error"] = 1;
            $data["error_message"] = "Ha ocurrido un error inesperado.";
            $this->load->view('home_layout', $data);
        }
    }

    /**
     * Se fija si el user tiene un canal
     */
    private function hasChannel($idUser) {
        $this->load->model('channel_model');
        $data = $this->channel_model->selectByIdUser($idUser);
        if ($data) {
            return $data["id"];
        } else {
            return 0;
        }
    }

}