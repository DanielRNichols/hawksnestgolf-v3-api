<?php
namespace HawksNestGolf\Resources\Years;

class Year {
    public $id = 0;
    public $year = "";

    public function __construct($params) {
        //var_dump($params);
        $this->id = isset($params->id) ? $params->id : 0;
        $this->year = isset($params->year) ? $params->year : "";
    }
}
	

