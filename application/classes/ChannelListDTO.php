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
    
=======
 * Description of ChannelListDto
 *
 * @author Julito
 */
class ChannelListDto {

>>>>>>> origin/search-channel
    public $list; //array

    function __construct() {
        
    }

<<<<<<< HEAD
    function addChannel($channel) {
        if ($this->list == null) {
            $this->list[0] = $channel;
        } else {
            array_push($this->list, $channel);
        }
=======
    function addChannel($channelDto) {
//array_push no funciona sobre array vacios  
        if ($this->list==null) {
            $this->list[0] = $channelDto;
        } else
        array_push($this->list, $channelDto);
>>>>>>> origin/search-channel
    }

    function removeChannel($index) {
        array_splice($this->list, $index, 1);
    }
<<<<<<< HEAD
    //put your code here
}
=======

}
>>>>>>> origin/search-channel
