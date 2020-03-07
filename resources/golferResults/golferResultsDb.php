<?php

namespace HawksNestGolf\Resources\GolferResults;

class GolferResultsDb {
    
    private $con;
    public function __construct($con) {
        $this->con = $con;
    }

    public function get ($id, $params = null) { 
        $select = "Select event_results_golfers.id, event_results_golfers.eventId, 
                          event_results_golfers.golferId, event_results_golfers.position,
                          event_results_golfers.posVal, event_results_golfers.points
                   from event_results_golfers, events, golfers, tournaments";
        $whereClause = "where event_results_golfers.eventId=events.id and
                              event_results_golfers.golferId=golfers.id and 
                              events.tournamentId=tournaments.id";

        if($id && ($id > 0)) {
            $whereClause = $whereClause." and event_results_golfers.id='".$id."'";
            $applyFilters = false;
        } else {
            $applyFilters = true;
        }
        $query = \HawksNestGolf\Db\DbUtils::getQueryString($select, $whereClause, $params, $applyFilters); 
        //echo($query);
        $dbGolferResults = \HawksNestGolf\Db\DbUtils::getQueryData($this->con, $query, true);
        if($dbGolferResults) {
            foreach($dbGolferResults as $dbGolferResult) {
                $golferResults[] = new \HawksNestGolf\Resources\GolferResults\GolferResult($dbGolferResult);
             }
        }    

        return(isset($golferResults) ? $golferResults : null);
    }

     public function add ($golferResult) {
         
         $query = "insert into event_results_golfers (eventId, golferId, position, posVal, points) 
                   values (".
                          "'".$golferResult->eventId."',".
                          "'".$golferResult->golferId."',".
                         "'".$golferResult->position."',".
                         "'".$golferResult->posVal."',".
                          "'".$golferResult->points."')";
        
         //echo ($query);
            
         return(\HawksNestGolf\Db\DbUtils::insert($this->con, $query));
     }

     public function addMultiple ($golferResults) {
//        var_dump($golferResults);
         
         $query = "insert into event_results_golfers (eventId, golferId, position, posVal, points) 
                   values ";
         
         foreach ($golferResults as $golferResult) {
             $query =  $query.
                         "('".$golferResult->eventId."',".
                         "'".$golferResult->golferId."',".
                         "'".$golferResult->position."',".
                         "'".$golferResult->posVal."',".
                         "'".$golferResult->points."'),";
         }
        $query = rtrim($query, ' ,').";";
        
        // echo ($query);
        return(\HawksNestGolf\Db\DbUtils::insert($this->con, $query));
     }

     public function update ($golferResult) {
         
        $query = "update event_results_golfers Set ".
               "eventId='".$golferResult->eventId."',".
               "golferId='".$golferResult->golferId."',".
               "position='".$golferResult->position."' ".
               "posVal='".$golferResult->posVal."' ".
               "points='".$golferResult->points."' ".
               "where id='".$golferResult->id."'";
 
         //echo ($query);
        return(\HawksNestGolf\Db\DbUtils::update($this->con, $query));
     }

     public function delete ($id) {
        $query = "Delete from event_results_golfers where id = '".$id."'";
        
        //echo ($query);
         
        return(\HawksNestGolf\Db\DbUtils::delete($this->con, $query));

      }
}
                          

