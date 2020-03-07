<?php
namespace HawksNestGolf\Resources\SelectionPicks;

class SelectionPick {
    public $id = 0;
    public $entryId = 0;
    public $round = 0;
    public $golferId = 0;
    public $selectionName = "";
    public $modifiedTime = "";

    public function __construct($params) {
        $this->id = isset($params->id) ? $params->id : 0;
        $this->entryId =isset($params->entryId) ? $params->entryId : 0; 
        $this->round =isset($params->round) ? $params->round : 0; 
        $this->golferId =isset($params->golferId) ? $params->golferId : 0; 
        $this->selectionName =isset($params->selectionName) ? $params->selectionName : ""; 
        $this->modifiedTime =isset($params->modifiedTime) ? $params->modifiedTime : ""; 
    }    
}
	

