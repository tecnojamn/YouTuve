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
            $arr = array('result' => 'false', 'html' => 'Error');
            echo json_encode($arr, JSON_HEX_QUOT | JSON_HEX_TAG);
            return;
        }
        $userId = $this->session->userdata('userId');
        $this->load->model('playlist_model');
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
<<<<<<< HEAD
            $view = $this->load->view('axviews/ax_message',$data, TRUE);
=======
            $view = $this->load->view('axviews/ax_message', $data, TRUE);
>>>>>>> origin/julito-branch
            $arr = array('result' => 'false', 'html' => $view);
            echo json_encode($arr, JSON_HEX_QUOT | JSON_HEX_TAG);
            return;
        }
<<<<<<< HEAD
        if( $this->playlist_model->checkIfExist($vidId, $plname) ){
            $data["type"] = "error";
            $data["messageText"] = "El video ya existe en playlist";
            $view = $this->load->view('axviews/ax_message',$data, TRUE);
            $arr = array('result' => 'false', 'html' => $view);
=======
        if ($this->playlist_model->checkIfExist($vidId, $plname)) {
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
>>>>>>> origin/julito-branch
            echo json_encode($arr, JSON_HEX_QUOT | JSON_HEX_TAG);
            return;
        } else {
            
        }
        $ins = $this->playlist_model->addVideoToPlaylist($playlist->id, $vidId);
        if ($ins) {
            $data["type"] = "message";
            $data["messageText"] = "Se ha agregado correctamente";
            $view = $this->load->view('axviews/ax_message',$data, TRUE);
            $arr = array('result' => 'true', 'html' => $view);
            echo json_encode($arr, JSON_HEX_QUOT | JSON_HEX_TAG);
            return;
        } else {
            
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

}
