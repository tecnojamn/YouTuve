<?php


/**
 * Description of User
 *
 * @author Nicolás
 */
class ChannelDTO {

    public $id;
    public $name;
    public $description;
    public $frontImgUrl;
    public $videos;
    
    public $idUser;
    public $username;
    
    public $followersCount;

    function __construct() {
        
    }

}
