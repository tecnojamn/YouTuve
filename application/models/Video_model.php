<?php

defined('BASEPATH') && defined('APPPATH') OR exit('No direct script access allowed');

include_once APPPATH . 'classes/VideoDTO.php';
include_once APPPATH . 'classes/VideoListDto.php';
include_once APPPATH . 'classes/TagListDTO.php';
include_once APPPATH . 'classes/TagDTO.php';

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
        return ($result) ? $this->db->insert_id() : $result;
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
        $conditions["video.id"] = $idVideo;
        $conditions["video.active"] = VIDEO_ACTIVE;
        $this->db->select("video.*,channel.id as idChannel,channel.name as channelName,video.name as videoName");
        $this->db->join("channel", "channel.id = video.idChannel");
        $result = $this->search($conditions, $this->table);
        if (sizeof($result) === 1) {
            $video->id = $idVideo;
            $video->name = $result[0]->videoName;
            $video->link = $result[0]->link;
            $video->date = $result[0]->date;
            $video->idChannel = $result[0]->idChannel;
            $video->channelName = $result[0]->channelName;
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
        //view del video
        $conditionsView["idVideo"] = $video->id;
        $this->db->where($conditionsView);
        $video->views = $this->db->count_all_results("viewhistory");

        $this->db->flush_cache();
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
        $conditions["video.active"] = VIDEO_ACTIVE;
        $this->db->select("video.id, idChannel, video.name, link, date, durationInSeconds, "
                . "video.active, idUser, nick, thumbUrl");
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

    public function deactivate($idVideo) {
        $data["active"] = 0;
        return $this->update($data, "id=" . $idVideo);
    }

    public function getVideosByNameLike($query, $limit, $offset) {

        $this->db->select("video.*,channel.id as idChannel,channel.name as channelName,video.name as videoName");
        $this->db->where("video.active", VIDEO_ACTIVE);
        $this->db->like("video.name", $query);
        $this->db->join("channel", "channel.id=video.idChannel");
        $this->db->limit($limit, $offset);
        $result = $this->db->get($this->table)->result();
        if (count($result) < 1) {
            return false;
        }
        $videos = new VideoListDto;
        foreach ($result as $row) {
            $video = new VideoDTO();
            $video->id = $row->id;
            $video->name = $row->videoName;
            $video->link = $row->link;
            $video->date = $row->date;
            $video->idChannel = $row->idChannel;
            $video->channelName = $row->channelName;
            $video->duration = $row->durationInSeconds;

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

            $videos->addVideo($video);
        }
        return $videos;
    }

    public function selectByTagId($idTag) {
        $condition["idTag"] = $idTag;
        $conditions["video.active"] = VIDEO_ACTIVE;
        $this->db->join("videotag", "videotag.idVideo=video.id");
        $result = $this->search($condition);
        $videoList = new VideoListDto();
        foreach ($result as $row) {
            $video = new VideoDTO();
            $video->id = $row->id;
            $video->name = $row->name;
            $video->link = $row->link;
            $video->date = $row->date;
            $video->duration = $row->durationInSeconds;
            $video->active = $row->active;
            $videoList->addVideo($video);
        }
        return $videoList;
    }

    /**
     * 
     * @param type $orderBy
     * @param type $channel
     * @param type $limit
     * @param type $offset
     * @return \VideoListDto
     */
    public function getVideos($orderBy = "date", $channelId = 0, $limit = 0, $offset = 0) {

        //selecciona videos con sus respectivo rate ( avg(rate) de la tabla rate )
        if ($orderBy == "rate") {
            $this->db->select("idVideo");
            $this->db->select_avg("rate");
            $this->db->from("rate");
            $this->db->group_by("idVideo");
            $subquery = $this->db->get_compiled_select();
            $subquery = "(" . $subquery . ") as rate";

            $this->db->select("video.*, rate.rate, channel.id as idChan,channel.id as idChan,channel.name as channelName, channel.frontImgUrl as imgChan");
            $this->db->from($subquery);
            $this->db->join($this->table, "rate.idVideo=video.id");
            $this->db->order_by("rate", "desc");
        } else {
            $this->db->select("video.*, channel.id as idChan,channel.name as channelName,channel.frontImgUrl as imgChan");
            $this->db->from($this->table);
            $this->db->order_by("date", "desc");
        }
        if ($limit != 0) {
            $this->db->limit($limit, $offset);
        }

        if ($channelId !== 0) {
            $this->db->where("channel.id", $channelId);
        }

        $this->db->where("video.active", VIDEO_ACTIVE);
        $this->db->join("channel", "video.idChannel=channel.id");

        $result = $this->db->get()->result();

        $videos = new VideoListDto();
        foreach ($result as $row) {
            $video = new VideoDTO();
            $video->id = $row->id;
            $video->name = $row->name;
            $video->link = $row->link;
            $video->channelName = $row->channelName;
            $video->date = $row->date;

            $video->idChannel = $row->idChan;
            if ($orderBy == "rate") {
                $video->rate = $row->rate;
            }
            $video->duration = $row->durationInSeconds;

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
            $videos->addVideo($video);
        }
        return $videos;
    }

    /**
     * Devuelve solo videos de canales que siga el usuario
     * @param type $idUser
     */
    public function getVideosSusChan($idUser) {
        $this->db->select("video.*, channel.id as chanId, channel.name as chanName");
        $this->db->where("follower.idUser", $idUser);
        $this->db->where("video.active", VIDEO_ACTIVE);
        $this->db->join("channel", "channel.id=video.idChannel");
        $this->db->join("follower", "follower.idChannel=channel.id");
        $this->db->order_by("date", "desc");
        $result = $this->search();
        if ($result) {
            $videoList = new VideoListDto();
            foreach ($result as $row) {
                $video = new VideoDTO();
                $video->id = $row->id;
                $video->name = $row->name;
                $video->link = $row->link;
                $video->date = $row->date;
                $video->idChannel = $row->chanId;
                $video->channelName = $row->chanName;
                $video->duration = $row->durationInSeconds;
                $videoList->addVideo($video);
            }
            return $videoList;
        }
        return FALSE;
    }

    /**
     * agrega una vista al historial de vistas de video
     * Solo va a insertar si pasaron mas de x minutos de la ultima vista
     */
    public function addView($idVideo, $idUser, $date) {
        //consigo la ultima vista si existe de este video con x minutos de offset
        $currentDate = strtotime(date("Y-m-d H:i:s"));
        $offsetDate = $currentDate - (60 * VIDEO_VIEWS_OFFSET_MINUTES);
        $formatDate = date("Y-m-d H:i:s", $offsetDate);
        $this->db->select('count(*) as count');
        $this->db->from('viewhistory')->where('date >=', $formatDate)->where('idVideo', $idVideo)->where('idUser', $idUser);
        $result = $this->db->get()->result();
        if ($result && $result[0]->count == 0) {
            $this->db->flush_cache();
            $data["idVideo"] = $idVideo;
            $data["idUser"] = $idUser;
            $data["date"] = $date;
            return $this->save($data, "viewhistory");
        }
        return false;
    }

    /**
     * Devuelve (int) el total de vistas de un video dado
     */
    public function getTotalViewsForVideo($idVideo) {
        $cond["idVideo"] = $idVideo;
        $this->db->where($data);
        return $this->db->count_all_results('viewtable');
    }

    /**
     * Devuelve true si el video pertenece al usuario
     */
    public function belongsToUser($idVideo, $idUser) {
        $this->db->where('video.id', $idVideo);
        $this->db->where('channel.idUser', $idUser);
        $this->db->join("channel", "channel.id=video.idChannel");
        $result = $this->search();
        return count($result) == 1 ? true : false;
    }

    /**
     * Devuelve true si el video ya existe
     */
    public function alreadyExist($link) {
        $this->db->where('video.link', $link);
        $this->db->where('video.active', VIDEO_ACTIVE);
        $res = $this->search();
        return count($res) == 1 ? true : false;
    }

    /* filters: 
     * * time=>{today, this week, this month, this year}
     * * rate/views =>{most viewed , most rated}
     * * platform =>{youtuve, vimeo}
     * * tagged as=>{Pelicula, Serie, whatever}
     */

    public function findAdvanced($query, $filters, $limit, $offset) {

        $this->db->select("video.*,channel.id as idChannel,channel.name as channelName,video.name as videoName");
        $this->db->where("video.active", VIDEO_ACTIVE);
        $this->db->like("video.name", $query);
        $this->db->join("channel", "channel.id=video.idChannel");
        if (in_array("today", $filters)) {
            $this->db->where("video.date >=", date('Y-m-d'));
        } else if (in_array("this_week", $filters)) {
            $day = date('w');
            $week_end = date('Y-m-d', strtotime('+' . (6 - $day) . ' days'));
            $this->db->where("video.date >=", $week_end);
        } else if (in_array("this_month", $filters)) {
            $current_month = date('m');
            $this->db->where("video.date >=", date('Y-' . $current_month . '-01'));
        } else if (in_array("this_year", $filters)) {
            $current_year = date('Y');
            $this->db->where("video.date >=", date($current_year . '-01-01'));
        }
        if (in_array("most_viewed", $filters)) {
            //select changes????
            $this->db->select("video.*,channel.id as idChannel, COUNT(video.id) as views,channel.name as channelName,video.name as videoName");
            $this->db->join("viewhistory", "viewhistory.idVideo=video.id");
            $this->db->group_by('video.id');
            $this->db->order_by('views', 'desc');
        } else if (in_array("most_rated", $filters)) {
            $this->db->select("video.*,channel.id as idChannel, SUM(rate.rate) as rates,channel.name as channelName,video.name as videoName");
            $this->db->join("rate", "rate.idVideo=video.id");
            $this->db->group_by('video.id');
            $this->db->order_by('rates', 'desc');
        }
        if (in_array("youtube", $filters)) {
            $this->db->where("video.source", 'youtube');
        } else if (in_array("vimeo", $filters)) {
            $this->db->where("video.source", 'vimeo');
        }
        if (in_array("movie", $filters)) {
            $this->db->join("videotag", "videotag.idVideo=video.id");
            $this->db->join("tag", "videotag.idTag=tag.id");
            $this->db->where("tag.name", 'Pelicula');
        } else if (in_array("serie", $filters)) {
            $this->db->join("videotag", "videotag.idVideo=video.id");
            $this->db->join("tag", "videotag.idTag=tag.id");
            $this->db->where("tag.name", 'Serie');
        } else if (in_array("other", $filters)) {
            $this->db->join("videotag", "videotag.idVideo=video.id");
            $this->db->join("tag", "videotag.idTag=tag.id");
            $this->db->where("tag.name !=", 'Pelicula')->where("tag.name !=", 'Serie');
        }
        $this->db->limit($limit, $offset);
        $result = $this->db->get($this->table)->result();
        var_dump($this->db->last_query());
        if (count($result) < 1) {
            return false;
        }
        $videos = new VideoListDto;
        foreach ($result as $row) {
            $video = new VideoDTO();
            $video->id = $row->id;
            $video->name = $row->videoName;
            $video->link = $row->link;
            $video->date = $row->date;
            $video->idChannel = $row->idChannel;
            $video->channelName = $row->channelName;
            $video->duration = $row->durationInSeconds;
            $videos->addVideo($video);
        }
        return $videos;
    }

        public function getVideosForAdmin($offset, $limit) {
        $videos = new VideoListDto();
        $this->db->select("id,name,active");
        $this->db->limit($limit, $offset);
        $this->db->order_by("id", "asc");
        $result = $this->db->get("video")->result();
        if (count($result) < 0) {
            return false;
        } else {
            foreach ($result as $row) {
                $video = new VideoDTO();
                $video->active = $row->active;
                $video->id = $row->id;
                $video->name = $row->name;
                $videos->addVideo($video);
            }
            return $videos;
        }
    }
    public function getVideosQuantity(){
        $cont = 0;
        $cont = $this->db->count_all('video');
        return $cont;
    }
}
