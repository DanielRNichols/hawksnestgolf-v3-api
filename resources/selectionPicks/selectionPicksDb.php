<?php
namespace HawksNestGolf\Resources\SelectionPicks;

class SelectionPicksDb {
    
    private $con;
    public function __construct($con) {
        $this->con = $con;
    }

    public function get ($id, $params) {
        $select = "Select id, entryId, round, golferId, selectionName, modifiedTime
                   from selectionPicks ";
        if($id && ($id > 0)) {
            $whereClause = "where selectionPicks.id='".$id."'";
            $applyFilters = false;
        } else {
            $whereClause = null;
            $applyFilters = true;
        }
        $query = \HawksNestGolf\Db\DbUtils::getQueryString($select, $whereClause, $params, $applyFilters); 
        //var_dump($query);

        $dbSelectionPicks = \HawksNestGolf\Db\DbUtils::getQueryData($this->con, $query, true);
        if($dbSelectionPicks) {
            foreach($dbSelectionPicks as $dbSelectionPick) {
                $selectionPicks[] = new SelectionPick($dbSelectionPick);
             }
        }

        return(isset($selectionPicks) ? $selectionPicks : null);
    }

     public function add ($selectionPick) {
         $selectionName = $selectionPick->selectionName;
         if(!get_magic_quotes_gpc()) {
             $selectionName = addslashes($selectionName);
         }
         $entryId = $selectionPick->entryId;
         $round = $selectionPick->round;
         $golferId = $selectionPick->golferId;
         $modifiedTime = $selectionPick->modifiedTime;
         
         $query = "insert into selectionPicks (entryId, round, golferId, selectionName, modifiedTime) 
                   values ('".$entryId."','".$round."','".$golferId."','".$selectionName."','".$modifiedTime."')";
        
         //echo ($query);
         return(\HawksNestGolf\Db\DbUtils::insert($this->con, $query));
     }

     public function update ($selectionPick) {
         $id = $selectionPick->id;
         $selectionName = $selectionPick->selectionName;
         if(!get_magic_quotes_gpc()) {
             $selectionName = addslashes($selectionName);
         }
         $entryId = $selectionPick->entryId;
         $round = $selectionPick->round;
         $golferId = $selectionPick->golferId;
         $modifiedTime = $selectionPick->modifiedTime;
         
         $query = "update selectionPicks Set ".
                   "entryId='".$entryId."',".
                   "round='".$round."',".
                   "golferId='".$golferId."',".
                   "selectionName='".$selectionName."',".
                   "modifiedTime='".$modifiedTime."' ".
                   "where id='".$id."'";
        
       return(\HawksNestGolf\Db\DbUtils::update($this->con, $query));
      }

     public function delete ($id) {
        
         if($id == 'all') {
            $query = "Delete from selectionPicks where id > 0";
         }
         else {
            $query = "Delete from selectionPicks where id = '".$id."'";
         }
        
        echo ($query);

        return(\HawksNestGolf\Db\DbUtils::delete($this->con, $query));
      }
      
}
                          

