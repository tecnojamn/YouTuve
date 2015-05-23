<?php

defined('BASEPATH') && defined('APPPATH') OR exit('No direct script access allowed');

include APPPATH . 'classes/VideoDTO.php';
include APPPATH . 'classes/VideoListDto.php';
include APPPATH . 'classes/TagListDTO.php';
include APPPATH . 'classes/TagDTO.php';

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
        $conditions["active"] = 1;
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
        $result = $this->search($conditionsChannel, "channel", 1, 0);
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
//Para evitar dividir entre 0 cuando no hay rates
        $video->rate = ($count == 0) ? 0 : $video->rate = $totalRate / $count;
        $this->db->flush_cache();

        $conditionsTag["idVideo"] = $idVideo;
        $this->db->join("videotag", "videotag.idtag = tag.id");
        $result = $this->search($conditionsTag, "tag");
        $tagList = new TagListDTO;
        foreach ($result as $row) {
            $tag = new TagDTO;
            $tag->name = $row->name;
            $tag->id = $row->id;
            $tagList->addTag($tag);
        }
        $video->tags = $tagList;
        return $video;
    }

    public function selectByIdChannel($idChannel, $limit = 1, $offset = 0) {
        $conditions["idChannel"] = $idChannel;
        $this->db->select("video.id, idChannel, video.name, link, date, durationInSeconds, "
                . "active, idUser, nick, thumbUrl");
        $this->db->join("channel", "channel.id = video.idChannel");
        $this->db->join("user", "channel.idUser = user.id");

        $result = $this->search($conditions, "video");
        $videoList = new VideoListDto();
        foreach ($result as $row) {
            $video = new VideoDTO();
            $video->id = $row->id;
            $video->idChannel = $row->idChannel;
            $video->name = $row->name;
            $video->link = $row->link;
            $video->date = $row->date;
            $video->duration = $row->durationInSeconds;
            $video->active = $row->active;
            $video->idUser = $row->idUser;
            $video->usernick = $row->nick;
            $video->userthumb = $row->thumbUrl;
//rates del video
            $this->db->flush_cache();
            $conditionsRate["idVideo"] = $video->id;
            $this->db->select("rate");
            $result = $this->search($conditionsRate, "rate");
            $totalRate = 0;
            $count = 0;
            foreach ($result as $row) {
                $totalRate += $row->rate;
                $count++;
            }
//Para evitar dividir entre 0 cuando no hay rates
            if ($count == 0) {
                $video->rate = 0;
            } else {
                $video->rate = $totalRate / $count;
            }
            $this->db->flush_cache();
//view del video
            $conditionsView["idVideo"] = $video->id;
            $this->db->where($conditionsView);
            $video->views = $this->db->count_all_results("viewhistory");
//tags del video            
            $this->db->flush_cache();
            $conditionsTag["idVideo"] = $video->id;
            $this->db->join("videotag", "videotag.idtag = tag.id");
            $result = $this->search($conditionsTag, "tag");
            $tagList = new TagListDTO();
            foreach ($result as $row) {
                $tag = new TagDTO();
                $tag->name = $row->name;
                $tag->id = $row->id;
                $tagList->addTag($tag);
            }
            $video->tags = $tagList;
            $videoList->addVideo($video);
        }
        return $videoList;
    }

    public function activate($idVideo) {
        $data["active"] = 1;
        return $this->update($data, "id=" . $idVideo);
    }

    private function deactivate($idVideo) {
        $data["active"] = 0;
        return $this->update($data, "id=" . $idVideo);
    }

    public function searchVideo($search, $limit, $offset) {
        $this->db->where("active", "1");
        $this->db->like("name", $search);
        $this->db->limit($offset, $limit);
        $result = $this->db->get($this->table)->result();
        // var_dump($this->db->last_query());
        return $result;
    }

    //si orderByRate = true :ordena por rate
    //si orderByRate = false :ordena por fecha
    //channel debe ser array
    public function getVideos($orderByRate = false, $channel = false, $limit = 1, $offset = 0) {
        if ($channel) {
            $this->db->where("channel.name", $channel);
        }
        //selecciona videos con sus respectivo rate ( avg(rate) de la tabla rate )
        if ($orderByRate) {
            $this->db->select("idVideo");
            $this->db->select_avg("rate");
            $this->db->from("rate");
            $this->db->group_by("idVideo");
            $subquery = $this->db->get_compiled_select();
            $subquery = "(" . $subquery . ") as rate";

            $this->db->flush_cache();
            $this->db->select("video.*, rate.rate, channel.id as idChan, channel.frontImgUrl as imgChan");
            $this->db->from($subquery);
            $this->db->where("video.active", "1");
            $this->db->join($this->table, "rate.idVideo=video.id");
            $this->db->join("channel", "video.idChannel=channel.id");
            if ($limit != 0) {
                $this->db->limit($limit, $offset);
            }
            $this->db->order_by("rate", "desc");
            $result = $this->db->get()->result();
            $videos = new VideoListDto();
            foreach ($result as $row) {
                $video = new VideoDTO();
                $video->id = $row->id;
                $video->name = $row->name;
                $video->link = $row->link;
                $video->idChannel = $row->idChan;
                $video->rate = $row->rate;
                $video->duration = $row->durationInSeconds;
                $videos->addVideo($video);
            }
            return $videos;
        }
    }

}
