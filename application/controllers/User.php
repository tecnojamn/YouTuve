<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

    function __construct() {
        parent::__construct();
//cargo librerias,helpers necesarios en constructor.
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        $this->load->library('session');
        $this->load->helper('url');
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
                    $res->thumbUrl = base_url() . ALT_PROFILE_PIC;
                } else {
                    $res->thumbUrl = base_url() . USER_THUMB_IMAGE_UPLOAD . $res->thumbUrl;
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

    public function uploadThumb() {
        if (!$this->isAuthorized()) {
            $data["error"] = 1;
            $data["error_message"] = "Que haces por acá Picaron?.";
            $this->load->view('home_layout', $data);
            return; //andate de esta funcion
        }
        $data["log"] = 1;

        //save file
        $this->load->helper('MY_upload');
        $filename = "thumb.png";
        $uploadResult = upload_user_thumb($this->session->userdata('nick'), $filename, "user_thumb");
        if ($uploadResult["error"] === false) {
            //save on DB
            $this->load->model('user_model');
            $res = $this->user_model->edit($this->session->userdata('userId'), "", "", "", "", $this->session->userdata('nick') . "/" . $filename);
        }
        echo json_encode($uploadResult);
        return;
    }

    /**
     * Editar datos de usuario
     */
    public function editInfo() {
        if (!$this->isAuthorized()) {
            $data["error"] = 1;
            $data["error_message"] = "Que haces por acá Picaron?.";
            $this->load->view('home_layout', $data);
            return; //andate de esta funcion
        }
        $this->load->model('user_model');
        $data["log"] = 1;
        //valido la data del form
        $this->form_validation->set_rules('name', 'name', 'trim|required');
        $this->form_validation->set_rules('lastname', 'lastname', 'trim|required');
        $this->form_validation->set_rules('birthday', 'birthday', 'trim|required');
        $this->form_validation->set_rules('gender', 'gender', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data["error"] = 1;
            $data["error_message"] = "Asegurese que escribió correctamente.";
            $this->load->view('user_layout', $data);
        } else {
            $name = $this->input->post('name');
            $lastname = $this->input->post('lastname');
            $birthday = $this->input->post('birthday');
            $gender = $this->input->post('gender');
            if ($this->user_model->edit($this->session->userdata('userId'), $name, $lastname, $birthday, $gender, "")) {
//muestra alguna pagina todavia no sabemos cual
                $data["error"] = 0;
                redirect('/user/profile/me', 'refresh');
                return;
            }
            $data["error"] = 1;
            $data["error_message"] = "Ha ocurrido un error inesperado.";
            $this->load->view('user_layout', $data);
        }
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
        $this->load->library("email");
        $this->load->helper("email_content");
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
            $valCode = valCode();
            if ($this->user_model->push($email, $nick, $name, $password, $lastname, $birthday, $gender, $thumbUrl)) {
            $to=$email;
            $mailContent=validationMail($name, $valCode, $email);
            $this->email->sendMail($to, $mailContent->message, $mailContent->subject);
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

    //ajaxalyzed json borghes was here
    public function followChannelAX() {
        $this->load->helper("email_content");
        $this->load->library("email");
        $this->load->model("channel_model");
        $this->load->model("user_model");
        if (!$this->isAuthorized()) {
            $data["error"] = 1;
            $data["error_message"] = "No tienes autorización";
            $this->load->view('home_layout', $data);
            exit; //andate de esta funcion
        } 
        $this->load->model('user_model');
        $data["log"] = 1;
        $channelId = $this->input->post('channel');

        $userId = $this->session->userdata('userId');

        if ($this->user_model->followChannel($userId, $channelId)) {
            
            //Envio de Email al dueño del canal
            newFollowMail($userId, $channelId);
            
            echo json_encode(array('result' => 'true', 'html' => '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>'));
            return;
        } else {
            echo json_encode(array('result' => 'false', 'html' => '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>'));
            return;
        }
    }
    

}
