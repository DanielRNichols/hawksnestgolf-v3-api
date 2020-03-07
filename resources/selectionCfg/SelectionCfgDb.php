<?php

namespace HawksNestGolf\Resources\SelectionCfg;

class SelectionCfgDb {
    
    private $con;
    public function __construct($con) {
        $this->con = $con;
    }

    public function get ($id, $params) {
        $select = "Select tournament as title, numPlayers, numRounds 
                   from selectionconfig";
        
        $whereClause = "where selectionconfig.id='1'";
        $applyFilters = false;

        $query = \HawksNestGolf\Db\DbUtils::getQueryString($select, $whereClause, $params, $applyFilters); 
        //echo($query);

        $dbSelectionCfg = \HawksNestGolf\Db\DbUtils::getQueryData($this->con, $query, true);
        if($dbSelectionCfg) {
            foreach($dbSelectionCfg as $dbTournament) {
                $selectionCfg[] = new SelectionCfg($dbTournament);
             }
        }

        return(isset($selectionCfg) ? $selectionCfg : null);
    }

     public function add ($selectionCfg) {
         $title = $selectionCfg->title;
         if(!get_magic_quotes_gpc()) {
             $name = addslashes($title);
         }
         
         $id = 1;
         
         $query = "insert into selectionconfig (id, tournament, numPlayers, numRounds) 
                   values ('".$id."','".$title."','".$selectionCfg->numPlayers."','".$selectionCfg->numRounds."')";
        
         //echo ($query);
         return(\HawksNestGolf\Db\DbUtils::insert($this->con, $query));
     }

     public function update ($selectionCfg) {
        $title = $selectionCfg->title;
        if(!get_magic_quotes_gpc()) {
             $name = addslashes($title);
         }
         
         $id = 1;
             
         $query = "update selectionconfig Set ".
                   "tournament='".$title."',".
                   "numPlayers='".$selectionCfg->numPlayers."',".
                   "numRounds='".$selectionCfg->numRounds."' ".
                   "where id='".$id."'";
         
      //var_dump($query);
        
       return(\HawksNestGolf\Db\DbUtils::update($this->con, $query));
      }

     public function delete ($id) {
        $query = "Delete from selectionconfig where id = '".$id."'";
        
        //echo ($query);

        return(\HawksNestGolf\Db\DbUtils::delete($this->con, $query));
      }
}
                          

