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
                    $this->tags_model->pushTagsForVideo($videoId,$tags);
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
        $id = $this->uri->segment(3, 0);

        if ($id != FALSE) {
            $video = $this->video_model->selectById($id);
            if ($video != FALSE) {
                $data["video"] = $video;
                $this->load->view('video_layout', $data);
                return;
            } else {
                $data["error"] = 1;
                $data["error_message"] = "Pagina no encontrada";
            }
        }
//HARDCODED PAGE
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
        $videos = $this->video_model->searchVideo($search, SEARCH_VIDEOS_LIMIT, $page - 1);
        $data["searched_query"] = $search;
        $data["searched_videos"] = $videos;
        $this->load->view("search_layout", $data);


        return;
    }

//si orderBy = 1 :ordena por fecha
//si orderBy = 0 :ordena por rate
//channel debe ser array
//    private function getVideos($orderBy, $channel=false, $limit=0) {
//        
//    }
}
