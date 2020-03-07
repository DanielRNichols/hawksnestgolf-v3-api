<?php
namespace HawksNestGolf\Resources\Entries;

class Entry {
    public $id = 0;
    public $eventId = 0;
    public $playerId = 0;
    public $pickNumber = 0;
    public $entryName = "";
    
    public $player = null;
    public $event = null;
 
    public function __construct($params) {
        //var_dump($params);
        $this->id = isset($params->id) ? $params->id : 0;
        $this->eventId = isset($params->eventId) ? $params->eventId : 0;
        $this->playerId = isset($params->playerId) ? $params->playerId : 0;
        $this->pickNumber = isset($params->pickNumber) ? $params->pickNumber : "";
        $this->entryName = isset($params->entryName) ? $params->entryName : "";
     }
}
	

