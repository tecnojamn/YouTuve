<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Channel
 *
 * @author maxi
 */
class Channel extends MY_Controller {

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

    public function view() {
        if ($this->isAuthorized()) {
            $data["log"] = 1;
        }
        $this->load->model('channel_model');
        $id = $this->uri->segment(3, 0);
        if ($id !== null) {
            if($id=="me"){
                $id = $this->session->userdata("userId");
            }
            $channel_info = $this->channel_model->selectByIdChannel($id);
            if ($channel_info) {
                $data["channel"] = $channel_info;
                $this->load->view('channel_layout', $data);
                return;
            }
        }
        show_404();
        return;
    }

    public function getFromUserAX() {
        if (!$this->isAuthorized()) {
            $arr = array('result' => 'false', 'html' => 'silence is gold');
            echo json_encode($arr, JSON_HEX_QUOT | JSON_HEX_TAG);
            return;
        }
        $this->load->model('channel_model');
        $userId = $this->session->userdata('userId');
        $page = ($this->input->get("page") !== NULL) ? $this->input->get("page") : 1;
        $page = ($page > 0) ? $page : 1;

        $channels = $this->channel_model->selectChannelsByUser($userId, PLAYLIST_PROFILE_LIMIT, ($page - 1) * PLAYLIST_PROFILE_LIMIT);
        if ($channels) {

//por ahora mostramos esto
            foreach ($channels->list as $ch) {
                if ($ch->frontImgUrl === "") {
                    $ch->frontImgUrl = base_url() . ALT_CHANNEL_BACKGROUND_PIC;
                }
            }
            $data["channels"] = $channels;
//$data["playlist_image"] = base_url() . ALT_PLAYLIST_PIC;
            $view = $this->load->view('axviews/ax_load_channels', $data, true);
            $arr = array('result' => 'true', 'html' => $view);
            echo json_encode($arr, JSON_HEX_QUOT | JSON_HEX_TAG);
            return;
        }

        $arr = array('result' => 'false', 'html' => '');
        echo json_encode($arr, JSON_HEX_QUOT | JSON_HEX_TAG);
        return;
    }

<<<<<<< HEAD
    public function searchMoreChannelAX() {
        $this->load->model("video_model");
        $searchText = $this->input->post("searchText");
        $searchPage = ($this->input->post("searchPage") !== NULL) ? $this->input->post("searchPage") : 1;
        $searchPage = ($searchPage > 0) ? $searchPage : 1;
        $videos = $this->video_model->getVideosByNameLike($searchText, SEARCH_VIDEOS_LIMIT, ($searchPage - 1) * SEARCH_VIDEOS_LIMIT);
        if ($videos) {
=======
//no funca aun
    public function searchMoreChannelAX() {
        $this->load->model("channel_model");
        $searchText = $this->input->post("searchText");
        $searchPage = ($this->input->post("searchPage") !== NULL) ? $this->input->post("searchPage") : 1;
        $searchPage = ($searchPage > 0) ? $searchPage : 1;
        $channels = $this->channel_model->getChannelByNameLike($searchText, SEARCH_CHANNEL_LIMIT, ($searchPage - 1) * SEARCH_CHANNEL_LIMIT);
        if ($channels) {
>>>>>>> origin/julito-branch
            foreach ($channels->list as $ch) {
                if ($ch->frontImgUrl === "") {
                    $ch->frontImgUrl = base_url() . ALT_CHANNEL_BACKGROUND_PIC;
                }
            }
<<<<<<< HEAD
            $data["videos"] = $videos;
            $formString = $this->load->view('axviews/ax_load_more_videos', $data, true);
=======
            $data["chanels"] = $channels;
            $formString = $this->load->view('axviews/ax_load_more_channels', $data, true);
>>>>>>> origin/julito-branch
            $arr = array('result' => 'true', 'html' => $formString);
            echo json_encode($arr, JSON_HEX_QUOT | JSON_HEX_TAG);
            return;
        }
        echo json_encode(array('result' => 'false', 'html' => ''));
        return;
    }

}
