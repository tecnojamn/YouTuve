<?php

class User_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table = "user";
    }

    public function push($email, $name, $password, $lastname, $birthday, $gender, $thumbUrl = "") {
        $data["email"] = $email;
        $data["name"] = $name;
        $data["password"] = $password;
        $data["lastname"] = $lastname;
        $data["birthday"] = $birthday;
        $data["gender"] = $gender;
        if ($thumbUrl !== "") {
            $data["thumbUrl"] = $thumbUrl;
        }
        return $this->save($data);
    }

    public function edit($id, $email, $name, $password, $lastname, $birthday, $gender, $thumbUrl) {
        if ($thumbUrl !== "")
            $data["email"] = $email;
        if ($thumbUrl !== "")
            $data["name"] = $name;
        if ($thumbUrl !== "")
            $data["password"] = $password;
        if ($thumbUrl !== "")
            $data["lastname"] = $lastname;
        if ($thumbUrl !== "")
            $data["birthday"] = $birthday;
        if ($thumbUrl !== "")
            $data["gender"] = $gender;
        if ($thumbUrl !== "") {
            $data["thumbUrl"] = $thumbUrl;
        }
        return $this->update($data, "id=" . $id);
    }

    public function getById($id){
        $condition["id"]=$id;
        $this->search($condition);
        //return
    }
    public function authorize($email,$password){
        $condition["email"]=$email;
        $condition["password"]=$password;
        $this->search($condition,"user",1,0);
        //return
    }

}
