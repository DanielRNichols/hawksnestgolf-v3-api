<?php
namespace HawksNestGolf\Resources\EventStatus;

class EventStatus {
    public $id = 0;
    public $value = 0;
    public $status = "";

    public function __construct($params) {
        //var_dump($params);
        $this->id = isset($params->id) ? $params->id : 0;
        $this->value = isset($params->value) ? $params->value : 0;
        $this->status = isset($params->status) ? $params->status : "";
    }
}
	

