<?php

class Video_model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    public function push($idUser, $name, $link, $date, $durationInSec, $active) {
        $data["idUser"] = $idUser;
        $data["name"] = $name;
        $data["link"] = $link;
        $data["durationInSeconds"] = $durationInSec;
        $data["active"] = $active;
        return $this->save($data);
    }

    public function remove($idVideo) {
        return $this->deactivate($idVideo);
    }

    public function rate($idVideo, $idUser, $rating) {
        $data["idVideo"] = $idVideo;
        $data["idUser"] = $idUser;
        $data["rating"] = $rating;
        return $this->save($data, "rate");
    }

    public function edit($idVideo, $idUser, $name, $link, $date, $durationInSec, $active) {
        $data["idUser"] = $idUser;
        $data["name"] = $name;
        $data["link"] = $link;
        $data["durationInSeconds"] = $durationInSec;
        $data["active"] = $active;
        return $this->update($data, "id=" . $idVideo);
    }

    public function getById($idVideo) {
        $conditions["id"] = $idVideo;
        $this->search($conditions, $this->tableName, $limit, $offset);
        //return data
    }

    public function getByIdUser($idUser, $lmit = 1, $offset = 0) {
        $conditions["id"] = $idVideo;
        $this->search($conditions, $this->tableName, $limit, $offset);
        //return data
    }

    public function activate($idVideo) {
        $data["active"] = 1;
        return $this->update($data, "id=" . $idVideo);
    }

    public function deactivate($idVideo) {
        $data["active"] = 0;
        return $this->update($data, "id=" . $idVideo);
    }

}
