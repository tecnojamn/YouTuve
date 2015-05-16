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
class FollowerNotificationListDTO {

    public $list; //array

    function __construct() {
        
    }

    function addFollowerNotification($FollowerNotificationDTO) {
        array_push($list, $FollowerNotificationDTO);
    }

    function removeFollowerNotification($index) {
        array_splice($this->list, $index, 1);
    }

}
