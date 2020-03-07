<?php
namespace HawksNestGolf\Resources\EventStatus;

class EventStatusDb {
    
    private $con;
    public function __construct($con) {
        $this->con = $con;
    }

    public function get ($id = 0, $params = null) { 
        $select = "Select eventStatus.id, eventStatus.value, eventStatus.status from eventStatus";
        
        if($id && ($id > 0)) {
            $whereClause = "where eventStatus.id='".$id."'";
            $applyFilters = false;
        } else {
            $whereClause = null;
            $applyFilters = true;
        }
        $query = \HawksNestGolf\Db\DbUtils::getQueryString($select, $whereClause, $params, $applyFilters); 
        //echo($query);
        $dbEventStatus = \HawksNestGolf\Db\DbUtils::getQueryData($this->con, $query, true);
        if($dbEventStatus) {
            foreach($dbEventStatus as $dbStatus) {
                $eventStatus[] = new EventStatus($dbStatus);
             }
        }    

        return(isset($eventStatus) ? $eventStatus : null);
    }

     public function add ($eventStatus) {
         $status = $eventStatus->status;
         if(!get_magic_quotes_gpc())
            $status = addslashes($status);
         
         $query = "insert into eventStatus (value, status) values ('".$eventStatus->value."','".$status."')";
        
         //echo ($query);

         return(\HawksNestGolf\Db\DbUtils::insert($this->con, $query));
     }

     public function update ($eventStatus) {
         $status = $eventStatus->status;
         if(!get_magic_quotes_gpc())
            $status = addslashes($status);
         
        $query = "update eventStatus Set ".
                 "value='".$eventStatus->value."',".
                 "status='".$status."' ".
                 "where id='".$eventStatus->id."'";
       return(\HawksNestGolf\Db\DbUtils::update($this->con, $query));
     }

     public function delete ($id) {
        $query = "Delete from eventStatus where id = '".$id."'";
        
        //echo ($query);

        return(\HawksNestGolf\Db\DbUtils::delete($this->con, $query));
      }
}
                          

