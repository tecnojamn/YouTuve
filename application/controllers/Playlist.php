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
            $arr = array('result' => 'false', 'html' => 'silence is gold');
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
            //por ahora mostramos esto
            $data["playlist_image"] = base_url() . ALT_PLAYLIST_PIC;
            $view = $this->load->view('axviews/ax_load_playlists', $data, true);
            $arr = array('result' => 'true', 'html' => $view);
            echo json_encode($arr, JSON_HEX_QUOT | JSON_HEX_TAG);
            return;
        }

        $arr = array('result' => 'false', 'html' => '');
        echo json_encode($arr, JSON_HEX_QUOT | JSON_HEX_TAG);
        return;
    }

}
