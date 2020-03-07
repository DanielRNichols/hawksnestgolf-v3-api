<?php
namespace HawksNestGolf\Resources\GolferResults;

class GolferResult {
    public $id = 0;
    public $eventId = 0;
    public $golferId = 0;
    public $position = 0;
    public $posVal = 0;
    public $points = 0;
    
    public $golfer = null;
    public $event = null;
    public $pick = null;

    public function __construct($params) {
        //var_dump($params);
        $this->id = isset($params->id) ? $params->id : 0;
        $this->eventId = isset($params->eventId) ? $params->eventId : 0;
        $this->golferId = isset($params->golferId) ? $params->golferId : 0;
        $this->position = isset($params->position) ? $params->position : 0;
        $this->posVal = isset($params->posVal) ? $params->posVal : 0;
        $this->points = isset($params->points) ? $params->points : 0;
    }
}
	

