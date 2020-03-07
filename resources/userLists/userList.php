<?php
namespace HawksNestGolf\Resources\UserLists;

class UserList {
    public $id = 0;
    public $playerId = 0;
    public $golferId = 0;
    public $rank = 0;
    public $code = 0;

    public function __construct($params) {
        $this->id = isset($params->id) ? $params->id : 0;
        $this->playerId = isset($params->playerId) ? $params->playerId : 0;
        $this->golferId = isset($params->golferId) ? $params->golferId : 0;
        $this->rank = isset($params->rank) ? $params->rank : 0;
        $this->code = isset($params->code) ? $params->code : 0;
    }
}
