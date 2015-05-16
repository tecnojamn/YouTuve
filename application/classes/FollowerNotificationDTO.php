<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FollowerNotificationDTO
 *
 * @author Nicolás
 */
class FollowerNotificationDTO {

    public $idUser;
    public $idChannel;
    public $confirmed;
    public $date;
    public $seen;
    public $userDTO;

    function __construct() {
        
    }

}
