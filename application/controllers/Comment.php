<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Comment
 *
 * @author maxi
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Comment extends MY_Controller {

    //put your code here

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    public function index() {
        show_404(false);
    }

    /**
     * Funcion que devuelve un json con resultado de si se guardo o no el comment
     * @return type
     */
    public function saveCommentAX() {
        $this->load->model("comments_model");
        $commentText = $this->input->post("commentText");
        $idVideo = $this->input->post("vidId");
        if ($idVideo === "" || $idVideo === null || $commentText === null || $commentText === "" || count($commentText) > 150 || !$this->isAuthorized()) {
            echo json_encode(array('result' => 'false', 'html' => 'Error al intentar comentar el video.'));
            return;
        }
        $date = date('Y-m-d H:i:s');
        $userid = $this->session->userdata('userId');
        $commentId = $this->comments_model->push($idVideo, $userid, $commentText, $date);
        if ($commentId) {
            $comment = $this->comments_model->selectById($commentId);
            if ($comment->userthumb === "") {
                $comment->userthumb = base_url() . ALT_PROFILE_PIC;
            } else {
                $comment->userthumb = base_url() . USER_THUMB_IMAGE_UPLOAD . $comment->userthumb;
            }
            $data["comment"] = $comment;
            $formString = $this->load->view('axviews/ax_video_comment', $data, true);
            $arr = array('result' => 'true', 'html' => $formString);
            echo json_encode($arr, JSON_HEX_QUOT | JSON_HEX_TAG);
            return;
        }
        echo json_encode(array('result' => 'false', 'html' => 'Error al intentar comentar el video.'));
        return;
    }

    /**
     * Funcion que devuelve un json con comentarios de un video
     * @return type
     */
    public function getCommentsAX() {
        $this->load->model("comments_model");
        $idVideo = $this->input->post("vidId");
        if ($idVideo === "" || $idVideo === null) {
            echo json_encode(array('result' => 'false', 'html' => 'Video is null'));
            return;
        }
        $page = ($this->input->post("page") !== NULL) ? $this->input->post("page") : 1;
        $page = ($page > 0) ? $page : 1;
        $comments = $this->comments_model->selectByVideo($idVideo, COMMENTS_LIMIT, ($page - 1) * COMMENTS_LIMIT);
        if ($comments) {
            foreach ($comments->list as $c) {
                if ($c->userthumb === "") {
                    $c->userthumb = base_url() . ALT_PROFILE_PIC;
                } else {
                    $c->userthumb = base_url() . USER_THUMB_IMAGE_UPLOAD . $c->userthumb;
                }
            }
            $data["comments"] = $comments;
            $formString = $this->load->view('axviews/ax_video_comments', $data, true);
            $arr = array('result' => 'true', 'html' => $formString);
            echo json_encode($arr, JSON_HEX_QUOT | JSON_HEX_TAG);
            return;
        }
        echo json_encode(array('result' => 'false', 'html' => 'DB Error'));
        return;
    }

}
