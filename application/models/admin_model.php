<?php

defined('BASEPATH') && defined('APPPATH') OR exit('No direct script access allowed');
include_once APPPATH . 'classes/AdminDTO.php';

class Admin_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table = "admin";
    }

    public function authorize($email, $password) {
        $condition["username"] = $email;
        $condition["password"] = $password;
        $result = $this->search($condition, "admin", 1, 0);
        if (count($result) === 1) {
            $admin = new AdminDTO();
            $admin->username = $result[0]->username;
            return $admin;
        } else {
            return false;
        }
    }

    public function getVideos($offset, $limit) {
        $Videos = new VideoListDto();
        $this->db->select("id,name,active");
        $this->db->limit($limit, $offset);
        $this->db->order_by("id", "desc");
        $result = $this->search("video");
        if (count($result) < 0) {
            return false;
        } else {
            foreach ($result as $row) {
                $video = new VideoDTO();
                $video->active = $row->active;
                $video->id = $row->id;
                $video->name = $row->name;
                $Videos->addVideo($video);
            }
            return $Videos;
        }
    }

}
