<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ViewHistoryListDTO
 *
 * @author maxi
 */
class ViewHistoryListDTO {
 
    public $list; //array

    function __construct() {
        
    }

    function addView($view) {
//array_push no funciona sobre array vacios  
        if ($this->list==null) {
            $this->list[0] = $view;
        } else
        array_push($this->list, $view);
    }

    function removeView($index) {
        array_splice($this->list, $index, 1);
    }

}

