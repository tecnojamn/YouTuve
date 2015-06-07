
<?php

defined('BASEPATH') && defined('APPPATH') OR exit('No direct script access allowed');
include_once APPPATH . 'classes/RateDTO.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of rate_model
 *
 * @author maxi
 */
class rate_model extends MY_Model {

    //put your code here

    public function __construct() {
        parent::__construct();
        $this->table = "rate";
    }

    public function selectByUserAndVideo($idUser, $idVideo) {
        $rate = new RateDTO();
        $conditions["idUser"] = $idUser;
        $conditions["idVideo"] = $idVideo;
        $result = $this->search($conditions);
        if (sizeof($result) === 1) {
            $rate->idVideo = $result[0]->idVideo;
            $rate->idUser = $result[0]->idUser;
            $rate->rate = $result[0]->rate;
        } else {
            return false;
        }
    }

    public function removeRate($idUser, $idVideo) {
        $conditions["idUser"] = $idUser;
        $conditions["idVideo"] = $idVideo;
        return $this->delete($conditions);
    }

    //calificar video en modelo de video previamente realizado, despues verificar si dejarlo aquí 
    public function rate($idVideo, $idUser, $rating) {

        $data["idVideo"] = $idVideo;
        $data["idUser"] = $idUser;
        $data["rate"] = $rating;

        $result = $this->save($data, "rate");
        return ($result > 0) ? true : false;
    }

    //Devuelve si ya ranqueo el video
    public function hasRated($idVideo, $idUser) {
        $data["idVideo"] = $idVideo;
        $data["idUser"] = $idUser;
        $res = $this->search($data, "rate");

        if ($res) {
            return $res[0]->rate;
        }
        return false;
    }

    //al solicitar un video en el modelo de video, se calcula la calificacion total, por ende no deberia de ir en este modelo, verificar de todos modos
    public function getTotalRate($idVideo) {
        $conditionsRate["idVideo"] = $idVideo;
        $this->db->select("rate");
        $result = $this->search($conditionsRate);
        $totalRate = 0;
        $count = 0;
        foreach ($result as $row) {
            $totalRate += $row->rate;
            $count++;
        }
//Para evitar dividir entre 0 cuando no hay rates
        $video->rate = ($count == 0) ? 0 : $video->rate = $totalRate / $count;
    }

}
