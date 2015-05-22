<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Comment
 *
 * @author maxi
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Comment extends CI_Controller {
    //put your code here
    
    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('session');
    }
    
    public function index() {
        //esta es la pagina se entra si se pone www.mipagina.com/Video 
    }
    
    
}
