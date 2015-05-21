<?php

defined('BASEPATH') && defined('APPPATH') OR exit('No direct script access allowed');


include APPPATH . 'classes/CommentDTO.php';
include APPPATH . 'classes/CommentListDTO.php';

class Comments_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table = "comment";
    }

    public function push($idUser, $idVideo, $comment) {
        //puede llevar modificaciones si tiene un padre
        $data["idUser"] = $idUser;
        $data["idVideo"] = $idVideo;
        $data["comment"] = $comment;
        $result = $this->save($data);
        return ($result > 0) ? true : false;
    }

    public function selectByVideo($idVideo) {
        $conditions["idVideo"] = $idVideo;
        $this->db->select("comment.id, comment.idVideo, comment.comment, comment.date,"
                . " comment.idUser, nick, thumbUrl");
        $this->db->join("user", "user.id = comment.idUser ");
        $result = $this->search($conditions);
        if (count($result) > 0) {
            $commentList = new CommentListDTO();
            foreach ($result as $row) {
                $comment = new CommentDTO();
                $comment->id = $row->id;
                $comment->idVideo = $row->idVideo;
                $comment->comment = $row->comment;
                $comment->date = $row->date;
                $comment->idUser = $row->idUser;
                $comment->usernick = $row->nick;
                $comment->userthumb = $row->thumbUrl;
                $commentList . addComment($comment);
            }
            return $commentLlist;
        }
        return FALSE;
    }

    public function selectByUser($idUser) {
        $conditions["idUser"] = $idUser;
        $this->db->select("comment.id, comment.idVideo, comment.comment, comment.date,"
                . " comment.idUser, nick, thumbUrl");
        $this->db->join("user", "user.id = comment.idUser ");
        $this->search($conditions);
        if (count($result) > 0) {
            $commentList = new CommentListDTO();
            foreach ($result as $row) {
                $comment = new CommentDTO();
                $comment->id = $row->id;
                $comment->idVideo = $row->idVideo;
                $comment->comment = $row->comment;
                $comment->date = $row->date;
                $comment->idUser = $row->idUser;
                $comment->usernick = $row->nick;
                $comment->userthumb = $row->thumbUrl;
                $commentList . addComment($comment);
            }
            return $commentLlist;
        }
        return FALSE;
    }

    public function selectByUserAndVideo($idVideo, $idUser) {
        $conditions["idVideo"] = $idVideo;
        $conditions["idUser"] = $idUser;
        $this->db->select("comment.id, comment.idVideo, comment.comment, comment.date,"
                . " comment.idUser, nick, thumbUrl");
        $this->db->join("user", "user.id = comment.idUser ");
        $this->search($conditions);
        if (count($result) > 0) {
            $commentList = new CommentListDTO();
            foreach ($result as $row) {
                $comment = new CommentDTO();
                $comment->id = $row->id;
                $comment->idVideo = $row->idVideo;
                $comment->comment = $row->comment;
                $comment->date = $row->date;
                $comment->idUser = $row->idUser;
                $comment->usernick = $row->nick;
                $comment->userthumb = $row->thumbUrl;
                $commentList . addComment($comment);
            }
            var_dump($commentList);
            return $commentLlist;
        }
        return FALSE;
    }

    public function remove($idComment) {
        //puede llevar modificaciones si el comentario tiene un padre y es una respusta
        $conditions["id"] = $idComment;
        return $this->delete($conditions);
    }

    public function edit($comment, $idComment) {
        $conditions["id"] = $idComment;
        if (isset($comment) != FALSE) {
            $data["comment"] = $comment;
            $result = $this->update($data, $conditions);
            return ($result > 0) ? true : false;
        } else {
            return FALSE;
        }
    }

}
