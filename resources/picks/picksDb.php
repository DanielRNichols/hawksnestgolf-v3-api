<?php
namespace HawksNestGolf\Resources\Picks;

class PicksDb {
    
    private $con;
    public function __construct($con) {
        $this->con = $con;
    }

    public function get ($id, $params = null) { 
        $select = "Select picks.id, picks.entryId, picks.round, picks.golferId
                   from picks, entries, players, golfers, events, tournaments";
        $whereClause = "where picks.entryId=entries.id and 
                              picks.golferId=golfers.id and
                              entries.eventId=events.id and
                              entries.playerId=players.id and
                              events.tournamentId=tournaments.id";

        if($id && ($id > 0)) {
            $whereClause = $whereClause." and picks.id='".$id."'";
            $applyFilters = false;
        } else {
            $applyFilters = true;
        }
        $query = \HawksNestGolf\Db\DbUtils::getQueryString($select, $whereClause, $params, $applyFilters); 
        //echo($query);
        $dbPicks = \HawksNestGolf\Db\DbUtils::getQueryData($this->con, $query, true);
        if($dbPicks) {
            foreach($dbPicks as $dbPick) {
                $field[] = new Pick($dbPick);
             }
        }    

        return(isset($field) ? $field : null);
    }

     public function add ($pick) {
         
         $query = "insert into picks (entryId, round, golferId) 
                   values (".
                          "'".$pick->entryId."',".
                          "'".$pick->round."',".
                          "'".$pick->golferId."')";
        
         //echo ($query);
            
         return(\HawksNestGolf\Db\DbUtils::insert($this->con, $query));
     }

     public function update ($pick) {
         
        $query = "update picks Set ".
               "entryId='".$pick->entryId."',".
               "round='".$pick->round."',".
               "golferId='".$pick->golferId."' ".
               "where id='".$pick->id."'";
 
         //echo ($query);
        return(\HawksNestGolf\Db\DbUtils::update($this->con, $query));
     }

     public function delete ($id) {
        $query = "Delete from picks where id = '".$id."'";
        
        //echo ($query);
         
        return(\HawksNestGolf\Db\DbUtils::delete($this->con, $query));

      }
}
                          

