<?php

class Comments_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table = "comment";
    }

    public function push($idUser, $idVideo, $comment) {
        $data["idUser"] = $idUser;
        $data["idVideo"] = $idVideo;
        $data["comment"] = $comment;
        return $this->save($data);
    }

    

    public function getByVideo($idVideo) {
        $conditions["idVideo"] = $idVideo;
        $this->search($conditions, $this->tableName, 1, 0);
        //return data
    }


}
