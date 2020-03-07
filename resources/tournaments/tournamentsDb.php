<?php

namespace HawksNestGolf\Resources\Tournaments;

class TournamentsDb {
    
    private $con;
    public function __construct($con) {
        $this->con = $con;
    }

    public function get ($id, $params) {
        $select = "Select id, name, isOfficialEvent as isOfficial, leaderboardurl as url, leaderboardurl2 as url2
                   from tournaments ";
        if($id && ($id > 0)) {
            $whereClause = "where tournaments.id='".$id."'";
            $applyFilters = false;
        } else {
            $whereClause = null;
            $applyFilters = true;
        }
        $query = \HawksNestGolf\Db\DbUtils::getQueryString($select, $whereClause, $params, $applyFilters); 
        //echo($query);

        $dbTournaments = \HawksNestGolf\Db\DbUtils::getQueryData($this->con, $query, true);
        if($dbTournaments) {
            foreach($dbTournaments as $dbTournament) {
                $tournaments[] = new Tournament($dbTournament);
             }
        }

        return(isset($tournaments) ? $tournaments : null);
    }

     public function add ($tournament) {
         $name = $tournament->name;
         $url = $tournament->url;
         $url2 = $tournament->url2;
         if(!get_magic_quotes_gpc()) {
             $name = addslashes($name);
             $url = addslashes($url);
             $url2 = addslashes($url2);
         }
         
         $isOfficial = $tournament->isOfficial;
         
         $query = "insert into tournaments (name, isOfficialEvent, leaderboardurl, leaderboardurl2) 
                   values ('".$name."','".$isOfficial."','".$url."','".$url2."')";
        
         //echo ($query);
         return(\HawksNestGolf\Db\DbUtils::insert($this->con, $query));
     }

     public function update ($tournament) {
         $id = $tournament->id;
         $name = $tournament->name;
         $url = $tournament->url;
         $url2 = $tournament->url2;
         if(!get_magic_quotes_gpc()) {
             $name = addslashes($name);
             $url = addslashes($url);
             $url2 = addslashes($url2);
         }
         
         $isOfficial = $tournament->isOfficial ? 1 : 0;
         
         $query = "update tournaments Set ".
                   "name='".$name."',".
                   "leaderboardurl='".$url."',".
                   "leaderboardurl2='".$url2."',".
                   "isOfficialEvent='".$isOfficial."' ".
                   "where id='".$id."'";
        
       return(\HawksNestGolf\Db\DbUtils::update($this->con, $query));
      }

     public function delete ($id) {
        $query = "Delete from tournaments where id = '".$id."'";
        
        //echo ($query);

        return(\HawksNestGolf\Db\DbUtils::delete($this->con, $query));
      }
}
                          

