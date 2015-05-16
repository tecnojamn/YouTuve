<?php

/**
 * Description of User
 *
 * @author Nicolás
 */
class TagListDTO {

    public $list; //array

    function __construct() {
        
    }

    function addTag($tagDto) {
        array_push($list, $tagDto);
    }

    function removeTag($index) {
        array_splice($this->list, $index, 1);
    }

}
