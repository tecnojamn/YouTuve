<?php

class Sugguests_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table = "suggestion";
    }

    public function push($idSender, $idReciever, $idVideo, $date, $seen = 0) {
        $data["idUser"] = $idSender;
        $data["idUserToSuggest"] = $idReciever;
        $data["idVideo"] = $idVideo;
        $data["date"] = $date;
        $data["seen"] = $seen;
        return $this->save($data);
    }

    public function selectByIdReciever($id, $seen, $limit, $offset) {
        $conditions["idUserToSuggest"] = $id;
        $conditions["seen"] = $seen;
        $this->search($conditions, $this->tableName, $limit, $offset);
        //return data
    }

    //setea que la sugerencia fue vista
    public function setAsSeen($idSender, $idReciever, $idVideo) {
        $cond["idUser"] = $idSender;
        $cond["idUserToSuggest"] = $idReciever;
        $cond["idVideo"] = $idVideo;
        $data["seen"] = 1;
        return $this->update($data, $cond);
    }

    //setea que todas las sugerencia no vistas fueron vista
    public function setAllAsSeen($idReciever) {
        $cond["idUserToSuggest"] = $idReciever;
        $cod["seen"] = 0;
        $data["seen"] = 1;
        return $this->update($data, $cond);
    }

}
