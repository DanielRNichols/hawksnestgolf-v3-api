<?php
namespace HawksNestGolf\Resources\Golfers;

class GolfersDb {
    
    private $con;
    public function __construct($con) {
        $this->con = $con;
    }
    
    public function get ($id, $params) {
        $select = "select id, pgaTourId, name, selectionName, country, worldRanking, fedExRanking, fedExPoints, image from golfers ";
        if($id && ($id > 0)) {
            $whereClause = "where golfers.id='".$id."'";
            $applyFilters = false;
        } else {
            $whereClause = null;
            $applyFilters = true;
        }
        $query = \HawksNestGolf\Db\DbUtils::getQueryString($select, $whereClause, $params, $applyFilters); 
        
        $dbGolfers = \HawksNestGolf\Db\DbUtils::getQueryData($this->con, $query, true);
        if($dbGolfers) {
            foreach($dbGolfers as $dbGolfer) {
                $golfers[] = new Golfer($dbGolfer);
                                                              
             }
        }

        return(isset($golfers) ? $golfers : null);
    }

     public function add ($golfer) {
         $name = $golfer->name;
         $selectionName = $golfer->selectionName;
         $country = $golfer->country;
         $image = $golfer->image;
         if(!get_magic_quotes_gpc()) {
            $name = addslashes($name);
            $selectionName = addslashes($selectionName);
            $country = addslashes($country);
            $image = addslashes($image);
         }
         
         $query = "insert into golfers (pgaTourId, name, selectionName, country, worldRanking, fedExRanking, image ) 
                   values ('".$golfer->pgaTourId."','".$name."','".$selectionName."','".$country."','".
                        $golfer->worldRanking."','".$golfer->fedExRanking."','".$image."')";
         
         //echo ($query);

         return(\HawksNestGolf\Db\DbUtils::insert($this->con, $query));
     }

     public function update ($golfer) {
         $name = $golfer->name;
         $selectionName = $golfer->selectionName;
         $country = $golfer->country;
         $image = $golfer->image;
         if(!get_magic_quotes_gpc()) {
            $name = addslashes($name);
            $selectionName = addslashes($selectionName);
            $country = addslashes($country);
            $image = addslashes($image);
         }

         $query = "update golfers Set ".
                   "pgaTourId='".$golfer->pgaTourId."',".
                   "name='".$name."',".
                  "selectionName='".$selectionName."',".
                   "country='".$country."',".
                   "worldRanking='".$golfer->worldRanking."',".
                   "fedExRanking='".$golfer->fedExRanking."',".
                   "image='".$image."' ".
                   "where id='".$golfer->id."'";
         
       return(\HawksNestGolf\Db\DbUtils::update($this->con, $query));
     }

     public function delete ($id) {
        $query = "Delete from golfers where id = '".$id."'";
        
        //echo ($query);

        return(\HawksNestGolf\Db\DbUtils::delete($this->con, $query));
      }
      
      public function updateRankings($worldRankings, $fedExRankings) {
        $golfers = $this->get(0, null);
        //var_dump($golfers);
        $con = $this->con;
        
        //$updateQuery = "";
        $con->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);
        $con->autocommit(FALSE);
        foreach($golfers as $golfer) {
            $worldRank = isset($worldRankings[$golfer->pgaTourId]) ? $worldRankings[$golfer->pgaTourId] : '9999'; 
            $fedExRank = isset($fedExRankings[$golfer->pgaTourId]) ? $fedExRankings[$golfer->pgaTourId]['rank'] : '9999'; 
            $fedExPts = isset($fedExRankings[$golfer->pgaTourId]) ? $fedExRankings[$golfer->pgaTourId]['pts'] : '0'; 
            $updateQuery = "update golfers Set worldRanking='".$worldRank."',fedExRanking='".$fedExRank."',fedExPoints='".$fedExPts."' where id='".$golfer->id."';";
            //var_dump($updateQuery);
            $con->query($updateQuery);
        }
        $con->commit();
        $con->autocommit(TRUE);
        
        return true;
        
      }
      
      public function updateWorldRankings($worldRankings) {
        $golfers = $this->get(0, null);
        //var_dump($golfers);
        $con = $this->con;
        
        //$updateQuery = "";
        $con->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);
        $con->autocommit(FALSE);
        foreach($golfers as $golfer) {
            $wr = isset($worldRankings[$golfer->pgaTourId]) ? $worldRankings[$golfer->pgaTourId] : '9999'; 
            $updateQuery = "update golfers Set worldRanking='".$wr."' where id='".$golfer->id."';";
            //var_dump($updateQuery);
            $con->query($updateQuery);
        }
        $con->commit();
        $con->autocommit(TRUE);
        
        return true;
        
      }
      
      public function updateFedExRankings($fedExRankings) {
        $golfers = $this->get(0, null);
        //var_dump($golfers);
        $con = $this->con;
        
        //$updateQuery = "";
        $con->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);
        $con->autocommit(FALSE);
        foreach($golfers as $golfer) {
            $fedExRank = isset($fedExRankings[$golfer->pgaTourId]) ? $fedExRankings[$golfer->pgaTourId] : '9999'; 
            $updateQuery = "update golfers Set fedExRanking='".$fedExRank."' where id='".$golfer->id."';";
            //var_dump($updateQuery);
            $con->query($updateQuery);
        }
        $con->commit();
        $con->autocommit(TRUE);
        
        return true;
        
      }
      
      public function updateFromLeaderboard($leaderboard) {
        var_dump($leaderboard);
        $golfers = $this->get(0, null);
        //var_dump($golfers);
        $con = $this->con;
        
        //$updateQuery = "";
//        $con->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);
//        $con->autocommit(FALSE);
//        foreach($golfers as $golfer) {
//            $wr = isset($worldRankings[$golfer->pgaTourId]) ? $worldRankings[$golfer->pgaTourId] : '9999'; 
//            $updateQuery = "update golfers Set worldRanking='".$wr."' where id='".$golfer->id."';";
//            //var_dump($updateQuery);
//            $con->query($updateQuery);
//        }
//        $con->commit();
//        $con->autocommit(TRUE);
        
        return true;
        
      }
      
      
}
                          

