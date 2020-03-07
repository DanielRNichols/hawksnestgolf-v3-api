<?php
namespace HawksNestGolf\Resources\Years;

class YearsDb {
    
    private $con;
    public function __construct($con) {
        $this->con = $con;
    }

    public function get ($id = 0, $params = null) { 
        $select = "Select years.id, years.year from years";
        
        if($id && ($id > 0)) {
            $whereClause = "where years.id='".$id."'";
            $applyFilters = false;
        } else {
            $whereClause = null;
            $applyFilters = true;
        }
        $query = \HawksNestGolf\Db\DbUtils::getQueryString($select, $whereClause, $params, $applyFilters); 
        //echo($query);
        $dbYears = \HawksNestGolf\Db\DbUtils::getQueryData($this->con, $query, true);
        if($dbYears) {
            foreach($dbYears as $dbYear) {
                $years[] = new Year($dbYear);
             }
        }    

        return(isset($years) ? $years : null);
    }

     public function add ($year) {
         $value = $year->year;
         if(!get_magic_quotes_gpc())
            $value = addslashes($value);
         
         $query = "insert into years (year) values ('".$value."')";
        
         //echo ($query);

         return(\HawksNestGolf\Db\DbUtils::insert($this->con, $query));
     }

     public function update ($year) {
         $value = $year->year;
         if(!get_magic_quotes_gpc())
            $value = addslashes($value);
         
        $query = "update years Set ".
                 "year='".$value."',".
                 "where id='".$years->id."'";
       return(\HawksNestGolf\Db\DbUtils::update($this->con, $query));
     }

     public function delete ($id) {
        $query = "Delete from years where id = '".$id."'";
        
        //echo ($query);

        return(\HawksNestGolf\Db\DbUtils::delete($this->con, $query));
      }
}
                          

