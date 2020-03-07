<?php
namespace HawksNestGolf\Resources\Events;

class Event {
    public $id = 0;
    public $eventNo = 0;
    public $tournamentId = 0;
    public $year = "";
    public $entryFee = 0.0;
    public $status = 0;
    public $url = "";
    public $url2 = "";

    public $tournament = null;

    public function __construct($params) {
        $this->id = isset($params->id) ? $params->id : 0;
        $this->eventNo =isset($params->eventNo) ? $params->eventNo : 0; 
        $this->tournamentId = isset($params->tournamentId) ? $params->tournamentId : 0; 
        $this->year =isset($params->year) ? $params->year : ""; 
        $this->entryFee =isset($params->entryFee) ? $params->entryFee : 0.0; 
        $this->status =isset($params->status) ? $params->status : 0; 
        $this->url =isset($params->url) ? $params->url : ""; 
        $this->url2 =isset($params->url2) ? $params->url2 : ""; 
        
    }
}
	

