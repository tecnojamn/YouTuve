<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CommentListDTO
 *
 * @author maxi
 */
class CommentListDTO {

    public $list;

    //put your code here
    function __construct() {
        
    }

    function addComment($commentDto) {
//array_push no funciona sobre array vacios  
        if ($this->list == null) {
            $this->list[0] = $commentDto;
        } else {
            array_push($this->list, $commentDto);
        }
    }

    function removeComment($index) {
        array_splice($this->list, $index, 1);
    }

}
