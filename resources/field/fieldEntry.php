<?php
namespace HawksNestGolf\Resources\Field;

class FieldEntry {
    public $id = 0;
    public $golferId = 0;
    public $pgaTourId = 0;
    public $odds = "NR";
    public $oddsRank = 9999;
    
    public $golfer = null;
 
    public function __construct($params) {
        //var_dump($params);
        $this->id = isset($params->id) ? $params->id : 0;
        $this->golferId = isset($params->golferId) ? $params->golferId : 0;
        $this->pgaTourId = isset($params->pgaTourId) ? $params->pgaTourId : 0;
        $this->odds = isset($params->odds) ? $params->odds : "";
        $this->oddsRank = isset($params->oddsRank) ? $params->oddsRank : 0;
     }
}
	

