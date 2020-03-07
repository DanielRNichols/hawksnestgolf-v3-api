<?php
namespace HawksNestGolf\Resources\Messages;

class MessagesDb {
    
    private $con;
    public function __construct($con) {
        $this->con = $con;
    }

    public function get ($id = 0, $params = null) { 
        // $select = "Select messages.id, messages.playerId, messages.message
        //            from messages, players";
        // $whereClause = "where messages.playerId=players.id";
        $select = "Select messages.id, messages.playerId, messages.message
                   from messages";
        if($id && ($id > 0)) {
            $whereClause = "where messages.id='".$id."'";
            $applyFilters = false;
        } else {
            $whereClause = null;
            $applyFilters = true;
        }
        $query = \HawksNestGolf\Db\DbUtils::getQueryString($select, $whereClause, $params, $applyFilters); 
        //echo($query);
        $dbMessages = \HawksNestGolf\Db\DbUtils::getQueryData($this->con, $query, true);
        if($dbMessages) {
            foreach($dbMessages as $dbMessage) {
                $messages[] = new Message($dbMessage);
             }
        }    

        return(isset($messages) ? $messages : null);
    }

     public function add ($message) {
         
         $query = "insert into messages (playerId, message) 
                   values (".
                          "'".$message->playerId."',".
                          "'".$message->message."')";
        
         //echo ($query);
            
         return(\HawksNestGolf\Db\DbUtils::insert($this->con, $query));
     }

     public function update ($message) {
         
        $query = "update messages Set ".
               "playerId='".$message->playerId."',".
               "message='".$message->message."' ".
               "where id='".$message->id."'";
 
        return(\HawksNestGolf\Db\DbUtils::update($this->con, $query));
     }

     public function delete ($id) {
        $query = "Delete from messages where id = '".$id."'";
        
        //echo ($query);
         
        return(\HawksNestGolf\Db\DbUtils::delete($this->con, $query));

      }
}
                          

