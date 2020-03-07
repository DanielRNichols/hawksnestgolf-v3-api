<?php
namespace HawksNestGolf\Resources\SelectionEntries;

class SelectionEntry {
    public $id = 0;
    public $playerId = "";
    public $pickNumber = 0;
    public $entryName = "";

    public function __construct($params) {
        $this->id = isset($params->id) ? $params->id : 0;
        $this->playerId =isset($params->playerId) ? $params->playerId : 0; 
        $this->pickNumber =isset($params->pickNumber) ? $params->pickNumber : 0; 
        $this->entryName =isset($params->entryName) ? $params->entryName : ""; 
    }    
}
	

