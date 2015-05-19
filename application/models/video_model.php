<?php

defined('BASEPATH') && defined('APPPATH') OR exit('No direct script access allowed');

include APPPATH . 'classes/VideoDTO.php';
include APPPATH . 'classes/TagListDTO.php';

class Video_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table = "video";
    }

    public function push($idChannel, $name, $link, $date, $durationInSec, $active) {
        $data["idChannel"] = $idChannel;
        $data["name"] = $name;
        $data["date"] = $date;
        $data["link"] = $link;
        $data["durationInSeconds"] = $durationInSec;
        $data["active"] = $active;
        $result = $this->save($data);
        return ($result > 0) ? true : false;
    }

    public function remove($idVideo) {
        return $this->deactivate($idVideo);
    }

    public function rate($idVideo, $idUser, $rating) {
        $data["idVideo"] = $idVideo;
        $data["idUser"] = $idUser;
        $data["rate"] = $rating;
        $result = $this->save($data, "rate");
        return ($result > 0) ? true : false;
    }

    public function edit($idVideo, $idChannel, $name, $link, $date, $durationInSec, $active) {
        if ($idChannel !== "" && $name !== "" && $link !== "" && $date !== "" && $durationInSec !== "") {
            $data["idChannel"] = $idChannel;
            $data["name"] = $name;
            $data["link"] = $link;
            $data["date"] = $date;
            $data["durationInSeconds"] = $durationInSec;
            $data["active"] = $active;
            $result = $this->update($data, "id=" . $idVideo);
            return ($result > 0) ? true : false;
        } else {
            return false;
        }
    }

    //return: VideoDTO
    public function selectById($idVideo) {
        $video = new VideoDTO();
        $conditions["id"] = $idVideo;
        $result = $this->search($conditions, $this->table);
        if (sizeof($result) === 1) {
            $video->id = $idVideo;
            $video->idChannel = $result[0]->idChannel;
            $video->name = $result[0]->name;
            $video->link = $result[0]->link;
            $video->date = $result[0]->date;
            $video->duration = $result[0]->durationInSeconds;
            $video->active = $result[0]->active;
        } else {
            //echo "No existe video con id";
            return false;
        }
        $conditionsChannel["id"] = $video->idChannel;
        $result = $this->search($conditionsChannel, "channel");
        if (sizeof($result) === 1) {
            $video->idUser = $result[0]->idUser;
        } else {
            // "No existe channel con ese id" 
            return false;
        }
        $conditionsUser["id"] = $video->idUser;
        $result = $this->search($conditionsUser, "user");
        if (sizeof($result) === 1) {
            $video->usernick = $result[0]->nick;
            $video->userthumb = $result[0]->thumbUrl;
        } else {
            // "No existe user con ese id";
            return false;
        }
        //$conditionsView["idVideo"]=$idVideo;
        //$this->db->where($conditionsView);
        $video->views = $this->db->count_all_results("viewhistory");

        $this->db->flush_cache();


        /* //ALTERNATIVA 1
          $conditionsRate["idVideo"]=$idVideo;
          $this->db->where($conditionsRate);
          $this->db->select("rate");
          $query = $this->db->get("rate");
          var_dump($query->result()[0]->rate); */

        //ALTERNATIVA 2
        $conditionsRate["idVideo"] = $idVideo;
        $this->db->select("rate");
        $result = $this->search($conditionsRate, "rate");
        $totalRate = 0;
        $count = 0;
        foreach ($result as $row) {
            $totalRate += $row->rate;
            $count++;
        }
        $video->rate = $totalRate / $count;
        $this->db->flush_cache();
        
        /*
          Armar un TagListDTO y meterlo en $video->tags
          TagListDTO tiene un array de objetos tipo TagDTO .
         */
        
        var_dump($video);
        return $video;
    }


    public function selectByIdChannel($idChannel, $limit = 1, $offset = 0) {
        $conditions["idChannel"] = $idChannel;
        $this->search($conditions, $this->tableName, $limit, $offset);
//return data
    }

    public function activate($idVideo) {
        $data["active"] = 1;
        return $this->update($data, "id=" . $idVideo);
    }

    private function deactivate($idVideo) {
        $data["active"] = 0;
        return $this->update($data, "id=" . $idVideo);
    }

}
