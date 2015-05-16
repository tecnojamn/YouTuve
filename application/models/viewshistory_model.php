<?php

class ViewsHistory_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table = "viewhistory";
    }

    public function push($idUser, $idVideo, $date) {
        $data["idUser"] = $idUser;
        $data["idVideo"] = $idVideo;
        $data["date"] = $date;
        return $this->insert($data);
    }
     public function remove($idUser, $idVideo) {
        $cond["idUser"] = $idUser;
        $cond["idVideo"] = $idVideo;
        return $this->delete($cond);
    }
    public function selectByIdUser($idUser,$limit,$offset) {
        $cond["idUser"] = $idUser;
        return $this->search($cond,$this->table,$limit,$offset);
    }
    //returns true si el user vio el video
    public function userWatchedVideo($idUser, $idVideo, $date = "") {
        $cond["idUser"] = $idUser;
        $cond["idVideo"] = $idVideo;
        if ($date !== "")
            $cond["date"] = $date;
        return $this->search($cond);
    }
    

}
