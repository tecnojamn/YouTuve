<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ChannelListDTO
 *
 * @author maxi
 */
class ChannelListDTO {
    
    public $list; //array

    function __construct() {
        
    }

    function addChannel($channel) {
        if ($this->list == null) {
            $this->list[0] = $channel;
        } else {
            array_push($this->list, $channel);
        }
    }

    function removeChannel($index) {
        array_splice($this->list, $index, 1);
    }
    //put your code here
}
