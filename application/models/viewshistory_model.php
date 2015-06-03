<?php

include_once APPPATH . 'classes/ViewHistoryDTO.php';
include_once APPPATH . 'classes/ViewHistoryListDTO.php';

class ViewsHistory_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table = "viewhistory";
    }

    public function push($idUser, $idVideo, $date) {
        $data["idUser"] = $idUser;
        $data["idVideo"] = $idVideo;
        $data["date"] = $date;
        $result = $this->insert($data);
        return ($result > 0) ? true : false;
    }

    public function remove($idUser, $idVideo) {
        $cond["idUser"] = $idUser;
        $cond["idVideo"] = $idVideo;
        return $this->delete($cond);
    }

    public function selectByIdUser($idUser, $limit, $offset) {
        $cond["idUser"] = $idUser;
        return $this->search($cond, $this->table, $limit, $offset);
    }

    //returns true si el user vio el video
    public function userWatchedVideo($idUser, $idVideo, $date = "") {
        $cond["idUser"] = $idUser;
        $cond["idVideo"] = $idVideo;
        if ($date !== "")
            $cond["date"] = $date;
        return $this->search($cond);
    }

    public function selectWatchedVideosByUser($idUser, $limit = 500, $offset = 0) {
        $cond["viewhistory.idUser"] = $idUser;
        $this->db->select("video.*,channel.id as idChannel,channel.name as channelName, channel.idUser,"
                . "video.name as videoName, viewhistory.date as vhdate, user.nick, user.thumbUrl ");
        $this->db->join("video", "video.id = viewhistory.idVideo");
        $this->db->join("channel", "channel.id = video.idChannel");
        $this->db->join("user", "user.id = channel.idUser ");
        $result = $this->search($cond);
        $ViewHistoryList = new ViewHistoryListDTO();
        foreach ($result as $row) {
            $viewHistory = new ViewHistoryDTO();
            $viewHistory->dateView = $row->vhdate;
            //info del video
            $viewHistory->idVideo = $row->id;
            $viewHistory->videoName = $row->videoName;
            $viewHistory->link = $row->link;
            $viewHistory->videoDate = $row->date;
            $viewHistory->idChannel = $row->idChannel;
            $viewHistory->channelName = $row->channelName;
            $viewHistory->duration = $row->durationInSeconds;
            $viewHistory->Videoactive = $row->active;
            $viewHistory->idUser = $row->idUser;
            $viewHistory->usernick = $row->nick;
            $viewHistory->userthumb = $row->thumbUrl;
            //view del video
            $conditionsView["idVideo"] = $viewHistory->idVideo;
            $this->db->where($conditionsView);
            $viewHistory->videoViews = $this->db->count_all_results("viewhistory");

            $this->db->flush_cache();
            //ALTERNATIVA 2
            $conditionsRate["idVideo"] = $viewHistory->idVideo;
            $this->db->select("rate");
            $result = $this->search($conditionsRate, "rate");
            $totalRate = 0;
            $count = 0;
            foreach ($result as $rowRate) {
                $totalRate += $rowRate->rate;
                $count++;
            }
            //Para evitar dividir entre 0 cuando no hay rates
            $viewHistory->videoRate = ($count == 0) ? 0 : $viewHistory->videoRate = $totalRate / $count;
            $this->db->flush_cache();
            $ViewHistoryList->addView($viewHistory);
        }
        return $ViewHistoryList;
    }

}
