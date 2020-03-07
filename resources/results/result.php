<?php
namespace HawksNestGolf\Resources\Results;

class Result {
    public $id = 0;
    public $betId = 0;
    public $entryId = 0;
    public $amount = 0;
    
    public $bet = null;
    public $entry = null;

    public function __construct($params) {
        //var_dump($params);
        $this->id = isset($params->id) ? $params->id : 0;
        $this->entryId = isset($params->entryId) ? $params->entryId : 0;
        $this->betId = isset($params->betId) ? $params->betId : 0;
        $this->amount = isset($params->amount) ? $params->amount : 0;
    }
}
	

