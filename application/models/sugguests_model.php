<?php

defined('BASEPATH') && defined('APPPATH') OR exit('No direct script access allowed');

include APPPATH . 'classes/SuggestionDTO.php';
include APPPATH . 'classes/SuggestionListDTO.php';

class Sugguests_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table = "suggestion";
    }

    public function push($idSender, $idReciever, $idVideo, $date) {
        $data["idUser"] = $idSender;
        $data["idUserToSuggest"] = $idReciever;
        $data["idVideo"] = $idVideo;
        $data["date"] = $date;
        $data["seen"] = 0;
        return $this->db->insert($this->table, $data);
    }

    public function selectByIdReciever($id, $seen) {
        $conditions["idUserToSuggest"] = $id;
        $conditions["seen"] = $seen;
        $this->db->where($conditions);
        $result = $this->db->get($this->table)->result();
        $suggestList = new SuggestionListDTO();
        foreach ($result as $row) {
            $suggest = new SuggestionDTO();
            $suggest->idSender = $row->idUser;
            $suggest->idVideo = $row->idVideo;
            $suggest->seen = $seen;
            $suggest->idReceiver = $id;
            $suggestList->addSuggestion($suggest);
        }
        return $suggestList;
    }

    //setea que la sugerencia fue vista
    public function setAsSeen($idSender, $idReciever, $idVideo) {
        $cond["idUser"] = $idSender;
        $cond["idUserToSuggest"] = $idReciever;
        $cond["idVideo"] = $idVideo;
        $data["seen"] = 1;
        $this->db->where($cond);
        return $this->db->update($this->table, $data);
    }

    //setea que todas las sugerencia no vistas fueron vista
    public function setAllAsSeen($idReciever) {
        $cond["idUserToSuggest"] = $idReciever;
        $cond["seen"] = 0;
        $this->db->where($cond);
        $data["seen"] = 1;
        return $this->db->update($this->table, $data);
    }

}
