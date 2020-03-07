<?php
namespace HawksNestGolf\Resources\Results;

class ResultsDb {
    
    private $con;
    public function __construct($con) {
        $this->con = $con;
    }

    public function get ($id, $params = null) { 
        $select = "Select results.id, results.betId, results.entryId, results.amount
                   from results, bets, entries, players, events, tournaments";
        $whereClause = "where results.betId=bets.id and
                              results.entryId=entries.id and 
                              entries.eventId=events.id and
                              entries.playerId=players.id and
                              events.tournamentId=tournaments.id";

        if($id && ($id > 0)) {
            $whereClause = $whereClause." and results.id='".$id."'";
            $applyFilters = false;
        } else {
            $applyFilters = true;
        }
        $query = \HawksNestGolf\Db\DbUtils::getQueryString($select, $whereClause, $params, $applyFilters); 
        //echo($query);
        $dbResults = \HawksNestGolf\Db\DbUtils::getQueryData($this->con, $query, true);
        if($dbResults) {
            foreach($dbResults as $dbResult) {
                $field[] = new Result($dbResult);
             }
        }    

        return(isset($field) ? $field : null);
    }

     public function add ($result) {
         
         $query = "insert into results (betId, entryId, amount) 
                   values (".
                          "'".$result->betId."',".
                          "'".$result->entryId."',".
                          "'".$result->amount."')";
        
         //echo ($query);
            
         return(\HawksNestGolf\Db\DbUtils::insert($this->con, $query));
     }

     public function update ($result) {
         
        $query = "update results Set ".
               "betId='".$result->betId."',".
               "entryId='".$result->entryId."',".
               "amount='".$result->amount."' ".
               "where id='".$result->id."'";
 
         //echo ($query);
        return(\HawksNestGolf\Db\DbUtils::update($this->con, $query));
     }

     public function delete ($id) {
        $query = "Delete from results where id = '".$id."'";
        
        //echo ($query);
         
        return(\HawksNestGolf\Db\DbUtils::delete($this->con, $query));

      }
}
                          

