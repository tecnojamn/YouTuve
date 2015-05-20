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
        if($this->list==NULL){
            $this->list[0]=$suggestionDTO;
        }else{
            array_push($this->list, $suggestionDTO);
        }
    }

    function removeSuggestion($index) {
        array_splice($this->list, $index, 1);
    }

}
