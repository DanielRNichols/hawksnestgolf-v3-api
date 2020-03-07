<?php

namespace HawksNestGolf\Resources\Entries;

class EntriesDb {
    
    private $con;
    public function __construct($con) {
        $this->con = $con;
    }

    public function get ($id = 0, $params = null) { 
        $select = "Select entries.id, entries.eventId, entries.playerId, entries.pickNumber, entries.entryName
                   from entries, players, events, tournaments";
        $whereClause = "where entries.playerId=players.id and 
                              entries.eventId=events.id and
                              events.tournamentId=tournaments.id";
        if($id && ($id > 0)) {
            $whereClause = $whereClause." and entries.id='".$id."'";
            $applyFilters = false;
        } else {
            $applyFilters = true;
        }
        $query = \HawksNestGolf\Db\DbUtils::getQueryString($select, $whereClause, $params, $applyFilters); 
        //echo($query);
        $dbEntries = \HawksNestGolf\Db\DbUtils::getQueryData($this->con, $query, true);
        if($dbEntries) {
            foreach($dbEntries as $dbEntry) {
                $entries[] = new Entry($dbEntry);
             }
        }    

        return(isset($entries) ? $entries : null);
    }

     public function add ($entry) {
         
         $query = "insert into entries (eventId, playerId, pickNumber, entryName) 
                   values (".
                          "'".$entry->eventId."',".
                          "'".$entry->playerId."',".
                          "'".$entry->pickNumber."',".
                          "'".$entry->entryName."')";
        
         //echo ($query);
            
         return(\HawksNestGolf\Db\DbUtils::insert($this->con, $query));
     }

     public function update ($entry) {
         
        $query = "update entries Set ".
               "eventId='".$entry->eventId."',".
               "playerId='".$entry->playerId."',".
               "pickNumber='".$entry->pickNumber."',".
               "entryName='".$entry->entryName."' ".
               "where id='".$entry->id."'";
 
        return(\HawksNestGolf\Db\DbUtils::update($this->con, $query));
     }

     public function delete ($id) {
        $query = "Delete from entries where id = '".$id."'";
        
        //echo ($query);
         
        return(\HawksNestGolf\Db\DbUtils::delete($this->con, $query));

      }
}
                          

