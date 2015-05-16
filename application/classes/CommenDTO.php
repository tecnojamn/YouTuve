<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VideoDTO
 *
 * @author Nicolás
 */
class CommentDTO {

    public $id;
    public $idUser;
    public $idVideo;
    public $comment;
    public $date;

    public $userDTO;//para tener datos del user como la img

    function __construct() {
        
    }

}
