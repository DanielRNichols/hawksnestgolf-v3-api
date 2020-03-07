<?php
namespace HawksNestGolf\Resources\SelectionCfg;

class SelectionCfg {
    public $id = 1;
    public $title = "";
    public $numPlayers = 0;
    public $numRounds = "";

    public function __construct($params) {
        $this->title =isset($params->title) ? $params->title : ""; 
        $this->numPlayers = isset($params->numPlayers) ? $params->numPlayers : 0; 
        $this->numRounds = isset($params->numRounds) ? $params->numRounds : 0; 
    }
}
	


