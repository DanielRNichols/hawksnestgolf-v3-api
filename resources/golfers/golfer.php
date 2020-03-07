<?php
namespace HawksNestGolf\Resources\Golfers;

class Golfer {
    public $id = 0;
    public $pgaTourId = 0;
    public $name = "";
    public $selectionName = "";
    public $country = "";
    public $worldRanking = 0;
    public $fedExRanking = 0;
    public $fedExPoints = 0;
    public $image = "";

    public function __construct($params) {
        $this->id = isset($params->id) ? $params->id : 0;
        $this->pgaTourId = isset($params->pgaTourId) ? $params->pgaTourId : 0; 
        $this->name = isset($params->name) ? $params->name : ""; 
        $this->selectionName = isset($params->selectionName) ? $params->selectionName : ""; 
        $this->country = isset($params->country) ? $params->country : ""; 
        $this->worldRanking = isset($params->worldRanking) ? $params->worldRanking : ""; 
        $this->fedExRanking = isset($params->fedExRanking) ? $params->fedExRanking : ""; 
        $this->fedExPoints = isset($params->fedExPoints) ? $params->fedExPoints : 0; 
        $this->image = isset($params->image) ? $params->image : ""; 

    }
}
	

