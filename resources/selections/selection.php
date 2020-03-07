<?php
namespace HawksNestGolf\Resources\Selections;

class Selection {
    public $id = 0;
    public $cellId = "";
    public $pickNumber = 0;
    public $round = 0;
    public $value = "";
	public $prev_value = "";
    public $isPlayer = false;

    public function __construct($params) {
        $this->id = isset($params->id) ? $params->id : 0;
        $this->cellId =isset($params->cellId) ? $params->cellId : ""; 
        $this->value =isset($params->value) ? $params->value : ""; 
        $this->prev_value =isset($params->prev_value) ? $params->prev_value : ""; 
        $this->isPlayer = isset($params->isPlayer) ? (bool)($params->isPlayer) : false; 
        
        $this->pickNumber = $this->getPickNumberFromCellId($this->cellId);
        $this->round = $this->getRoundNumberFromCellId($this->cellId);
    }
    
  private function getPickNumberFromCellId($cellId)
  {
    $pickNo = 0;
    $subStr = substr($cellId, 1);
    if(strlen($subStr) > 0) {
        $pickNo = intval($subStr)+1;
    }
    
    return ($pickNo);
  }

  private function getRoundNumberFromCellId($cellId)
  {
    $roundNo = 0;
    $subStr = strstr($cellId, '_');
    if(strlen($subStr) > 1)
      $roundNo = intval(substr($subStr, 1));
    
    return ($roundNo);
  }

    
}
	

