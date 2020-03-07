<?php
namespace HawksNestGolf\Resources\Players;

class PlayersDb {
    
    private $con;
    public function __construct($con) {
        $this->con = $con;
    }
    
    public function get ($id, $params) {
        $select = "Select id, name, userName, email, email2, isAdmin from players";
        if($id && ($id > 0)) {
            $whereClause = "where players.id='".$id."'";
            $applyFilters = false;
        } else {
            $whereClause = null;
            $applyFilters = true;
        }
        $query = \HawksNestGolf\Db\DbUtils::getQueryString($select, $whereClause, $params, $applyFilters); 
        //var_dump($query);
        
        $dbPlayers = \HawksNestGolf\Db\DbUtils::getQueryData($this->con, $query, true);
        if($dbPlayers) {
            foreach($dbPlayers as $dbPlayer) {
                $players[] = new Player($dbPlayer);
                                                              
             }
        }

        return(isset($players) ? $players : null);
    }

     public function add ($player) {
         $name = $player->name;
         $userName = $player->userName;
         $email = $player->email;
         $email2 = $player->email2;
         if(!get_magic_quotes_gpc()) {
            $name = addslashes($name);
            $userName = addslashes($userName);
            $email = addslashes($email);
            $email2 = addslashes($email2);
         }
         $isAdmin = $player->isAdmin ? 1 : 0;
         
         $query = "insert into players (name, username, email, email2, isAdmin ) 
                   values ('".$name."','".$userName."','".$email."','".$email2."','".$isAdmin."')";
         
         //echo ($query);

         return(\HawksNestGolf\Db\DbUtils::insert($this->con, $query));
     }

     public function update ($player) {
         $name = $player->name;
         $userName = $player->userName;
         $email = $player->email;
         $email2 = $player->email2;
         if(!get_magic_quotes_gpc()) {
            $name = addslashes($name);
            $userName = addslashes($userName);
            $email = addslashes($email);
            $email2 = addslashes($email2);
         }
         $isAdmin = $player->isAdmin ? 1 : 0;
         
         $query = "update players Set ".
                   "name='".$name."',".
                   "username='".$userName."',".
                   "email='".$email."',".
                   "email2='".$email2."',".
                   "isAdmin='".$isAdmin."' ".
                   "where id='".$player->id."'";
         
       return(\HawksNestGolf\Db\DbUtils::update($this->con, $query));
     }

     public function delete ($id) {
        $query = "Delete from players where id = '".$id."'";
        
        //echo ($query);

        return(\HawksNestGolf\Db\DbUtils::delete($this->con, $query));
      }
}
                          

