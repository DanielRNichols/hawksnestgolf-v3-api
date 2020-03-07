<?php
namespace HawksNestGolf\Resources\Leaderboard;

Class LeaderboardRepo extends \HawksNestGolf\Resources\Base\BaseJsonRepo {
    
    public function __construct() {
    
        $jsonHandler = new LeaderboardJson ();
        //$jsonFile = "https://statdata.pgatour.com/r/011/2019/leaderboard-v2.json";  // TPC 2019
        //$jsonFile = "https://statdata.pgatour.com/r/014/2019/leaderboard-v2.json";  // Masters
        //$jsonFile = "https://statdata.pgatour.com/r/033/2019/leaderboard-v2.json";  // PGA
        //$jsonFile = "https://statdata.pgatour.com/r/026/2019/leaderboard-v2.json";  // US Open        
        //$jsonFile = "https://statdata.pgatour.com/r/100/2019/leaderboard-v2.json";  // British
        //$jsonFile = "https://statdata.pgatour.com/r/060/2019/leaderboard-v2.json";  // TPC
        $jsonFile = 'https://statdata.pgatour.com/r/027/2019/leaderboard-v2.json';  // Northern Trust

        //var_dump($jsonFile);
        
        parent::__construct($jsonHandler, $jsonFile);
    }
}


