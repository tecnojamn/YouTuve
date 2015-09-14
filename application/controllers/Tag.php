<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tag extends CI_Controller {

    const ACTIVE_DEFAULT_VALUE = '1';

    function __construct() {
        parent::__construct();
        //cargo librerias,helpers necesarios en constructor.
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
    }

    public function index() {
        //esta es la pagina se entra si se pone www.mipagina.com/Tag 
    }

    public function addTag() {
        $this->form_validation->set_rules('name', 'name', 'required');
        if ($this->form_validation->run()) {
            $name = $this->input->post('name');
            $this->load->model("tags_model");
            $this->tags_model->addTag($name);
            //redireccionar al algun view
        } else {
            //redireccionar al mismo view
        }
    }

    public function removeTag() {
        $this->form_validation->set_rules('name', 'name', 'required');
        if ($this->form_validation->run()) {
            $name = $this->input->post('name');
            $this->load->model("tags_model");
            $this->tags_model->removeTag($name);
            //redireccionar a algun view
        } else {
            //redireccionar al mismo view
        }
    }

    public function getTagFromVideo() {
        $this->form_validation->set_rules('id', 'id', 'required');
        if ($this->form_validation->run()) {
            $id = $this->input->post('id');
            $this->load->model("tags_model");
            $tagList = $this->tags_model->getTagFromVideo($id);
            //redireccionar a algun lado con los tags
        } else {
            //redireccionar al mismo view
        }
    }

    public function getAllTagAx() {
        $this->load->model("tags_model");
        $tagList = $this->tags_model->getAllTags();
        $data['tagList'] = $tagList;
        $formString = $this->load->view('tags_list', $data, true);
        $arr = array('result' => 'true', 'html' => $formString);
        echo json_encode($arr, JSON_HEX_QUOT | JSON_HEX_TAG);
        return;
        //enviar a algun view con los tags
    }

}
