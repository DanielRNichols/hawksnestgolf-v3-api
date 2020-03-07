<?php
namespace HawksNestGolf\Resources\Field;

class FieldDb {
    
    private $con;
    public function __construct($con) {
        $this->con = $con;
    }

    public function get ($id=0, $params = null) { 
        $select = "Select field.id, field.golferId, field.pgaTourId, field.odds, field.oddsRank 
                   from field, golfers";
        $whereClause = "where field.golferId=golfers.id";
        if($id && ($id > 0)) {
            $whereClause = $whereClause." and field.id='".$id."'";
            $applyFilters = false;
        } else {
            $applyFilters = true;
        }
        $query = \HawksNestGolf\Db\DbUtils::getQueryString($select, $whereClause, $params, $applyFilters); 
        //echo($query);
        $dbField = \HawksNestGolf\Db\DbUtils::getQueryData($this->con, $query, true);
        if($dbField) {
            foreach($dbField as $dbFieldEntry) {
                $field[] = new FieldEntry($dbFieldEntry);
             }
        }    

        return(isset($field) ? $field : null);
    }

     public function add ($fieldEntry) {
         
         $query = "insert into field (golferId, pgaTourId, odds, oddsRank) 
                   values (".
                          "'".$fieldEntry->golferId."',".
                          "'".$fieldEntry->pgaTourId."',".
                          "'".$fieldEntry->odds."',".
                          "'".$fieldEntry->oddsRank."')";
        
         //echo ($query);
            
         return(\HawksNestGolf\Db\DbUtils::insert($this->con, $query));
     }

     public function addMultiple ($fieldEntries) {
//        var_dump($fieldEntries);
         
         $query = "insert into field (golferId, pgaTourId, odds, oddsRank)  
                   values ";
         
         foreach ($fieldEntries as $fieldEntry) {
             $query =  $query.
                         "('".$fieldEntry->golferId."',".
                         "'".$fieldEntry->pgaTourId."',".
                         "'".$fieldEntry->odds."',".
                         "'".$fieldEntry->oddsRank."'),";
         }
        $query = rtrim($query, ' ,').";";
        
//        echo ($query);
//        return "";
        return(\HawksNestGolf\Db\DbUtils::insert($this->con, $query));
     }
     
     public function update ($fieldEntry) {
         
        $query = "update field Set ".
               "golferId='".$fieldEntry->golferId."',".
               "pgaTourId='".$fieldEntry->pgaTourId."',".
               "odds='".$fieldEntry->odds."',".
               "oddsRank='".$fieldEntry->oddsRank."' ".
               "where id='".$fieldEntry->id."'";
 
         //echo ($query);
        return(\HawksNestGolf\Db\DbUtils::update($this->con, $query));
     }

     public function delete ($id) {
         if($id == 'all') {
            $query = "Delete from field where id > 0";
         }
         else {
            $query = "Delete from field where id = '".$id."'";
         }
         
        //echo ($query);
         
        return(\HawksNestGolf\Db\DbUtils::delete($this->con, $query));

      }
      
      public function clear () {
        $query = "Delete from field where id > '0'";
        
        //echo ($query);
         
        return(\HawksNestGolf\Db\DbUtils::delete($this->con, $query));
      }
}
                          

