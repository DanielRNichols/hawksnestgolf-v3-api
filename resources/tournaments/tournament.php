<?php
namespace HawksNestGolf\Resources\Tournaments;

class Tournament {
    public $id = 0;
    public $name = "";
    public $isOfficial = false;
    public $url = "";
    public $url2 = "";

    public function __construct($params) {
        $this->id = isset($params->id) ? $params->id : 0;
        $this->name =isset($params->name) ? $params->name : ""; 
        $this->isOfficial = isset($params->isOfficial) ? (bool)($params->isOfficial) : false; 
        $this->url =isset($params->url) ? $params->url : ""; 
        $this->url2 =isset($params->url2) ? $params->url2 : ""; 
    }
}
	

