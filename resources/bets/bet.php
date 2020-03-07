<?php
namespace HawksNestGolf\Resources\Bets;

class Bet {
    public $id = 0;
    public $name = "";
    public $defAmount = 0;

    public function __construct($params) {
        //var_dump($params);
        $this->id = isset($params->id) ? $params->id : 0;
        $this->name = isset($params->name) ? $params->name : "";
        $this->defAmount = isset($params->defAmount) ? $params->defAmount : 0;
    }
}
	

