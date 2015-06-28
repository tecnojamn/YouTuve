<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
  <<<<<<< HEAD
 * Description of ChannelListDTO
 *
 * @author maxi
 */
class ChannelListDTO {

    public $list; //array

    function __construct() {
        
    }


        function addChannel($channelDto) {
//array_push no funciona sobre array vacios  
            if ($this->list == null) {
                $this->list[0] = $channelDto;
            } else
                array_push($this->list, $channelDto);
        }

        function removeChannel($index) {
            array_splice($this->list, $index, 1);
        }

        //put your code here


}
