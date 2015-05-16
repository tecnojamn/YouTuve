<?php

class Tags_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table = "tag";
    }

    public function push($name) {
        $data["name"] = $name;
        return $this->save($data);
    }

}
