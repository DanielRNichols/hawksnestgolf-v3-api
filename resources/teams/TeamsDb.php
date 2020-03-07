<?php
namespace HawksNestGolf\Resources\Teams;

class TeamsDb {
    
    private $con;
    public function __construct($con) {
        $this->con = $con;
    }

    public function get ($eventId, $params = null) { 
        $select = "Select teamNo, entryId, teamName, sum(points) pointTotal from
                    (
                        SELECT entries.id entryId, entries.pickNumber teamNo, players.name teamName, golfers.name golfer, event_results_golfers.points points
                                from picks 
                                Inner Join golfers on picks.golferId = golfers.id
                                Inner Join entries on picks.entryId = entries.id
                                Inner Join players on entries.playerId = players.id
                                Inner Join events on entries.eventId = events.id
                                Inner Join event_results_golfers on (events.id = event_results_golfers.eventId and golfers.id = event_results_golfers.golferId)
                                where events.id =".$eventId.
                        ") as teams
                    group by  teamNo";
                    //order by total desc";
        
        $whereClause = "";
        $applyFilters = true;
        $query = \HawksNestGolf\Db\DbUtils::getQueryString($select, $whereClause, $params, $applyFilters); 
//        var_dump($query);
        $dbTeams = \HawksNestGolf\Db\DbUtils::getQueryData($this->con, $query, true);
//        var_dump($dbTeams);
        if($dbTeams) {
            foreach($dbTeams as $dbTeam) {
                $team[] = new Team($dbTeam);
             }
        }    

        return(isset($team) ? $team : null);
    }

}
                          

