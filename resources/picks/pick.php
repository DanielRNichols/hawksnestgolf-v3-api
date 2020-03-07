<?php
namespace HawksNestGolf\Resources\Picks;

class Pick {
    public $id = 0;
    public $entryId = 0;
    public $round = 0;
    public $golferId = 0;
    
    public $entry = null;
    public $golfer = null;
    public $golferResult = null;

    public function __construct($params) {
        //var_dump($params);
        $this->id = isset($params->id) ? $params->id : 0;
        $this->entryId = isset($params->entryId) ? $params->entryId : "";
        $this->round = isset($params->round) ? $params->round : "";
        $this->golferId = isset($params->golferId) ? $params->golferId : "";
    }
}
	

