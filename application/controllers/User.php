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
    public function changePassForm() {
        $data["error"] = 0;
        $this->load->view('change_password_layout', $data);
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

    public function mailForgotPassword() {
        $this->load->helper("email_content");
        $this->load->library("email");
        $this->load->model('user_model');
        $mail = $this->input->post("email");
        if (isset($mail) && $mail !== "") {
            $mailExists = $this->user_model->emailExists($mail);
            if ($mailExists) {
                $valCode = valCode();
                $to = $mail;
                $this->user_model->updateValidationCode($mail, $valCode);
                $mailContent = forgotPasswordMail($valCode, $mail);
                $data["error"] = 0;
                $data["error_message"] = "Email enviado correctamente";
                $this->load->view('forgot_layout', $data);
                return;
            }
            $data["error"] = 1;
            $data["error_message"] = "Email no encontrado";
            $this->load->view('forgot_layout', $data);
            return;
        }
        show_404();
    }

    public function forgotPassword() {
        $this->load->view('forgot_layout');
    }

    public function validateNewPassword() {
        $this->load->model('user_model');
        $this->form_validation->set_rules('forgot_token', 'forgot_token', 'required');
        $this->form_validation->set_rules('password', 'password', 'trim|required|matches[passconf]|min_length[5]|max_length[12]');
        $this->form_validation->set_rules('passconf', 'password Confirmation', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $newPassword = do_hash($this->input->post('password'), 'md5');
            $code = $this->input->post('forgot_token');
            if ($this->user_model->changePasswordByCode($code, $newPassword)) {
                $data["error"] = 0;
                $data["token"] = 'No-token';
                $data["error_message"] = "Contraseña cambiada con exito, ya puedes iniciar sesión.";
                $this->load->view('change_password_forgot_layout', $data);
                return;
            } else {
                $data["error"] = 1;
                $data["token"] = 'No-token';
                $data["error_message"] = "No existe el token.";
                $this->load->view('change_password_forgot_layout', $data);
                return;
            }
        } else {
            $data["error"] = 1;
            $data["token"] = 'No-token';
            $data["error_message"] = "Posible falta de datos.";
            $this->load->view('change_password_forgot_layout', $data);
            return;
        }
        show_404();
    }

    public function changeForgottenPassword($token) {
        if (isset($token) && $token !== "") {
            $data["token"] = $token;
            $this->load->view('change_password_forgot_layout', $data);
            return;
        }show_404();
    }

    public function validate($code) {
        if ($code !== NULL && $code !== "") {
            $this->load->model('user_model');
            $res = $this->user_model->validate($code);
            if ($res) {
                redirect('/?vd=1', 'refresh');
                return;
            }
            show_404();
            return;
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
        $this->form_validation->set_rules('name', 'name', 'trim|required|min_length[4]|max_length[30]|alpha');
        $this->form_validation->set_rules('nick', 'nick', 'trim|required|min_length[4]|max_length[20]');
        $this->form_validation->set_rules('password', 'password', 'trim|required|min_length[4]|max_length[60]|matches[passwordConf]');
        $this->form_validation->set_rules('passwordConf', 'passwordConf', 'trim|required|min_length[4]|max_length[60]');
        $this->form_validation->set_rules('lastname', 'lastname', 'trim|required|min_length[4]|max_length[30]|alpha');
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

            if ($this->user_model->push($email, $nick, $name, $password, $lastname, $birthday, $gender, $thumbUrl, $valCode)) {
                $to = $email;
                $mailContent = validationMail($name, $valCode, $email);
//NO ES NECESARIO$this->email->sendMail($to, $mailContent->message, $mailContent->subject);
                if ($mailContent) {

                    if ($this->user_model->emailExists($email)) {
                        $data["error"] = 1;
                        $data["error_message"] = "Email en uso.";
                        $this->load->view('register_layout', $data);
                    } else {
                        if ($this->user_model->push($email, $nick, $name, $password, $lastname, $birthday, $gender, $thumbUrl, $valCode)) {
                            $mailContent = validationMail($name, $valCode, $email);
                            if ($mailContent) {
                                $data["error"] = 0;
                                redirect('/?ms=1', 'refresh');
                                return;
                            }

                            $data["error"] = 0;
                            redirect('/', 'refresh');
                            return;
                        }
                        $data["error"] = 1;
                        $data["error_message"] = "Ha ocurrido un error inesperado.";
                        $this->load->view('register_layout', $data);
                    }
                }
            }
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

//Envio de Email al dueño del canal NO ANDA
//Falta el mail
// newFollowMail($userId, $channelId);
            //Envio de Email al dueño del canal NO ANDA
            //Falta el mail
            newFollowMail($userId, $channelId);

            echo json_encode(array('result' => 'true', 'html' => '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>'));
            return;
        } else {
            echo json_encode(array('result' => 'false', 'html' => '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>'));
            return;
        }
    }

    public function unfollowChannelAX() {
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

        if ($this->user_model->unfollowChannel($userId, $channelId)) {
            echo json_encode(array('result' => 'true', 'html' => '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>'));
            return;
        } else {
            echo json_encode(array('result' => 'false', 'html' => '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>'));
            return;
        }
    }

    public function changePassword() {
        if (!$this->isAuthorized()) {
            $data["error"] = 1;
            $data["error_message"] = "Debes estar logueado";
            $this->load->view('login_layout', $data);
            return; //andate de esta funcion  
        }$this->load->model('user_model');
        $this->form_validation->set_rules('oldPassword', 'Old Password', 'trim|required');
        $this->form_validation->set_rules('password', 'password', 'trim|required|matches[passconf]|min_length[5]|max_length[12]');
        $this->form_validation->set_rules('passconf', 'password Confirmation', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data["error"] = 1;
            $data["error_message"] = "Verifique los campos ingresados.";
            $this->load->view('change_password_layout', $data);
        } else {
            $newPassword = do_hash($this->input->post('password'), 'md5');
            $oldPassword = do_hash($this->input->post('oldPassword'), 'md5');
//inserta y redirige a algun lado todavia no sabemos
            if ($this->user_model->changePassword($this->session->userdata('userId'), $newPassword, $oldPassword)) {
//muestra alguna pagina todavia no sabemos cual
//estaria bueno mostrar un mensaje indicando que se csmbio el password correctamente, y mandar el mail 
                redirect('/', 'refresh');
                return;
            }
            $data["error"] = 1;
            $data["error_message"] = "Debes intentar con tu contraseña real.";
            $this->load->view('change_password_layout', $data);
        }
    }

}
