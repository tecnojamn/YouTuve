<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PlaylistListDTO
 *
 * @author Nicolás
 */
class PlaylistListDTO {

    public $list; //array

    function __construct() {
        
    }

    function addPlayList($playListDTO) {
        if ($this->list == null) {
            $this->list[0] = $playListDTO;
        } else {
            array_push($this->list, $playListDTO);
        }
    }

    function removePlayList($index) {
        array_splice($this->list, $index, 1);
    }

}
