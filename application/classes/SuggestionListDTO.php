<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SuggestionListDTO
 *
 * @author Nicolás
 */
class SuggestionListDTO {

    public $list; //array

    function __construct() {
        
    }

    function addSuggestion($suggestionDTO) {
        array_push($list, $suggestionDTO);
    }

    function removeSuggestion($index) {
        array_splice($this->list, $index, 1);
    }

}
