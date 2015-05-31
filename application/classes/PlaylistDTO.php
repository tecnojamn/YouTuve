<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PlaylistDTO
 * Es el DTO de playlist
 * @author Nicolás
 */

class PlaylistDTO {

    public $id;
    public $name;
    public $idUser;
    public $videos;
    public $created_date;
    public $isWatchLater;

    function __construct() {
        
    }

      function addVideo($videoDto) {
//array_push no funciona sobre array vacios        
        if ($this->list==null) {
            $this->list[0] = $videoDto;
        } else
            array_push($this->list, $videoDto);
    }

    function removeVideo($index) {
        array_splice($this->list, $index, 1);
    }
}
