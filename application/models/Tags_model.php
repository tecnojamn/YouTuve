<?php

defined('BASEPATH') && defined('APPPATH') OR exit('No direct script access allowed');

include_once APPPATH . 'classes/TagListDTO.php';
include_once APPPATH . 'classes/TagDTO.php';

class Tags_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table = "tag";
    }

    public function push($name) {
        $data["name"] = $name;
        return $this->save($data);
    }

    /**
     * Anda NO tocar
     * @param type $tagsArr
     * @param type $idVideo
     * @return type
     */
    public function pushTagsForVideo($idVideo, $tagsArr) {
        $tagData = array();
        $i = 0;
        foreach ($tagsArr as $tag) {
            $tagData[$i] = array(
                'idVideo' => $idVideo,
                'idTag' => $tag
            );
            $i++;
        }
        return $this->db->insert_batch('videotag', $tagData);
    }

    public function addTag($tagName) {
        $conditions["name"] = $tagName;
        $result = $this->search($conditions, "tag");
        if ($result == null) {
            $data["name"] = $tagName;
            $this->db->insert("tag", $data);
            return true;
        } else {
            return false;
        }
    }

    public function removeTag($tagName) {
        $conditions["name"] = $tagName;
        $result = $this->search($conditions, "tag");
        if ($result != null) {
            $data["name"] = $tagName;
            $this->db->delete("tag", $data);
            return true;
        } else {
            return false;
        }
    }

    public function getTagsFromVideo($idVideo) {
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

    public function getAllTags() {
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
