<?php
namespace HawksNestGolf\Resources\Bets;

class BetsDb {
    
    private $con;
    public function __construct($con) {
        $this->con = $con;
    }

    public function get ($id = 0, $params = null) { 
        $select = "Select bets.id, bets.name, bets.defAmount from bets";
        
        if($id && ($id > 0)) {
            $whereClause = "where bets.id='".$id."'";
            $applyFilters = false;
        } else {
            $whereClause = null;
            $applyFilters = true;
        }
        $query = \HawksNestGolf\Db\DbUtils::getQueryString($select, $whereClause, $params, $applyFilters); 
        //echo($query);
        $dbBets = \HawksNestGolf\Db\DbUtils::getQueryData($this->con, $query, true);
        if($dbBets) {
            foreach($dbBets as $dbBet) {
                $bets[] = new Bet($dbBet);
             }
        }    

        return(isset($bets) ? $bets : null);
    }

     public function add ($bet) {
         $name = $bet->name;
         if(!get_magic_quotes_gpc())
            $name = addslashes($name);
         
         $query = "insert into bets (name, defAmount) values ('".$name."','".$bet->defAmount."')";
        
         //echo ($query);

         return(\HawksNestGolf\Db\DbUtils::insert($this->con, $query));
     }

     public function update ($bet) {
        if(!get_magic_quotes_gpc())
            $name = addslashes($bet->name);
         
        $query = "update bets Set ".
                 "name='".$name."',".
                 "defAmount='".$bet->defAmount."' ".
                 "where id='".$bet->id."'";
       return(\HawksNestGolf\Db\DbUtils::update($this->con, $query));
     }

     public function delete ($id) {
        $query = "Delete from bets where id = '".$id."'";
        
        //echo ($query);

        return(\HawksNestGolf\Db\DbUtils::delete($this->con, $query));
      }
}
                          

