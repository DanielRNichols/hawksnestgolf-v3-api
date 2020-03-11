<?php
namespace HawksNestGolf\Resources\SelectionEntries;

class SelectionEntriesDb {
    
    private $con;
    public function __construct($con) {
        $this->con = $con;
    }

    public function get ($id, $params) {
        $select = "Select id, playerId, pickNumber, entryName
                   from selectionEntries ";
        if($id && ($id > 0)) {
            $whereClause = "where selectionEntries.id='".$id."'";
            $applyFilters = false;
        } else {
            $whereClause = null;
            $applyFilters = true;
        }
        $query = \HawksNestGolf\Db\DbUtils::getQueryString($select, $whereClause, $params, $applyFilters); 
        //var_dump($query);

        $dbSelectionEntries = \HawksNestGolf\Db\DbUtils::getQueryData($this->con, $query, true);
        if($dbSelectionEntries) {
            foreach($dbSelectionEntries as $dbSelectionEntry) {
                $selectionEntries[] = new SelectionEntry($dbSelectionEntry);
             }
        }

        return(isset($selectionEntries) ? $selectionEntries : null);
    }

     public function add ($selectionEntry) {
         $entryName = $selectionEntry->entryName;
         if(!get_magic_quotes_gpc()) {
             $entryName = addslashes($entryName);
         }
         $playerId = $selectionEntry->playerId;
         $pickNumber = $selectionEntry->pickNumber;
         
         $query = "insert into selectionEntries (playerId, pickNumber, entryName) 
                   values ('".$playerId."','".$pickNumber."','".$entryName."')";
        
         //echo ($query);
         return(\HawksNestGolf\Db\DbUtils::insert($this->con, $query));
     }

     public function update ($selectionEntry) {
         $id = $selectionEntry->id;
         $entryName = $selectionEntry->entryName;
         if(!get_magic_quotes_gpc()) {
             $entryName = addslashes($entryName);
         }
         $playerId = $selectionEntry->playerId;
         $pickNumber = $selectionEntry->pickNumber;
         
         $query = "update selectionEntries Set ".
                   "playerId='".$playerId."',".
                   "pickNumber='".$pickNumber."',".
                   "entryName='".$entryName."' ".
                   "where id='".$id."'";
        
       return(\HawksNestGolf\Db\DbUtils::update($this->con, $query));
      }

     public function delete ($id) {
        
         if($id == 'all') {
            $query = "Delete from selectionEntries where id > 0";
         }
         else {
            $query = "Delete from selectionEntries where id = '".$id."'";
         }
        
        //echo ($query);

        return(\HawksNestGolf\Db\DbUtils::delete($this->con, $query));
      }
      
}
                          

