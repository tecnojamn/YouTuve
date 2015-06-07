<?php

defined('BASEPATH') && defined('APPPATH') OR exit('No direct script access allowed');

include_once APPPATH . 'classes/VideoDTO.php';
include_once APPPATH . 'classes/VideoListDto.php';
include_once APPPATH . 'classes/TagListDTO.php';
include_once APPPATH . 'classes/TagDTO.php';
include_once APPPATH . 'classes/ChannelDTO.php';
include_once APPPATH . 'classes/ChannelListDTO.php';

class Channel_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table = "channel";
    }

    /**
     * Ya anda NO tocar(devuelve el id insertado)
     * @param type $idUser
     * @param type $name
     * @param type $description
     * @param type $frontImgUrl
     * @return type
     */
    public function push($idUser, $name, $description, $frontImgUrl) {
        $data["idUser"] = $idUser;
        $data["name"] = $name;
        $data["description"] = $description;
        $data["frontImgUrl"] = $frontImgUrl;
        $result = $this->insert($data);
        return ($result) ? $this->db->insert_id() : $result;
//return ($result > 0) ? true : false;
    }

    public function edit($id, $name, $description, $frontImgUrl) {
        $data["name"] = $name;
        $data["description"] = $description;
        $data["frontImageUrl"] = $frontImgUrl;
        return $this->update($data, "id=" . $id);
    }

    public function selectById($id) {
        $conditions["id"] = $id;
<<<<<<< HEAD
        $this->search($conditions, $this->table, 1, 0);
        //return data
=======
        $result = $this->search($conditions);
        if (count($result) > 0) {
            $channel = new ChannelDTO;
            $channel->idUser = $result[0]->idUser;
            $channel->description = $result[0]->description;
            $channel->name = $result[0]->name;
            $channel->id = $id;
            $channel->frontImgUrl = $result[0]->frontImgUrl;
            return $channel;
        } else {
            return false;
        }
>>>>>>> origin/mail-branch
    }

    /**
     * (se usa, NO tocar)
     * Devuelve info básica del canal por el id de Usuario ! 
     */
    public function selectByIdUser($idUser) {
        $conditions["idUser"] = $idUser;
        $res = $this->search($conditions, $this->table, 1, 0);
        if (count($res) > 0) {
            $data = new ChannelDTO();
            $data->idUser = $res[0]->idUser;
            $data->description = $res[0]->description;
            $data->name = $res[0]->name;
            $data->id = $res[0]->id;
            $data->frontImgUrl = $res[0]->frontImgUrl;
            return $data;
        } else {
            return false;
        }
    }

    //devuelve true si pertenece a usuario
    public function belongsToUser($idChannel, $idUser) {
        $conditions["idUser"] = $idUser;
        $conditions["id"] = $idChannel;
        $this->search($conditions, $this->table, 1, 0);
        //return
    }

    //devuelve true se pudo suscribir
    public function suscribeUser($idChannel, $idUser) {
        $data["idUser"] = $idUser;
        $data["id"] = $idChannel;
        $this->insert($data, "suggestion");
        //return
    }

    //devuelve true se pudo desuscribir
    public function unsuscribeUser($idChannel, $idUser) {
        $data["idUser"] = $idUser;
        $data["id"] = $idChannel;
        $this->delete($data, "suggestion");
        //return
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
        $channel = new ChannelDTO();
        $channel = $this->selectByIdUser($videoList->list[0]->idUser);
        $channel->username = $videoList->list[0]->usernick;
        $channel->videos = $videoList;
        return $channel;
    }

    public function selectChannelsByUser($idUser, $limit, $offset, $videoData = false) {
            $cond["follower.idUser"] = $idUser;
            $this->db->select("channel.id as id, channel.name as name, channel.description as description, channel.frontImgUrl as frontImgUrl, user.nick as nick"); 
            $this->db->join("channel", "follower.IdChannel = channel.id");
            $this->db->join("user","follower.idUser = user.id");
            $this->db->limit($limit, $offset);
            $result = $this->search($cond, "follower");
            $channelList = new ChannelListDTO();
            
            foreach ($result as $row) {
                $channel = new ChannelDTO();
                $channel->id = $row->id;
                $channel->name = $row->name;
                $channel->description = $row->description;
                $channel->frontImgUrl = $row->frontImgUrl;
                $channel->username = $row->nick;
                if ($videoData) {
                    $resultV = $this->selectByIdChannel($channel->id);
                    $channel->videos = $resultV->videos;
                }
                $channelList->addChannel($channel);
            }
            return $channelList;
        }
    }
    
