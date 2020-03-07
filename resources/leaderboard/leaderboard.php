<?php
namespace HawksNestGolf\Resources\Leaderboard;

class LeaderboardGolfer {
    public $lbIndex = 0;
    public $owner = "";
    public $pgaTourId = "";
    public $name = "";
    public $selectionName = "";
    public $country = "";
    public $courseId = "";
    public $pos = "";
    public $total = "";
    public $round = "";
    public $thru = "";
    public $move = 0;
    public $status = "";
    public $points = 0;
    public $startHole = 1;
    public $scorecard;
    public $statusSort = "";
    public $fedExRanking = "";
    public $projectedFedExRanking = "";
    public $projectedFedExPoints = "";
    public $fedExMove = "";
    public $rounds;

    public function __construct($pgaTourId) 
    {
        $this->pgaTourId = $pgaTourId;
    }

}

class Team {
    public $id = 0;
    public $teamName = null;
    public $teamNo = 0;
    public $picks = null;
    public $pointTotal = 0;
    public $score = 0;
    public $status = 'active';
    public $numActive = 0;
    public $numInsideCut = 0;
    public $numWD = 0;
    public $position = '';
    public $lbIndex = 0;

    public function __construct($id, $owner, $pickNumber ) {
        $this->id = $id;
        $this->teamName = $owner;
        $this->teamNo = $pickNumber;
    }

    public function UpdatePoints() {
        $this->pointTotal = 0;
        if(isset($this->$picks))
        {
            $numPicks = count($this->$picks);
            for($i = 0; $i < $numPicks; $i++) {
                $this->pointTotal += $this->$picks[i].points;
            }
        }
    }
}       


	
