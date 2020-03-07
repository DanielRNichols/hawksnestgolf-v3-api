<?php
namespace HawksNestGolf\Repository;

class HawksNestRepository
{
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
    // [/Singleton]


    private $dbInstance = null;
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
    public $Leaderboard = null;

    private function __construct()
    {
        // DB Repositories
        $this->dbInstance = \HawksNestGolf\Db\HawksNestDb::getInstance();
        $this->Bets = new \HawksNestGolf\Resources\Bets\BetsRepo($this->dbInstance);
        $this->Tournaments = new \HawksNestGolf\Resources\Tournaments\TournamentsRepo($this->dbInstance);
        $this->Players = new \HawksNestGolf\Resources\Players\PlayersRepo($this->dbInstance);
        $this->Golfers = new\HawksNestGolf\Resources\Golfers\ GolfersRepo($this->dbInstance);
        $this->Events = new \HawksNestGolf\Resources\Events\EventsRepo($this->dbInstance);
        $this->Field = new \HawksNestGolf\Resources\Field\FieldRepo($this->dbInstance);
        $this->Entries = new \HawksNestGolf\Resources\Entries\EntriesRepo($this->dbInstance);
        $this->Picks = new \HawksNestGolf\Resources\Picks\PicksRepo($this->dbInstance);
        $this->Results = new \HawksNestGolf\Resources\Results\ResultsRepo($this->dbInstance);
        $this->Messages = new \HawksNestGolf\Resources\Messages\MessagesRepo($this->dbInstance);
        $this->GolferResults = new \HawksNestGolf\Resources\GolferResults\GolferResultsRepo($this->dbInstance);
        $this->Selections = new \HawksNestGolf\Resources\Selections\SelectionsRepo($this->dbInstance);
        $this->SelectionEntries = new \HawksNestGolf\Resources\SelectionEntries\SelectionEntriesRepo($this->dbInstance);
        $this->SelectionPicks = new \HawksNestGolf\Resources\SelectionPicks\SelectionPicksRepo($this->dbInstance);
        $this->UserLists = new \HawksNestGolf\Resources\UserLists\UserListsRepo($this->dbInstance);
        $this->Teams = new \HawksNestGolf\Resources\Teams\TeamsRepo($this->dbInstance);
        $this->SelectionCfg = new \HawksNestGolf\Resources\SelectionCfg\SelectionCfgRepo($this->dbInstance);
        $this->EventStatus = new \HawksNestGolf\Resources\EventStatus\EventStatusRepo($this->dbInstance);
        $this->Years = new \HawksNestGolf\Resources\Years\YearsRepo($this->dbInstance);

        // JSON Repositories
        $this->Leaderboard = new \HawksNestGolf\Resources\Leaderboard\LeaderboardRepo();

    }

}
