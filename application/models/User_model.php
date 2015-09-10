<?php

defined('BASEPATH') && defined('APPPATH') OR exit('No direct script access allowed');
include_once APPPATH . 'classes/UserDTO.php';

class User_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table = "user";
    }

    public function push($email, $nick, $name, $password, $lastname, $birthday, $gender, $thumbUrl = "", $confirm_token) {
        $data["email"] = $email;
        $data["nick"] = $nick;
        $data["confirm_token"] = $confirm_token;
        $data["name"] = $name;
        $data["password"] = $password;
        $data["lastname"] = $lastname;
        $date = DateTime::createFromFormat('d/m/Y', $birthday);
        $bdaySQL = $date->format('Y-m-d');
        $data["birthday"] = $bdaySQL;
        $data["gender"] = $gender;
        $data["thumbUrl"] = $thumbUrl;
        $result = $this->save($data);
        return ($result > 0) ? true : false;
    }

    public function updateValidationCode($mail, $code) {
        $upd["confirm_token"] = $code;
        $conditions["email"] = $mail;
        $r = $this->update($upd, $conditions);
        return ($r > 0) ? true : false;
    }

    /**
     * muy poco seguro pero safa lindo
     * 
     * @param type $code
     */
    public function validate($code) {
        $upd["active"] = 1;
        $upd["confirm_token"] = "";
        $conditions["confirm_token"] = $code;
        $r = $this->update($upd, $conditions);
        return ($r > 0) ? true : false;
    }

    public function changePasswordByCode($code, $newPass) {
        $upd["active"] = 1;
        $upd["password"] = $newPass;
        $upd["confirm_token"] = "";
        $conditions["confirm_token"] = $code;
        $r = $this->update($upd, $conditions);
        return ($r > 0) ? true : false;
    }

    public function edit($id, $name, $lastname, $birthday, $gender, $thumbUrl) {
        if ($name !== "")
            $data["name"] = $name;
        if ($lastname !== "")
            $data["lastname"] = $lastname;
        if ($birthday !== "") {
            $date = DateTime::createFromFormat('d/m/Y', $birthday);
            $bdaySQL = $date->format('Y-m-d');
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

        $result = $this->search($condition);
        if (count($result > 0)) {
            $user = new UserDTO();
            $user->id = $result[0]->id;
            $user->email = $result[0]->email;
            $user->nick = $result[0]->nick;
            $user->name = $result[0]->name;
            $user->lastname = $result[0]->lastname;
            $user->birthday = $result[0]->birthday;
            $user->gender = $result[0]->gender;
            $user->utlThumb = $result[0]->thumbUrl;
            $user->confirmToken = $result[0]->confirm_token;
            return $user;
        }
        return FALSE;
    }

    public function selectByEmail($email) {
        $condition["email"] = $email;

        $this->search($condition);
        //return

        $result = $this->search($condition);
        if (count($result > 0)) {
            $user = new UserDTO();
            $user->id = $result[0]->id;
            $user->email = $result[0]->email;
            $user->nick = $result[0]->nick;
            $user->name = $result[0]->name;
            $user->lastname = $result[0]->lastname;
            $user->birthday = $result[0]->birthday;
            $user->gender = $result[0]->gender;
            $user->utlThumb = $result[0]->thumbUrl;
            $user->confirmToken = $result[0]->confirm_token;
            return $user;
        }
        return FALSE;
    }

    public function selectByNick($nick) {
        $condition["nick"] = $nick;
        $result = $this->search($condition);
        if (count($result) > 0) {
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
        $result = $this->search($condition);
        if (count($result) > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function authorize($email, $password) {
        $condition["email"] = $email;
        $condition["password"] = $password;
        $condition["active"] = 1;

        $result = $this->search($condition, "user", 1, 0);

        if (count($result) === 1) {
            $user = new UserDTO();
            $user->lastname = $result[0]->lastname;
            $user->name = $result[0]->name;
            $user->gender = $result[0]->gender;
            $user->id = $result[0]->id;
            $user->nick = $result[0]->nick;
            $user->email = $result[0]->email;
            $user->banned_until = $result[0]->banned_until;
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
        $row = $this->db->get_where('follower', array('idChannel' => $data['idChannel'], 'idUser' => $data['idUser']))->row();
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

        $row = $this->db->get_where('follower', array('idChannel' => $data['idChannel'], 'idUser' => $data['idUser']))->row();
        if ($row)
            return false;
        $this->db->flush_cache();
        $result = $this->insert($data, 'follower');
        return ($result > 0) ? true : false;
    }

    public function unfollowChannel($idUser, $idChannel) {
        $this->db->where('idChannel', $idChannel);
        $this->db->where('idUser', $idUser);
        $r = $this->db->delete('follower');
        return $r;
    }

    public function changePassword($idUser, $newPassword, $oldPassword) {
        $this->db->select("password");
        $cond["id"] = $idUser;
        $result = $this->search($cond);
        if (($oldPassword === $result[0]->password) && ($newPassword !== "")) {
            $data["password"] = $newPassword;
            $this->update($data, $cond);
            return ($result > 0) ? true : false;
        }
        return false;
    }

    /*
     * Verifica si esta sin usar el mail
     * return: bool
     */

    public function isEmailAvailable($email) {
        $cond['email'] = $email;
        $res = $this->search($cond, 'user');
        return count($res) == 0 ? true : false;
    }

    public function isNickAvailable($nick) {
        $cond['nick'] = $nick;
        $res = $this->search($cond, 'user');
        return count($res) == 0 ? true : false;
    }

    public function getUsers($limit = 0, $offset = 0, $orderBy = "") {
        if ($limit != 0) {
            $this->db->limit($limit, $offset);
        }
        $users = $this->db->get('user')->result();

        return $users;
    }

    public function deleteUser($id) {
        $data["active"] = 0;
        return $this->update($data, "id=" . $id);
    }

    public function undeleteUser($id) {
        $data["active"] = 1;
        return $this->update($data, "id=" . $id);
    }

    public function ban($id) {
        $this->load->helper('date');
        $user = $this->db->get_where('user', array('id' => $id))->result();
        if (strtotime($user[0]->banned_until) <= strtotime(date('Y-m-d'))) {
            $data["banned_until"] = mdate('%Y-%m-%d',  strtotime("+1 months"));
        } else{
           $data["banned_until"] = date('Y-m-d', strtotime('+1 months',strtotime($user[0]->banned_until)));
        }
        $result['success'] = $this->update($data,"id=" . $id);
        $result["nick"] = $user[0]->nick;
        $result["banned_until"] = $data["banned_until"];
        return $result;
        
    }
    public function unban($id) {
        $this->load->helper('date');
        $user = $this->db->get_where('user', array('id' => $id))->result();
        if (!($user[0]->banned_until == "0000-00-00")) {
            $data["banned_until"] = '0000-00-00';
        } else{
           return $result['success'] = 0; //No tiene ban para eliminar
        }
        $result['success'] = $this->update($data,"id=" . $id);
        $result["nick"] = $user[0]->nick;
        $result["banned_until"] = $data["banned_until"];
        return $result;
        
    }
    
    public function getMailById($idUser){
        $condition["id"] = $idUser;

        $this->search($condition);

        $result = $this->search($condition);
        if (count($result > 0)) {
            return $result[0]->email;
        }
        return FALSE;
    }
    
    public function getUsersQuantity () {
        return count($this->db->get('user')->result());
    }

}
