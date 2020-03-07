<?php
namespace HawksNestGolf\Resources\Messages;

class Message {
    public $id = 0;
    public $playerId = 0;
    public $message = "";

    public $player= null;

    public function __construct($params) {
        $this->id = isset($params->id) ? $params->id : 0;
        $this->playerId =isset($params->playerId) ? $params->playerId : 0; 
        $this->message =isset($params->message) ? $params->message : ""; 
    }
}
	

