<?php
namespace HawksNestGolf\Resources\Selections;

class SelectionsDb {
    
    private $con;
    public function __construct($con) {
        $this->con = $con;
    }

    public function get ($id, $params) {
        $select = "Select id, cellId, value, prev_value, isPlayer
                   from selections ";
        if($id && ($id > 0)) {
            $whereClause = "where selections.id='".$id."'";
            $applyFilters = false;
        } else {
            $whereClause = null;
            $applyFilters = true;
        }
        $query = \HawksNestGolf\Db\DbUtils::getQueryString($select, $whereClause, $params, $applyFilters); 
        //echo($query);

        $dbSelections = \HawksNestGolf\Db\DbUtils::getQueryData($this->con, $query, true);
        if($dbSelections) {
            foreach($dbSelections as $dbSelection) {
                $selections[] = new Selection($dbSelection);
             }
        }

        return(isset($selections) ? $selections : null);
    }

     public function add ($selection) {
         $value = $selection->value;
         if(!get_magic_quotes_gpc()) {
             $value = addslashes($value);
         }
         $cellId = $selection->cellId;
         $isPlayer = $selection->isPlayer;
         $round = $selection->round;
         $pickNumber = $selection->pickNumber;
         
         $query = "insert into selections (cellId, value, isPlayer, round, pickNumber) 
                   values ('".$cellId."','".$value."','".$isPlayer."','".$round."','".$pickNumber."')";
        
         //echo ($query);
         return(\HawksNestGolf\Db\DbUtils::insert($this->con, $query));
     }

     public function update ($selection) {
         $id = $selection->id;
         $value = $selection->value;
         if(!get_magic_quotes_gpc()) {
             $value = addslashes($value);
         }
         
         $cellId = $selection->cellId;
         $isPlayer = $selection->isPlayer;
         $round = $selection->round;
         $pickNumber = $selection->pickNumber;
         
         $query = "update selections Set ".
                   "prev_value=value,".
                   "cellId='".$cellId."',".
                   "value='".$value."',".
                   "isPlayer='".$isPlayer."',".
                   "round='".$round."',".
                   "pickNumber='".$pickNumber."' ".
                   "where id='".$id."'";
        
       return(\HawksNestGolf\Db\DbUtils::update($this->con, $query));
      }

     public function delete ($id) {
        
         if($id == 'all') {
            $query = "Delete from selections where id > 0";
         }
         else {
            $query = "Delete from selections where id = '".$id."'";
         }
        
        echo ($query);

        return(\HawksNestGolf\Db\DbUtils::delete($this->con, $query));
      }
      
}
                          

