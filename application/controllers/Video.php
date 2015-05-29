<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Video extends MY_Controller {

    const ACTIVE_DEFAULT_VALUE = '1';

    function __construct() {
        parent::__construct();
//cargo librerias,helpers necesarios en constructor.
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    /**
     * Muestra el form de subir video
     */
    public function upload() {
        if (!$this->isAuthorized()) {
            $data["error"] = 1;
            $data["error_message"] = "Es necesario tener una cuenta para subir videos.";
            $this->load->view('register_layout', $data);
            return; //andate de esta funcion
        }
        $data["log"] = 1;
        $this->load->model('tags_model');
        $arrTags = $this->tags_model->getAllTags();
        $data["tags"] = json_encode($arrTags);
        $this->load->view('upload_video_layout', $data);
        return; //andate de esta funcion
    }

    /**
     * 
     * Hace la subida de video
     */
    public function doUpload() {
        if (!$this->isAuthorized()) {
            $data["error"] = 1;
            $data["error_message"] = "Es necesario tener una cuenta para subir videos.";
            $this->load->view('register_layout', $data);
            return; //andate de esta funcion
        }



        $data["log"] = 1;
        $this->form_validation->set_rules('name', 'name', 'trim|required');
        $this->form_validation->set_rules('link', 'link', 'trim|required');
        $this->form_validation->set_rules('duration', 'duration', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data["error"] = 1;
            $data["error_message"] = "Asegurese que escribió correctamente.";
            $this->load->model('tags_model');
            $arrTags = $this->tags_model->getAllTags();
            $data["tags"] = json_encode($arrTags);
            $this->load->view('upload_video_layout', $data);
            return;
        } else {
            $name = $this->input->post('name');
            $link = $this->input->post('link');
            $duration = $this->input->post('duration');
            $this->load->model('video_model');
            //vemos si tiene un canal
            $idChannel = $this->getChannel($this->session->userdata('userId'));
            if (!$idChannel) {
                //crear canal
                $this->load->model('channel_model');
                $idChannel = $this->channel_model->push($this->session->userdata('userId'), "El canal de " . $this->session->userdata('nick'), "", "");
            }
            //intentamos insertarlo
            $videoId = $this->video_model->push($idChannel, $name, $link, date('Y-m-d H:i:s'), $duration, 1);
            if ($idChannel !== false && $videoId !== false) {
                //Lo subió
                //subimos las tags
                $tags = $this->input->post('tags');
                $this->load->model('tags_model');
                if ($tags !== NULL) {
                    //faltaria chequear que me lleguen cosas lindas y no feas...
                    $this->tags_model->pushTagsForVideo($videoId, $tags);
                }
                //
                redirect('/', 'refresh');
            }
        }
        $data["error"] = 1;
        $data["error_message"] = "Ha ocurrido un error inesperado.";
        $this->load->view('upload_video_layout', $data);
        return; //andate de esta funcion
    }

    public function index() {
//esta es la pagina se entra si se pone www.mipagina.com/Video 
        $this->load->library('session');
        $data["log"] = 0;
        if ($this->isAuthorized()) {
            $data["log"] = 1;
        }
        $this->load->model("video_model");
        $videos = $this->video_model->getVideos(true);
        $data["videos"] = $videos;
        $this->load->view('home_layout', $data);
    }

    /**
     * Es la pantalla de ver video
     */
    public function view() {
        $data = array();
        if ($this->isAuthorized()) {
            $data["log"] = 1;
        }
        $this->load->model('video_model');
        $this->load->model('user_model');
        $id = $this->uri->segment(3, 0);

        if ($id != FALSE) {
            $video = $this->video_model->selectById($id);
            if ($video != FALSE) {

                if ($video->userthumb === "") {
                    $video->userthumb = base_url() . ALT_PROFILE_PIC;
                } else {
                    $video->userthumb = base_url() . USER_THUMB_IMAGE_UPLOAD . $video->userthumb;
                }
                $userId = $this->session->userdata('userId');
                $data["follower"] = $this->user_model->isfollowingChannel($userId, $video->idChannel);
                $data["video"] = $video;

                $data["userID"] = $userId;
                $data["isMyVideo"] = $video->idUser === $userId ? true : false;
                $this->load->view('video_layout', $data);
                return;
            } else {
                $data["error"] = 1;
                $data["error_message"] = "Pagina no encontrada";
            }
        }
        $data["error"] = 1;
        $data["error_msg"] = "El video solicitado no existe.";
        $this->load->view('home_layout', $data);
    }

    /**
     * Ya se deja paginar ej: /video/search?query=pepe&page=1
     * @return type
     */
    public function search() {
        if ($this->isAuthorized()) {
            $data["log"] = 1;
        }
        $search = $this->input->get("query");
        if ($search == NULL) {
            $this->load->view("home_layout");
            return;
        }
        if ($search === "") {
            $this->load->view("home_layout");
            return;
        }
        $page = ($this->input->get("page") !== NULL) ? $this->input->get("page") : 1;
        $page = ($page > 0) ? $page : 1;
        $this->load->model("video_model");
        //var_dump(SEARCH_VIDEOS_LIMIT);
        $videos = $this->video_model->getVideosByNameLike($search, SEARCH_VIDEOS_LIMIT, ($page - 1) * SEARCH_VIDEOS_LIMIT);
        $data["searched_query"] = $search;
        $data["searched_videos"] = $videos;
        $this->load->view("search_layout", $data);


        return;
    }

    /**
     * Funcion que devuelve un json con mas videos en la busqueda
     * @return type
     */
    public function searchMoreVideosAX() {
        $this->load->model("video_model");
        $searchText = $this->input->post("searchText");
        $searchPage = ($this->input->post("searchPage") !== NULL) ? $this->input->post("searchPage") : 1;
        $searchPage = ($searchPage > 0) ? $searchPage : 1;
        $videos = $this->video_model->getVideosByNameLike($searchText, SEARCH_VIDEOS_LIMIT, ($searchPage - 1) * SEARCH_VIDEOS_LIMIT);
        if ($videos) {
            $data["videos"] = $videos;
            $formString = $this->load->view('axviews/ax_load_more_videos', $data, true);
            $arr = array('result' => 'true', 'html' => $formString);
            echo json_encode($arr, JSON_HEX_QUOT | JSON_HEX_TAG);
            return;
        }
        echo json_encode(array('result' => 'false', 'html' => ''));
        return;
    }
}
