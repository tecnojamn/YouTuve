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
            $this->load->model('channel_model');
            $this->load->helper('email_content');


            //Existance validation in YouTube system
            // Create a curl handle
            $ch = curl_init();
            $oembedURL = 'www.youtube.com/oembed?url=' . urlencode("https://www.youtube.com/watch?v=" . $link) . '&format=json';
            curl_setopt($ch, CURLOPT_URL, $oembedURL);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            // Silent CURL execution
            $output = curl_exec($ch);
            unset($output);

            $info = curl_getinfo($ch);
            curl_close($ch);

            if ($info['http_code'] === 404) {
                $data["error"] = 1;
                $data["error_message"] = "El video no existe";
                $this->load->model('tags_model');
                $arrTags = $this->tags_model->getAllTags();
                $data["tags"] = json_encode($arrTags);
                $this->load->view('upload_video_layout', $data);
                return;
            }

            //Existance validation in YouTuve system
            if ($this->video_model->alreadyExist($link)) {
                $data["error"] = 1;
                $data["error_message"] = "El video que intenta subir ya existe";
                $this->load->model('tags_model');
                $arrTags = $this->tags_model->getAllTags();
                $data["tags"] = json_encode($arrTags);
                $this->load->view('upload_video_layout', $data);
                return; //andate de esta funcion
            }

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
//envio mail a los seguidores del canal
                newChannelVideoMail($name, $videoId);

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
        $data["log"] = 0;
        if ($this->isAuthorized()) {
            $data["log"] = 1;
        }
        $this->load->model('video_model');
        $this->load->model('rate_model');
        $this->load->model('user_model');
        $id = $this->uri->segment(3, 0);

        if ($id != FALSE) {
            $video = $this->video_model->selectById($id);
            if ($video != FALSE) {
                $userId = $this->session->userdata('userId');
//agrego al historial de vistas
                if ($this->isAuthorized())
                    $this->video_model->addView($id, $userId, date('Y-m-d H:i:s'));

                if ($video->userthumb === "") {
                    $video->userthumb = base_url() . ALT_PROFILE_PIC;
                } else {
                    $video->userthumb = base_url() . USER_THUMB_IMAGE_UPLOAD . $video->userthumb;
                }

                $data["follower"] = $this->user_model->isfollowingChannel($userId, $video->idChannel);
                $data["video"] = $video;

                $userRate = $this->rate_model->hasRated($id, $userId);
                $data["userRate"] = ($this->isAuthorized() && $userRate) ? $userRate : 0;


                $data["userID"] = $userId;
                $data["isMyVideo"] = $video->idUser === $userId ? true : false;
                $this->load->view('video_layout', $data);
                return;
            } else {
                $data["error"] = 1;
                $data["error_message"] = "El video solicitado no existe o ha sido eliminado";
                $this->load->view('home_layout', $data);
                return;
            }
        }
        show_404();
    }

    /**
     * Ya se deja paginar ej: /video/search?query=pepe&page=1
     * @return type
     */
    public function search() {
        if ($this->isAuthorized()) {
            $data["log"] = 1;
        }else{
            $data["log"] = 0;
        }
        $search = $this->input->get("query");
        if ($search == NULL) {
            $this->load->view("home_layout", $data);
            return;
        }
        if ($search === "") {
            $this->load->view("home_layout", $data);
            return;
        }
        $page = ($this->input->get("page") !== NULL) ? $this->input->get("page") : 1;
        $page = ($page > 0) ? $page : 1;
        $this->load->model("video_model");
        $this->load->model("channel_model");
        $videos = $this->video_model->getVideosByNameLike($search, SEARCH_VIDEOS_LIMIT, ($page - 1) * SEARCH_VIDEOS_LIMIT);

        $channels = $this->channel_model->getChannelByNameLike($search, SEARCH_CHANNEL_LIMIT, ($page - 1) * SEARCH_CHANNEL_LIMIT);


        if ($channels != null) {
            foreach ($channels->list as $ch) {
                if ($ch->frontImgUrl === "") {
                    $ch->frontImgUrl = base_url() . ALT_CHANNEL_BACKGROUND_PIC;
                }
            }
        }
        $data["searched_query"] = $search;
        $data["searched_videos"] = $videos;
        $data["searched_channels"] = $channels;
        $this->load->view("search_layout", $data);


        return;
    }

    public function showList() {
        $this->load->model("video_model");

        $tag = $this->input->get("tag");
        $orderBy = $this->input->get("orderBy");

        if ($orderBy != "rate" && $orderBy != "date") {
            $orderBy = "date";
        }
        if ($this->isAuthorized()) {
            $data['log'] = 1;
        }
        if (isset($tag) && is_numeric($tag) && $tag > 0) {
            //El 0 corresponde al offset
            $videos = $this->video_model->getVideos('rate', SEARCH_VIDEOS_LIMIT, 0, $tag);
        }else{
            //Tag 0 representa que no hay tag
            $tag = 0;
            $videos = $this->video_model->getVideos($orderBy, SEARCH_VIDEOS_LIMIT);
        }
        $data["searched_videos"] = $videos;
        $data["orderby"] = $orderBy;
        $data["tag"] = $tag;
        $this->load->view("video_list_layout", $data);
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

    public function getVideosAx() {
        $this->load->model("video_model");
        $fromChannel = $this->input->post("channelVideos");
        if (isset($fromChannel)) {
            $userId = $this->session->userdata('userId');
            $videos = $this->video_model->getVideosSusChan($userId);
        } else {
            $orderBy = $this->input->post("orderBy");
            $videos = $this->video_model->getVideos($orderBy, 4);
        }
        if ($videos) {
            $data["videos"] = $videos;
            $formString = $this->load->view('axviews/ax_home_videos', $data, true);
            $arr = array('result' => 'true', 'html' => $formString);
            echo json_encode($arr, JSON_HEX_QUOT | JSON_HEX_TAG);
            return;
        }
        echo json_encode(array('result' => 'false', 'html' => '<ul class="col-lg-12" style="list-style: none;padding: 0 40px;">
            <div class="alert alert-dismissible alert-warning">Todavia no sigues a nadie</div>

    </ul>'));
        return;
    }

    public function getMoreVideosAX() {
        $this->load->model("video_model");
        $orderBy = $this->input->post("orderBy");
        $tag = $this->input->post("tag");
        $searchPage = ($this->input->post("searchPage") !== NULL) ? $this->input->post("searchPage") : 1;
        $searchPage = ($searchPage > 0) ? $searchPage : 1;
        if(isset($tag) && $tag!=0 && is_numeric($tag)){
            $videos = $this->video_model->getVideos($orderBy, 0, SEARCH_VIDEOS_LIMIT, ($searchPage - 1) * SEARCH_VIDEOS_LIMIT, $tag);
        }else{
            $videos = $this->video_model->getVideos($orderBy, 0, SEARCH_VIDEOS_LIMIT, ($searchPage - 1) * SEARCH_VIDEOS_LIMIT);
        }
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

    public function rateAx() {
        $this->load->model("rate_model");
        $vidId = $this->input->post("vidId");
        $rte = $this->input->post("rate");
        $userId = $this->session->userdata('userId');
        if ($vidId === NULL || $vidId === "") {
            echo json_encode(array('result' => 'false', 'html' => 'Error: faltan parametros'));
            return;
        }
        $res = $this->rate_model->hasRated($vidId, $userId);
        if ($res) {
            $arr = array('result' => 'false', 'html' => "Ya votaste este video!");
            echo json_encode($arr, JSON_HEX_QUOT | JSON_HEX_TAG);
            return;
        } else {
            $res = $this->rate_model->rate($vidId, $userId, $rte);
            $arr = array('result' => 'true', 'html' => "Video votado correctamente!");
            echo json_encode($arr, JSON_HEX_QUOT | JSON_HEX_TAG);
            return;
        }
        echo json_encode(array('result' => 'false', 'html' => 'Error: Inesperado'));
        return;
    }

    public function remove() {
        $userId = $this->session->userdata('userId');
        $idVideo = $id = $this->uri->segment(3, 0);
        if ($idVideo) {
            $this->load->model("video_model");
            if ($this->video_model->belongsToUser($idVideo, $userId)) {
                if ($this->video_model->remove($idVideo)) {
                    redirect("channel/view/me?msg=success");
                } else {
                    redirect("channel/view/me?msg=error");
                }
            } else {
                echo "que hace?";
            }
        } else {
//404
        }
    }

}
