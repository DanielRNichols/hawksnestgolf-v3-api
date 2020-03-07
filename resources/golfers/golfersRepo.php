<?php
namespace HawksNestGolf\Resources\Golfers;

Class GolfersRepo extends \HawksNestGolf\Resources\Base\BaseRepo {
    
    public function __construct($dbInstance) {
        parent::__construct($dbInstance->Golfers);
    }
    
    public function updateRankings ($worldRankings, $fedExRankings) {
        return $this->dbHandler->updateRankings($worldRankings, $fedExRankings);
    }

    public function updateWorldRankings ($worldRankings) {
        return $this->dbHandler->updateWorldRankings($worldRankings);
    }

    public function updateFedExRankings ($fedExRankings) {
        return $this->dbHandler->updateFedExRankings($fedExRankings);
    }

    public function updateFromLeaderboard ($leaderboard) {
        return $this->dbHandler->updateFromLeaderboard($leaderboard);
    }
}


