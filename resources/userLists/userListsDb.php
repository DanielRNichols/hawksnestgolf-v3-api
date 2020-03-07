<?php
namespace HawksNestGolf\Resources\UserLists;

class UserListsDb {

    private $con;
    public function __construct($con) {
        $this->con = $con;
    }

    public function get ($id=0, $params = null) {
        $select = "Select userLists.id, userLists.playerId, userLists.golferId, userLists.rank, userLists.code
                   from userLists, players, golfers";
        $whereClause = "where userLists.playerId=players.id and userLists.golferId=golfers.id";
        if($id && ($id > 0)) {
            $whereClause = $whereClause." and userLists.id='".$id."'";
            $applyFilters = false;
        } else {
            $applyFilters = true;
        }
        $query = \HawksNestGolf\Db\DbUtils::getQueryString($select, $whereClause, $params, $applyFilters);
        //echo($query);
        $dbUserLists = \HawksNestGolf\Db\DbUtils::getQueryData($this->con, $query, true);
        if($dbUserLists) {
            foreach($dbUserLists as $userListEntry) {
                $userLists[] = new UserList($userListEntry);
             }
        }

        return(isset($userLists) ? $userLists : null);
    }

     public function add ($userListEntry) {

         $query = "insert into userLists (golferId, pgaTourId, odds, oddsRank)
                   values (".
                          "'".$userListEntry->playerId."',".
                          "'".$userListEntry->golferId."',".
                          "'".$userListEntry->rank."',".
                          "'".$userListEntry->code."')";

         //echo ($query);

         return(\HawksNestGolf\Db\DbUtils::insert($this->con, $query));
     }

     public function update ($userListEntry) {

        $query = "update userLists Set ".
               "playerId='".$userListEntry->playerId."',".
               "golferId='".$userListEntry->golferId."',".
               "rank='".$userListEntry->rank."',".
               "code='".$userListEntry->code."' ".
               "where id='".$userListEntry->id."'";

         //echo ($query);
        return(\HawksNestGolf\Db\DbUtils::update($this->con, $query));
     }

     public function delete ($id) {
        $query = "Delete from userLists where id = '".$id."'";

        //echo ($query);

        return(\HawksNestGolf\Db\DbUtils::delete($this->con, $query));

      }
}
