<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

    private $ALT_PROFILE_PIC;

    function __construct() {
        parent::__construct();
//cargo librerias,helpers necesarios en constructor.
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        $this->load->library('session');
        $this->load->helper('url');
        $this->ALT_PROFILE_PIC = base_url() . "css/images/default_user.jpg";
    }

    public function profile() {
        //Es el perfil de usuario
        //solo permitido SI esta logeuado
        if (!$this->isAuthorized()) {
            $data["error"] = 1;
            $data["error_message"] = "Que haces por acá Picaron?.";
            $this->load->view('home_layout', $data);
            return; //andate de esta funcion
        } else {
            $this->load->model('user_model');
            $data["log"] = 1;
            $data["error"] = 0;
            $res = false;

            if (($this->uri->segment(3) === null) || $this->uri->segment(3) === "" || $this->uri->segment(3) === "me" || $this->uri->segment(3) === $this->session->userdata('nick')) {
                $data["profile"] = "me";
                $res = $this->user_model->selectByNick($this->session->userdata('nick'));
            } else if ($this->uri->segment(3) !== "" || ($this->uri->segment(3) !== null)) {
                $data["profile"] = "alien";
                $res = $this->user_model->selectByNick("" . $this->uri->segment(3) . "");
            }
            if ($res !== false) {
                if ($res->thumbUrl === "") {
                    $res->thumbUrl = $this->ALT_PROFILE_PIC;
                }
                $data["user_data"] = $res;
                //aca habria que pedir videos
                $this->load->view('user_layout', $data);
                return; //andate de esta funcion  
            } else {
                show_404();
                return;
            }
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
        $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'password', 'trim|required');

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
                    'nick' => $user->nick,
                    'logged_in' => TRUE
                );
                $this->session->set_userdata($session); //guarda en session
                $data["log"] = 1;
//mando a homepage
                redirect('/', 'refresh');
                return;
            }
            $data["error"] = 1;
            $data["error_message"] = "Email o contraseña invalidos.";
            $this->load->view('login_layout', $data);
        }
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
            $this->load->view('register_layout', $data);
            exit; //andate de esta funcion
        }
//valido la data del form
        $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');
        $this->form_validation->set_rules('name', 'name', 'trim|required');
        $this->form_validation->set_rules('nick', 'nick', 'trim|required');
        $this->form_validation->set_rules('password', 'password', 'trim|required');
        $this->form_validation->set_rules('lastname', 'lastname', 'trim|required');
        $this->form_validation->set_rules('birthday', 'birthday', 'trim|required');
        $this->form_validation->set_rules('gender', 'gender', 'trim|required');
//$this->form_validation->set_rules('thumbUrl', 'thumbUrl', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data["error"] = 1;
            $data["error_message"] = "Asegurese que escribió correctamente.";
            $this->load->view('register_layout', $data);
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
            $this->load->view('register_layout', $data);
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
