<?php

class Channel_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table = "channel";
    }

    public function push($idUser, $name, $description, $frontImgUrl) {
        $data["idUser"] = $idUser;
        $data["name"] = $name;
        $data["description"] = $description;
        $data["frontImageUrl"] = $frontImgUrl;
        return $this->save($data);
    }

    public function edit($id, $name, $description, $frontImgUrl) {
        $data["name"] = $name;
        $data["description"] = $description;
        $data["frontImageUrl"] = $frontImgUrl;
        return $this->update($data, "id=" . $id);
    }

    public function getById($id) {
        $conditions["id"] = $id;
        $this->search($conditions, $this->tableName, 1, 0);
        //return data
    }

    public function getByIdUser($idUser) {
        $conditions["idUser"] = $idUser;
        $this->search($conditions, $this->tableName, 1, 0);
        //return data
    }
    //devuelve true si pertenece a usuario
    public function belongsToUser($idChannel,$idUser){
        $conditions["idUser"] = $idUser;
        $conditions["id"] = $idChannel;
        $this->search($conditions, $this->tableName, 1, 0);
        //return
    }
     //devuelve true se pudo suscribir
    public function suscribeUser($idChannel,$idUser){
        $data["idUser"] = $idUser;
        $data["id"] = $idChannel;
        $this->insert($data, "suggestion");
        //return
    }
    //devuelve true se pudo desuscribir
    public function unsuscribeUser($idChannel,$idUser){
        $data["idUser"] = $idUser;
        $data["id"] = $idChannel;
        $this->delete($data, "suggestion");
        //return
    }

}
