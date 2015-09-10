<?php

defined('BASEPATH') && defined('APPPATH') OR exit('No direct script access allowed');


include APPPATH . 'classes/CommentDTO.php';
include APPPATH . 'classes/CommentListDTO.php';

class Comments_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table = "comment";
    }

    public function push($idVideo, $idUser, $comment, $date) {
        //puede llevar modificaciones si tiene un padre
        $data["idUser"] = $idUser;
        $data["idVideo"] = $idVideo;
        $data["comment"] = $comment;
        $data["date"] = $date;
        $result = $this->save($data);
        if ($result > 0) {
            $id = $this->db->insert_id();
            return $id;
        }
        return false;
    }

    public function selectById($idComment) {
        $conditions["comment.id"] = $idComment;
        $this->db->select("comment.id, comment.idVideo, comment.comment, comment.date,"
                . " comment.idUser, nick, thumbUrl");
        $this->db->join("user", "user.id = comment.idUser ");
        $row = $this->search($conditions);
        if (count($row) === 1) {
            $row = $row[0];
            $comment = new CommentDTO();
            $comment->id = $row->id;
            $comment->idVideo = $row->idVideo;
            $comment->comment = $row->comment;
            $comment->date = $row->date;
            $comment->idUser = $row->idUser;
            $comment->usernick = $row->nick;
            $comment->userthumb = $row->thumbUrl;
            return $comment;
        }
        return false;
    }

    public function selectByVideo($idVideo, $limit, $offset) {
        $conditions["idVideo"] = $idVideo;
        $this->db->select("comment.id, comment.idVideo, comment.comment, comment.date,"
                . " comment.active, comment.idUser, nick, thumbUrl");
        $this->db->join("user", "user.id = comment.idUser ");
        $this->db->limit($limit, $offset);
        $this->db->order_by("date", "desc");
        $this->db->where($conditions);
        //$result = $this->search($conditions);



        $result = $this->db->get($this->table)->result();
        // echo $this->db->last_query();
        if (count($result) > 0) {
            $commentList = new CommentListDTO();
            foreach ($result as $row) {
                $comment = new CommentDTO();
                $comment->id = $row->id;
                $comment->idVideo = $row->idVideo;
                $comment->comment = $row->comment;
                $comment->date = $row->date;
                $comment->active = $row->active;
                $comment->idUser = $row->idUser;
                $comment->usernick = $row->nick;
                $comment->userthumb = $row->thumbUrl;
                $commentList->addComment($comment);
            }
            return $commentList;
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
                $commentList->addComment($comment);
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
                $commentList->addComment($comment);
            }
            return $commentList;
        }
        return FALSE;
    }

    public function remove($idComment) {
        //puede llevar modificaciones si el comentario tiene un padre y es una respusta
        $conditions["id"] = $idComment;
        return $this->delete($conditions);
    }

    public function deleteComment($idComment) {
        $conditions["id"] = $idComment;
        $data["active"] = 0;
        $result = $this->update($data, $conditions);
        return ($result > 0) ? true : false;
    }
    
    public function undeleteComment($idComment) {
        $conditions["id"] = $idComment;
        $data["active"] = 1;
        $result = $this->update($data, $conditions);
        return ($result > 0) ? true : false;
    }

    public function edit($comment, $idComment) {
        $conditions["id"] = $idComment;
        if (isset($comment)) {
            $data["comment"] = $comment;
            $result = $this->update($data, $conditions);
            return ($result > 0) ? true : false;
        } else {
            return false;
        }
    }

}
