<?php
namespace HawksNestGolf\Resources\Leaderboard;

require_once(__DIR__."/LeaderboardUtils.php");

class LeaderboardJson {
    
    private $con;
    public function __construct() {
        $this->con = \HawksNestGolf\Db\DbConfig::getConnection();
        if($this->con == null) {
            exit(DbConfig::getConnectionError());
        }
    }

    public function get ($id=0, $params=null, $jsonFile=null) {
        $timestamp = null;
        $fedExCupScoring = false;
         if(isset($params)) {
            $timestamp = isset($params['timestamp']) ? $params['timestamp'] : null;
            $fedExCupScoring = isset($params['fedex']) ? true : false;
        }
        return (getLeaderboard($this->con, $timestamp, $jsonFile, $fedExCupScoring));
    }

}


