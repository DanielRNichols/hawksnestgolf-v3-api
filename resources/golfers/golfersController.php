<?php
namespace HawksNestGolf\Resources\Golfers;

class GolfersController extends \HawksNestGolf\Resources\Base\BaseController {
    
    public function __construct() {
        parent::__construct();
        $this->repositoryHandler = $this->repository->Golfers;
    }
    
    public function getModel($params) {
        return new Golfer($params);
    }

//    public function getView($success, $data, $statusCode=null) {
//		return new GolfersView($success, $data, $statusCode);
//    }
    
    public function updateRankings($response) {
        $success = true;
        
        $worldRankings = $this->getWorldRankings();
        //var_dump($worldRankings);
        $fedExRankings = $this->getFedExRankings();
        //var_dump($fedExRankings);
   
        $success = $this->repositoryHandler->updateRankings($worldRankings, $fedExRankings);
        
        if($success) {
            $retData = array('result' => "Updated Rankings"); 
            $statusCode = 201;
        }
        else {
            $retData = "Error Updating Rankings";
            $statusCode = 400;
        }
        return $this->render($response, $success, $retData, $statusCode);

    }

    public function updateWorldRankings($response) {
        $success = true;
        
        $worldRankings = $this->getWorldRankings();
        //var_dump($worldRankings);
        
        $success = $this->repositoryHandler->updateWorldRankings($worldRankings);
        
        if($success) {
            $retData = array('result' => "Updated World Rankings"); //$this->get($item->id, array(), false);
            $statusCode = 201;
        }
        else {
            $retData = "Error Updating World Rankings";
            $statusCode = 400;
        }
        return $this->render($response, $success, $retData, $statusCode);

    }

    public function updateFedExRankings($response) {

        $fedExRankings = $this->getFedExRankings();
        //var_dump($fedExRankings);
        
        
        $success = $this->repositoryHandler->updateFedExRankings($fedExRankings);

        if($success) {
            $retData = array('result' => "Updated FedEx Rankings"); //$this->get($item->id, array(), false);
            $statusCode = 201;
        }
        else {
            $retData = "Error Updating FedEx Rankings";
            $statusCode = 400;
        }
        return $this->render($response, $success, $retData, $statusCode);
        
    }
    
    public function updateFromLeaderboard($response) {

        $leaderboardController = new \HawksNestGolf\Resources\Leaderboard\LeaderboardController();
        $leaderboard = $leaderboardController->get(0, null);
        
        $success = $this->repositoryHandler->updateFromLeaderboard($leaderboard);

        if($success) {
            $retData = array('result' => "Updated FedEx Rankings"); //$this->get($item->id, array(), false);
            $statusCode = 201;
        }
        else {
            $retData = "Error Updating FedEx Rankings";
            $statusCode = 400;
        }
        return $this->render($response, $success, $retData, $statusCode);
        
    }
    
    
    // might move this to own resource 
    
    function getWorldRankings()
    {
        unset($worldRankings);

        //$url = 'http://www.majorschampionships.com/data/r/stats/current/186.json';
        //$url = 'http://www.pgatour.com/data/r/stats/current/186.json';
        $url = 'https://statdata.pgatour.com/r/stats/2020/186.json';

        //echo('<br>'.$url.'<br>---------------------------------------');
        $jsonData = json_decode(file_get_contents($url), true);

        $jsonWorldRankings = $jsonData["tours"]["0"]["years"]["0"]["stats"]["0"]["details"];
        foreach($jsonWorldRankings as $jsonGolfer)
        {
            $id = $jsonGolfer['plrNum'];
            $wr = $jsonGolfer['curRank'];
            if(!isset($worldRankings) || !isset($worldRankings[$id]))
              $worldRankings[$id] = $wr;
        }

        return($worldRankings);

    }

    public function getFedExRankings()
    {
        unset($fedExRankings);

        //$url = 'http://www.majorschampionships.com/data/r/stats/current/02394.json';
        //$url = 'http://www.pgatour.com/data/r/stats/current/02394.json';
        $url = 'https://statdata.pgatour.com/r/stats/2020/02671.json';

        //echo('<br>'.$url.'<br>---------------------------------------');
        $jsonData = json_decode(file_get_contents($url), true);

        //echo ($lb);
        $jsonWorldRankings = $jsonData["tours"]["0"]["years"]["0"]["stats"]["0"]["details"];
        foreach($jsonWorldRankings as $jsonGolfer)
        {
            $id = $jsonGolfer['plrNum'];
            $name = $jsonGolfer['plrName']['last'];
            $rank = $jsonGolfer['curRank'];
            $pts = $jsonGolfer['statValues']['statValue1'];
            $pts = floatval(str_replace(",","", $pts));
            if(!isset($fedExRankings) || !isset($fedExRankings[$id]))
              $fedExRankings[$id] = array("rank" => $rank, "pts" => $pts, "name" => $name);
        }

        return($fedExRankings);

    }

    public function GetFedExRankingsFromJson($response) {
        
        $fedExRankings = $this->getFedExRankings();
        //var_dump($fedExRankings);

        
        if ($response) {
            return $this->renderGet($response, null, $fedExRankings);
        }

        return $fedExRankings;
 
    }

    
    
}


