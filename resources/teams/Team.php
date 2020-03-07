<?php

namespace HawksNestGolf\Resources\Teams;

class Team {
    public $entryId = 0;
    public $teamNo = 0;
    public $teamName = "";
    public $pointTotal = 0;
    public $position = "";
    
    public $owner = null;
    public $picks = null;

    public function __construct($params) {
        $this->entryId = isset($params->entryId) ? $params->entryId : 0;
        $this->teamNo = isset($params->teamNo) ? $params->teamNo : 0;
        $this->teamName = isset($params->teamName) ? $params->teamName : "";
        $this->pointTotal = isset($params->pointTotal) ? $params->pointTotal : 0;
        $this->position = isset($params->position) ? $params->position : "";
    }
}
	
