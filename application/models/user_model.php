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
        $data["birthday"] = $birthday;
        $data["gender"] = $gender;
        $data["thumbUrl"] = $thumbUrl;
        $result = $this->save($data);
        return ($result > 0) ? true : false;
    }

    public function edit($id, $email, $nick, $name, $password, $lastname, $birthday, $gender, $thumbUrl) {
        if ($nick !== "")
            $data["nick"] = $nick;
        if ($email !== "")
            $data["email"] = $email;
        if ($name !== "")
            $data["name"] = $name;
        if ($password !== "")
            $data["password"] = $password;
        if ($lastname !== "")
            $data["lastname"] = $lastname;
        if ($birthday !== "")
            $data["birthday"] = $birthday;
        if ($gender !== "")
            $data["gender"] = $gender;
        if ($thumbUrl !== "") {
            $data["thumbUrl"] = $thumbUrl;
        }
        return $this->update($data, "id=" . $id);
    }

    public function selectById($id) {
        $condition["id"] = $id;
        $this->search($condition);
        //return
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

}
