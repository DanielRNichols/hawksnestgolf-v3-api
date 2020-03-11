<?php
namespace HawksNestGolf\Resources\Events;

class EventsDb {
    
    private $con;
    public function __construct($con) {
        $this->con = $con;
    }

    public function get ($id = 0, $params = null) { 
        $select = "Select events.id, events.eventNo, events.tournamentId, events.year, events.entryFee, events.status, events.url, events.url2
                   from events, tournaments";
        $whereClause = "where events.tournamentId=tournaments.id";
        if($id && ($id > 0)) {
            $whereClause = $whereClause." and events.id='".$id."'";
            $applyFilters = false;
        } else {
            $applyFilters = true;
        }
        $query = \HawksNestGolf\Db\DbUtils::getQueryString($select, $whereClause, $params, $applyFilters); 
        //echo($query);
        $dbEvents = \HawksNestGolf\Db\DbUtils::getQueryData($this->con, $query, true);
        if($dbEvents) {
            foreach($dbEvents as $dbEvent) {
                $events[] = new Event($dbEvent);
             }
        }    

        return(isset($events) ? $events : null);
    }

     public function add ($event) {
         
         $query = "insert into events (eventNo, tournamentId, year, entryFee, status, url) 
                   values (".
                          "'".$event->eventNo."',".
                          "'".$event->tournamentId."',".
                          "'".$event->year."',".
                          "'".$event->entryFee."',".
                          "'".$event->status."',".
                          "'".$event->url."')";
        
         //echo ($query);
            
         return(\HawksNestGolf\Db\DbUtils::insert($this->con, $query));
     }

     public function update ($event) {
         
        $query = "update events Set ".
               "eventNo='".$event->eventNo."',".
               "tournamentId='".$event->tournamentId."',".
               "year='".$event->year."',".
               "entryFee='".$event->entryFee."', ".
               "status='".$event->status."', ".
               "url='".$event->url."' ".
               "where id='".$event->id."'";
 
         //echo ($query);

         return(\HawksNestGolf\Db\DbUtils::update($this->con, $query));
     }

     public function delete ($id) {
        $query = "Delete from events where id = '".$id."'";
        
        //echo ($query);
         
        return(\HawksNestGolf\Db\DbUtils::delete($this->con, $query));

      }
}
                          

