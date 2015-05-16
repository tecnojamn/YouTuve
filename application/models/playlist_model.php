<?php

class Playlist_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table = "playlist";
    }

    public function push($name) {
        $data["name"] = $name;
        return $this->save($data);
    }

    public function remove($idPlaylist) {
        $cond["id"] = $idPlaylist;
        return $this->delete($cond);
    }

    public function edit($id, $name) {
        if ($name !== "")
            $data["name"] = $name;
        return $this->update($data, "id=" . $id);
    }

    public function getById($id) {
        $conditions["id"] = $id;
        $this->search($conditions, $this->tableName, 1, 0);
        //return data
    }

    public function getByName($name, $lmit = 1, $offset = 0) {
        $conditions["name"] = $name;
        $this->search($conditions, $this->tableName, $limit, $offset);
        //return data
    }

    public function addVideo($idPlaylist, $idUser) {
        $data["idPlaylist"] = $idPlaylist;
        $data["idUser"]=$idUser;
        $this->insert($data,"videoplaylist");
    }
    public function removeVideo($idVideo, $idUser) {
        $cond["idVideo"] = $idVideo;
        $cond["idUser"]=$idUser;
        $this->delete($cond,"videoplaylist");
    }

}
