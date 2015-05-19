<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VideoDTO
 *
 * @author Nicolás
 * 
 * 
 */
class VideoDTO {

    public $id;
    public $idChannel;
    public $name;
    public $link;
    public $date;
    public $duration;
    public $active;
    //datos de usuario
    public $idUser;
    public $usernick;
    public $userthumb;
    //vistas
    public $views;
    //rate promedial 
    public $rate; //Float
    //tags
    public $tags; //TagListDTO

    function __construct() {
        
    }

}
