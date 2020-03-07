<?php
namespace HawksNestGolf\Db;

class HawksNestDb {

    private static $instance = null;

    public static function getInstance()
    {
        if (!self::$instance)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __clone(){}


    private $con = null;
    public $Bets = null;
    public $Tournaments = null;
    public $Players = null;
    public $Golfers = null;
    public $Events = null;
    public $Field = null;
    public $Entries = null;
    public $Picks = null;
    public $Results = null;
    public $Messages = null;
    public $GolferResults = null;
    public $Selections = null;
    public $SelectionEntries = null;
    public $SelectionPicks = null;
    public $UserLists = null;
    public $Teams = null;
    public $SelectionCfg = null;
    public $EventStatus = null;
    public $Years = null;

    private function __construct() {
        $this->con = DbConfig::getConnection();
        if($this->con == null) {
            exit(DbConfig::getConnectionError());
        }

        $this->Bets = new \HawksNestGolf\Resources\Bets\BetsDb($this->con);
        $this->Tournaments = new \HawksNestGolf\Resources\Tournaments\TournamentsDb($this->con);
        $this->Players = new \HawksNestGolf\Resources\Players\PlayersDb($this->con);
        $this->Golfers = new \HawksNestGolf\Resources\Golfers\GolfersDb($this->con);
        $this->Events = new \HawksNestGolf\Resources\Events\EventsDb($this->con);
        $this->Field = new \HawksNestGolf\Resources\Field\FieldDb($this->con);
        $this->Entries = new \HawksNestGolf\Resources\Entries\EntriesDb($this->con);
        $this->Picks = new \HawksNestGolf\Resources\Picks\PicksDb($this->con);
        $this->Results = new \HawksNestGolf\Resources\Results\ResultsDb($this->con);
        $this->Messages = new \HawksNestGolf\Resources\Messages\MessagesDb($this->con);
        $this->GolferResults = new \HawksNestGolf\Resources\GolferResults\GolferResultsDb($this->con);
        $this->Selections = new \HawksNestGolf\Resources\Selections\SelectionsDb($this->con);
        $this->SelectionEntries = new \HawksNestGolf\Resources\SelectionEntries\SelectionEntriesDb($this->con);
        $this->SelectionPicks = new \HawksNestGolf\Resources\SelectionPicks\SelectionPicksDb($this->con);
        $this->UserLists = new \HawksNestGolf\Resources\UserLists\UserListsDb($this->con);
        $this->Teams = new \HawksNestGolf\Resources\Teams\TeamsDb($this->con);
        $this->EventStatus = new \HawksNestGolf\Resources\EventStatus\EventStatusDb($this->con);
        $this->Years = new \HawksNestGolf\Resources\Years\YearsDb($this->con);

        $this->SelectionCfg = new \HawksNestGolf\Resources\SelectionCfg\SelectionCfgDb($this->con);
    }
}
