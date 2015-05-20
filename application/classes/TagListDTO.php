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
//array_push no funciona sobre array vacios        
        if ($this->list==null) {
            $this->list[0] = $tagDto;
        } else
            array_push($this->list, $tagDto);
    }

    function removeTag($index) {
        array_splice($this->list, $index, 1);
    }

}
