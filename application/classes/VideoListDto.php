<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VideoListDto
 *
 * @author Nicolás
 */
class VideoListDto {

    public $list; //array

    function __construct() {
        
    }

    function addVideo($tagDto) {
        array_push($list, $tagDto);
    }

    function removeVideo($index) {
        array_splice($this->list, $index, 1);
    }

}
