<?php

/**
 * La idea es pedirle formularios via ajax
 *
 * @author nicolacio
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Playlist extends MY_Controller {

    //put your code here

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
    }

    public function index() {
        show_404();
        return;
    }

    //devuelve una playlist y sus videos de acuerdo a un id, se accede por playlist/get/[ID_PLAYLIST]
    public function get() {
        if ($this->isAuthorized())
            $data["log"] = 1;
        $this->load->model('playlist_model');
        $id = $this->uri->segment(3, 0);
        if ($id !== null) {
            $playlist = $this->playlist_model->selectById($id);
            if ($playlist) {
                $data["playlist_image"] = base_url() . ALT_PLAYLIST_PIC;
                $data["playlist"] = $playlist;
                $this->load->view('playlist_layout', $data);
                return;
            }
        }
        show_404();
        return;
    }

    public function getVideosAx() {
        if ($this->isAuthorized()) {
            $idUser = $this->session->userdata('userId');

            $idPlaylist = $this->input->post("idPlaylist");
            $this->load->model('playlist_model');

            if ($this->playlist_model->checkUserOwner($idUser, $idPlaylist)) {
                $playlist = $this->playlist_model->selectById($idPlaylist);

                $data["playlist"] = $playlist;
                $view = $this->load->view('axviews/ax_videos_playlist', $data, true);
                $arr = array('result' => 'true', 'html' => $view);
                echo json_encode($arr, JSON_HEX_QUOT | JSON_HEX_TAG);
                return;
            }
        }
        return;
    }

    /**
     * 
     * params : 
     * pag - page to be loaded
     * @return jSon - returns playlist in jSon format
     */
    public function getFromUserAX() {
        if (!$this->isAuthorized()) {
            $arr = array('result' => 'false', 'html' => 'No hay playlists');
            echo json_encode($arr, JSON_HEX_QUOT | JSON_HEX_TAG);
            return;
        }
        $this->load->model('playlist_model');
        $userId = $this->session->userdata('userId');
        $page = ($this->input->get("page") !== NULL) ? $this->input->get("page") : 1;
        $page = ($page > 0) ? $page : 1;

        $playlists = $this->playlist_model->selectPlaylistsByUser($userId, PLAYLIST_PROFILE_LIMIT, ($page - 1) * PLAYLIST_PROFILE_LIMIT);
        if ($playlists) {
            $data["playlists"] = $playlists;
            $data["playlist_image"] = base_url() . ALT_PLAYLIST_PIC;
            $view = $this->load->view('axviews/ax_load_playlists', $data, true);
            //por ahora mostramos esto
            $arr = array('result' => 'true', 'html' => $view);
            echo json_encode($arr, JSON_HEX_QUOT | JSON_HEX_TAG);
            return;
        }

        $arr = array('result' => 'false', 'html' => '');
        echo json_encode($arr, JSON_HEX_QUOT | JSON_HEX_TAG);
        return;
    }

    public function addAx() {
        if (!$this->isAuthorized()) {
            $arr = array('result' => 'false', 'html' => '');
            echo json_encode($arr, JSON_HEX_QUOT | JSON_HEX_TAG);
            return;
        }
        $name = $this->input->get("pl_name");
        if ($name === null || $name === "") {
            $data["type"] = "error";
            $data["messageText"] = "Falta de datos";
            $view = $this->load->view('axviews/ax_message', $data, TRUE);
            $arr = array('result' => 'false', 'html' => $view);
            echo json_encode($arr, JSON_HEX_QUOT | JSON_HEX_TAG);
            return;
        }
        $this->load->model('playlist_model');
        $userId = $this->session->userdata('userId');
        if ($this->playlist_model->checkIfNameExists($userId, $name)) {
            $data["type"] = "error";
            $data["messageText"] = "Playlist ya existe";
            $view = $this->load->view('axviews/ax_message', $data, TRUE);
            $arr = array('result' => 'false', 'html' => $view);
            echo json_encode($arr, JSON_HEX_QUOT | JSON_HEX_TAG);
            return;
        }
        $ins = $this->playlist_model->push($userId, $name, false);
        if ($ins) {
            $arr = array('result' => 'true', 'html' => '');
            echo json_encode($arr, JSON_HEX_QUOT | JSON_HEX_TAG);
            return;
        } else {
            $arr = array('result' => 'false', 'html' => '');
            echo json_encode($arr, JSON_HEX_QUOT | JSON_HEX_TAG);
            return;
        }
    }

    public function addVideoAx() {
        if (!$this->isAuthorized()) {
            $arr = array('result' => 'false', 'html' => 'No hay playlists');
            echo json_encode($arr, JSON_HEX_QUOT | JSON_HEX_TAG);
            return;
        }
        $vidId = $this->input->get("vid");
        $plname = $this->input->get("plname");
        if ($vidId === null || $plname === null) {
            $arr = array('result' => 'false', 'html' => 'Error');
            echo json_encode($arr, JSON_HEX_QUOT | JSON_HEX_TAG);
            return;
        }
        $this->load->model('playlist_model');
        $playlist = $this->playlist_model->selectByName($plname);
        if ($playlist == FALSE) {
            $data["type"] = "error";
            $data["messageText"] = "Playlist no existe";
            $view = $this->load->view('axviews/ax_message', $data, TRUE);
            $arr = array('result' => 'false', 'html' => $view);
            echo json_encode($arr, JSON_HEX_QUOT | JSON_HEX_TAG);
            return;
        }
        $playlistAux = $this->playlist_model->selectByName($plname);
        if ($this->playlist_model->checkIfExist($vidId, $playlistAux->id)) {
            $data["type"] = "error";
            $data["messageText"] = "El video ya existe en playlist";
            $view = $this->load->view('axviews/ax_message', $data, TRUE);
            $arr = array('result' => 'false', 'html' => $view);
            echo json_encode($arr, JSON_HEX_QUOT | JSON_HEX_TAG);
            return;
        }

        $ins = $this->playlist_model->addVideoToPlaylist($playlist->id, $vidId);
        if ($ins) {
            $data["type"] = "message";
            $data["messageText"] = "Se ha agregado correctamente";
            $view = $this->load->view('axviews/ax_message', $data, TRUE);
            $arr = array('result' => 'true', 'html' => $view);
            echo json_encode($arr, JSON_HEX_QUOT | JSON_HEX_TAG);
            return;
        } else {
            $data["type"] = "error";
            $data["messageText"] = "Imposible agregar a playlist";
            $view = $this->load->view('axviews/ax_message', $data, TRUE);
            $arr = array('result' => 'false', 'html' => $view);
            echo json_encode($arr, JSON_HEX_QUOT | JSON_HEX_TAG);
            return;
        }
    }

    public function getFromUserMinAX() {
        if (!$this->isAuthorized()) {
            $arr = array('result' => 'false', 'html' => 'No hay playlists');
            echo json_encode($arr, JSON_HEX_QUOT | JSON_HEX_TAG);
            return;
        }
        $this->load->model('playlist_model');
        $userId = $this->session->userdata('userId');
        $page = ($this->input->get("page") !== NULL) ? $this->input->get("page") : 1;
        $page = ($page > 0) ? $page : 1;
        $playlists = $this->playlist_model->selectPlaylistsByUser($userId, PLAYLIST_PROFILE_LIMIT, ($page - 1) * PLAYLIST_PROFILE_LIMIT);
        if ($playlists) {
            $data["playlists"] = $playlists;
            $view = $this->load->view('axviews/ax_load_playlists_addlist', $data, true);
            $arr = array('result' => 'true', 'html' => $view);
            echo json_encode($arr, JSON_HEX_QUOT | JSON_HEX_TAG);
            return;
        }
        $arr = array('result' => 'false', 'html' => ' ');
        echo json_encode($arr, JSON_HEX_QUOT | JSON_HEX_TAG);
        return;
    }

    public function delVideoAx() {
        if ($this->isAuthorized()) {
            $idUser = $this->session->userdata('userId');
        } else {
            header("Location: " . BASEPATH);
            return;
        }
        $this->load->model('playlist_model');
        $idPlaylist = $this->input->post('idPlaylist');
        $idVideo = $this->input->post('idVideo');
        //chequeo si existe video en playlist sino "seteo" error
        if ($this->playlist_model->checkIfExist($idVideo, $idPlaylist)) {
            //chequeo si ha sido borrado exitosamente y "seteo" el mensaje o error correspondiente
            if ($this->playlist_model->removeVideoFromPlaylist($idVideo, $idPlaylist)) {
                $data["type"] = 'message';
                $data["messageText"] = 'El video ha sido eliminado con exito';
            } else {
                $data["type"] = 'error';
                $data["messageText"] = 'El video no ha podido ser eliminado';
            }
        } else {
            $data["type"] = 'warning';
            $data["messageText"] = 'El video no pertenece a esta playlist';
        }

        $view = $this->load->view('axviews/ax_message', $data, true);
        $arr = array('result' => 'true', 'html' => $view);
        echo json_encode($arr, JSON_HEX_QUOT | JSON_HEX_TAG);
        return;
    }

    public function delPlaylistAx() {
        if ($this->isAuthorized()) {
            $idUser = $this->session->userdata('userId');
        } else {
            header("Location: " . BASEPATH);
            return;
        }
        $idPlaylist = $this->input->post('idPlaylist');
        $this->load->model('playlist_model');
        if ($this->playlist_model->checkUserOwner($idUser, $idPlaylist)) {
            if ($this->playlist_model->remove($idPlaylist)) {
                $data["type"] = 'message';
                $data["messageText"] = 'La playlist ha sido eliminada con exito';
            } else {
                $data["type"] = 'error';
                $data["messageText"] = 'La playlist no ha podido ser eliminada ' . $idPlaylist . 'algo';
            }
        } else {
            $data["type"] = 'warning';
            $data["messageText"] = 'La playlist no existe';
        }

        $view = $this->load->view('axviews/ax_message', $data, true);
        $arr = array('result' => 'true', 'html' => $view);
        echo json_encode($arr, JSON_HEX_QUOT | JSON_HEX_TAG);
        return;
    }

}
