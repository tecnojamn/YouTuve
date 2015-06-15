<?php

include_once APPPATH . 'classes/VideoDTO.php';
include_once APPPATH . 'classes/VideoListDto.php';
include_once APPPATH . 'classes/PlaylistDTO.php';
include_once APPPATH . 'classes/PlaylistListDTO.php';

class Playlist_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table = "playlist";
    }

    public function push($idUser, $name, $isWatchLater) {
        $data["name"] = $name;
        $data["idUser"] = $idUser;
        $data["isWatchLater"] = $isWatchLater;
        $result = $this->save($data);
        return ($result > 0) ? true : false;
    }

    public function remove($idPlaylist) {
        $cond["id"] = $idPlaylist;
        $result = $this->delete($cond);
        return ($result > 0) ? true : false;
    }

    public function edit($id, $name, $isWatchLater) {
        if ($name !== "")
            $data["name"] = $name;
        if ($isWatchLater !== "")
            $data["isWatchLater"] = $isWatchLater;
        $result = $this->update($data, "id=" . $id);
        return ($result > 0) ? true : false;
    }

    public function selectById($idPlaylist) {
        $this->db->select("idVideo, playlist.isWatchLater,playlist.created_date, idChannel, video.name, link, date, durationInSeconds, active, playlist.name as pname");
        $this->db->join("video", "video.id = videoplaylist.idVideo");
        $this->db->join("playlist", "playlist.id = videoplaylist.idPlaylist");
        $conditions["playlist.id"] = $idPlaylist;

        $result = $this->search($conditions, "videoplaylist");
        if ($result) {
            $PlayList = new PlaylistDTO();
            $videoList = new VideoListDto();
            foreach ($result as $row) {
                $video = new VideoDTO();
                $video->id = $row->idVideo;
                $video->idChannel = $row->idChannel;
                $video->name = $row->name;
                $video->link = $row->link;
                $video->date = $row->date;
                $video->duration = $row->durationInSeconds;
                $video->active = $row->active;
                $videoList->addVideo($video);
            }

            $PlayList->videos = $videoList;
            $PlayList->created_date = $result[0]->created_date;
            $PlayList->id = $idPlaylist;
            $PlayList->isWatchLater = $result[0]->isWatchLater;
            $PlayList->name = $result[0]->pname;
            return $PlayList;
        }
        return false;
    }

    public function selectByName($name) {
        $condition["Name"] = $name;
        $result = $this->search($condition);
        if (count($result) > 0) {
            $PlayList = new PlaylistDTO();
            $PlayList->isWatchLater = $result[0]->isWatchLater;
            $PlayList->id = $result[0]->id;
            $PlayList->name = $name;

            $this->db->select("video.id, idChannel, video.name, link, date, durationInSeconds, active");
            $this->db->join("video", "video.id = videoplaylist.idVideo");
            $this->db->join("playlist", "playlist.id = videoplaylist.idPlaylist");
            $conditions["playlist.id"] = $PlayList->id;
            $result = $this->search($conditions, "videoplaylist");
            if (count($result) > 0) {
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
                    $videoList->addVideo($video);
                }
                $PlayList->videos = $videoList;
            }
            return $PlayList;
        }
        return FALSE;
    }

    public function addVideoToPlaylist($idPlaylist, $idVideo) {
        $data["idPlaylist"] = $idPlaylist;
        $data["idVideo"] = $idVideo;
        $result = $this->insert($data, "videoplaylist");
        return ($result > 0) ? true : false;
    }

    public function removeVideoFromPlaylist($idVideo, $idPlaylist) {
        $cond["idVideo"] = $idVideo;
        $cond["idPlaylist"] = $idPlaylist;
        $result = $this->delete($cond, "videoplaylist");
        return ($result > 0) ? true : false;
    }

    /**
     * 
     * @param type $idUser
     * @param type $limit
     * @param type $offset
     * @param type $videoData si esta en true carga los videos de cada playlist
     * @return \PlaylistListDTO
     */
    public function selectPlaylistsByUser($idUser, $limit, $offset, $videoData = false) {
        $cond["idUser"] = $idUser;
        $this->db->select("id, name, isWatchLater, created_date");
        $this->db->limit($limit, $offset);
        $result = $this->search($cond);
        $PlaylistList = new PlaylistListDTO();
        if ($result) {
            foreach ($result as $row) {
                $Playlist = new PlaylistDTO;
                $Playlist->id = $row->id;
                $Playlist->name = $row->name;
                $Playlist->isWatchLater = $row->isWatchLater;
                $Playlist->created_date = $row->created_date;
                if ($videoData) {
                    $resultV = $this->selectById($Playlist->id);
                    $Playlist->videos = $resultV->videos;
                }
                $PlaylistList->addPlayList($Playlist);
            }
            return $PlaylistList;
        }
        return FALSE;
    }

    //chequea si existe el video en la playlist
    public function checkIfExist($videoId, $playlistName) {
        $condition['video.id'] = $videoId;
        $condition['playlist.name'] = $videoId;
        $this->db->join("videoplaylist", "playlist.id = videoplaylist.idPlaylist");
        $this->db->join("video", "video.id = videoplaylist.idVideo");
        $result = $this->search($condition);
        if (count($result) > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
