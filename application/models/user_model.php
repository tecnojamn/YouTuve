<?php

defined('BASEPATH') && defined('APPPATH') OR exit('No direct script access allowed');

include APPPATH . 'classes/UserDTO.php';

class User_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table = "user";
    }

    public function push($email, $nick, $name, $password, $lastname, $birthday, $gender, $thumbUrl = "") {
        $data["email"] = $email;
        $data["nick"] = $nick;
        $data["name"] = $name;
        $data["password"] = $password;
        $data["lastname"] = $lastname;
        $bdaySQL = date('Y-m-d H:i:s', strtotime($birthday));
        $data["birthday"] = $bdaySQL;
        $data["gender"] = $gender;
        $data["thumbUrl"] = $thumbUrl;
        $result = $this->save($data);
        return ($result > 0) ? true : false;
    }

    public function edit($id, $name, $lastname, $birthday, $gender, $thumbUrl) {
        if ($name !== "")
            $data["name"] = $name;
        if ($lastname !== "")
            $data["lastname"] = $lastname;
        if ($birthday !== "") {
            $bdaySQL = date('Y-m-d H:i:s', strtotime($birthday));
            $data["birthday"] = $bdaySQL;
        }
        if ($gender !== "")
            $data["gender"] = $gender;
        if ($thumbUrl !== "") {
            $data["thumbUrl"] = $thumbUrl;
        }
        $result = $this->update($data, "id=" . $id);
        return ($result > 0) ? true : false;
    }

    public function selectById($id) {
        $condition["id"] = $id;
        $this->search($condition);
        //return
    }

    public function selectByNick($nick) {
        $condition["nick"] = $nick;
        $result = $this->search($condition);
        if (count($result) === 1) {
            $user = new UserDTO();
            $user->lastname = $result[0]->lastname;
            $user->birthday = $result[0]->birthday;
            $user->name = $result[0]->name;
            $user->gender = $result[0]->gender;
            $user->id = $result[0]->id;
            $user->nick = $result[0]->nick;
            $user->email = $result[0]->email;
            $user->thumbUrl = $result[0]->thumbUrl;
            return $user;
        } else {
            return false;
        }
    }

    public function emailExists($mail) {
        $condition["email"] = $mail;
        return $this->search($condition);
        //return
    }

    public function authorize($email, $password) {
        $condition["email"] = $email;
        $condition["password"] = $password;

        $result = $this->search($condition, "user", 1, 0);

        if (count($result) === 1) {
            $user = new UserDTO();
            $user->lastname = $result[0]->lastname;
            $user->name = $result[0]->name;
            $user->gender = $result[0]->gender;
            $user->id = $result[0]->id;
            $user->nick = $result[0]->nick;
            $user->email = $result[0]->email;
            return $user;
        } else {
            return false;
        }
    }

    /**
     * Devuelve true si sigue a ese canal
     * @param type $idUser
     * @param type $idChannel
     * @return boolean
     */
    public function isfollowingChannel($idUser, $idChannel) {
        $data["idUser"] = $idUser;
        $data["idChannel"] = $idChannel;
        $row = $this->db->get_where('follower', ['idChannel' => $data['idChannel'], 'idUser' => $data['idUser']])->row();
        if ($row)
            return true;
        return false;
    }

    /**
     * Hace que un user siga un canal 
     * @param type $idUser
     * @param type $idChannel
     * @return boolean
     */
    public function followChannel($idUser, $idChannel) {

        $date = date('Y-m-d H:i:s');
        $data["idUser"] = $idUser;
        $data["idChannel"] = $idChannel;
        $data["date"] = $date;
        $data["confirmed"] = 0;
        $data["seen"] = 0;

        $row = $this->db->get_where('follower', ['idChannel' => $data['idChannel'], 'idUser' => $data['idUser']])->row();
        if ($row)
            return false;
        $this->db->flush_cache();
        $result = $this->insert($data, 'follower');
        return ($result > 0) ? true : false;
    }

}
