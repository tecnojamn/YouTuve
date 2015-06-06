<?php
include APPPATH . 'classes/ChannelDTO.php';
include APPPATH . 'classes/VideoDTO.php';
include APPPATH . 'classes/UserDTO.php';

class Channel_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table = "channel";
    }

    /**
     * Ya anda NO tocar(devuelve el id insertado)
     * @param type $idUser
     * @param type $name
     * @param type $description
     * @param type $frontImgUrl
     * @return type
     */
    public function push($idUser, $name, $description, $frontImgUrl) {
        $data["idUser"] = $idUser;
        $data["name"] = $name;
        $data["description"] = $description;
        $data["frontImgUrl"] = $frontImgUrl;
        $result = $this->insert($data);
        return ($result) ? $this->db->insert_id() : $result;
//return ($result > 0) ? true : false;
    }

    public function edit($id, $name, $description, $frontImgUrl) {
        $data["name"] = $name;
        $data["description"] = $description;
        $data["frontImageUrl"] = $frontImgUrl;
        return $this->update($data, "id=" . $id);
    }

    public function selectById($id) {
        $conditions["id"] = $id;
        $result = $this->search($conditions);
        if (count($result) > 0) {
            $channel = new ChannelDTO;
            $channel->idUser = $result[0]->idUser;
            $channel->description = $result[0]->description;
            $channel->name = $result[0]->name;
            $channel->id = $id;
            $channel->frontImgUrl = $result[0]->frontImgUrl;
            return $channel;
        } else {
            return false;
        }
    }

    /**
     * (se usa, NO tocar)
     * Devuelve info básica del canal por el id de Usuario ! 
     */
    public function selectByIdUser($idUser) {
        $conditions["idUser"] = $idUser;
        $res = $this->search($conditions, $this->table, 1, 0);
        
        if (count($res) > 0) {
            $data = new ChannelDTO;
            $data->idUser = $idUser;
            $data->description = $res[0]->description;
            $data->name = $res[0]->name;
            $data->id = $res[0]->id;
            $data->frontImgUrl = $res[0]->frontImgUrl;
            return $data;
        } else {
            return false;
        }
    }

    //devuelve true si pertenece a usuario
    public function belongsToUser($idChannel, $idUser) {
        $conditions["idUser"] = $idUser;
        $conditions["id"] = $idChannel;
        $this->search($conditions, $this->table, 1, 0);
        //return
    }

    //devuelve true se pudo suscribir
    public function suscribeUser($idChannel, $idUser) {
        $data["idUser"] = $idUser;
        $data["id"] = $idChannel;
        $this->insert($data, "suggestion");
        //return
    }

    //devuelve true se pudo desuscribir
    public function unsuscribeUser($idChannel, $idUser) {
        $data["idUser"] = $idUser;
        $data["id"] = $idChannel;
        $this->delete($data, "suggestion");
        //return
    }
    //Devuelve todos los seguidores de un canal
    public function getFollower($idChannel){
        $condition["idChannel"] = $idChannel;
        $this->db->join("user", "user.id=follower.idUser");
        $res = $this->search($condition, "follower");
        $count = 0;
        if($res==NULL){
            return FALSE;
        }
        foreach ($res as $row) {
            $user = new UserDTO();
            $user->id = $row->id;
            $user->name = $row->name;
            $user->nick = $row->nick;
            $user->email = $row->email;
            $user->gender = $row->gender;
            $user->lastname = $row->lastname;
            $user->birthday = $row->birthday;
            $userList[$count] = $user;
            $count++;
        }
        return $userList;
    }

}
