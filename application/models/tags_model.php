<?php
defined('BASEPATH') && defined('APPPATH') OR exit('No direct script access allowed');

include APPPATH . 'classes/TagListDTO.php';
include APPPATH . 'classes/TagDTO.php';
class Tags_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table = "tag";
    }

    public function push($name) {
        $data["name"] = $name;
        return $this->save($data);
    }
    
    public function addTag($tagName) {
        $conditions["name"] = $tagName;
        $result = $this->search($conditions, "tag");
        if($result==null){
            $data["name"]=$tagName;
            $this->db->insert("tag", $data);
            return true;
        }else{
            return false;
        }
    }
    public function removeTag($tagName) {
        $conditions["name"] = $tagName;
        $result = $this->search($conditions, "tag");
        if($result!=null){
            $data["name"]=$tagName;
            $this->db->delete("tag", $data);
            return true;
        }else{
            return false;
        }
    }
    public function getTagFromVideo($idVideo) {
        $conditions["idVideo"] = $idVideo;
        $this->db->join("tag", "idTag = id");
        $result = $this->search($conditions, "videoTag");
        $tagList = new TagListDTO();
        foreach ($result as $row) {
            $tag = new TagDTO();
            $tag->id = $row->id;
            $tag->name = $row->name;
            $tagList->addTag($tag);
        }
        return $tagList;
    }
    public function getAllTag() {
        $result = $this->db->get("tag");
        $tagList = new TagListDTO();
        foreach ($result->result() as $row) {
            $tag = new TagDTO();
            $tag->id = $row->id;
            $tag->name = $row->name;
            $tagList->addTag($tag);
        }
        return $tagList;
    }
}
