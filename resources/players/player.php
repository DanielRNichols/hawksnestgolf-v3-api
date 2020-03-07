<?php
namespace HawksNestGolf\Resources\Players;

class Player {
    public $id = 0;
    public $name = "";
    public $userName = "";
    public $email = "";
    public $email2 = "";
    public $isAdmin = false;

    public function __construct($params) {
        $this->id = isset($params->id) ? $params->id : 0;
        $this->name = isset($params->name) ? $params->name : "";
        $this->userName =isset($params->userName) ? $params->userName : "";
        $this->email = isset($params->email) ? $params->email : "";
        $this->email2 = isset($params->email2) ? $params->email2 : ""; 
        $this->isAdmin =isset($params->isAdmin) ? (bool)($params->isAdmin) : false; 
        
    }
}
	

