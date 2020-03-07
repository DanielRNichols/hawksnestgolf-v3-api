<?php
namespace HawksNestGolf\Resources\Leaderboard;

class LeaderboardController extends \HawksNestGolf\Resources\Base\BaseController {
     
    public function __construct() {
        parent::__construct();
        $this->repositoryHandler = $this->repository->Leaderboard;
    }
    
    public function getModel($params) {
        return null; //new Leaderboard($params);
    }
    
    public function setJsonFile($jsonFile) {
        $this->repositoryHandler->setJsonFile($jsonFile);
    }

//    public function getView($success, $data, $statusCode=null) {
//		return new LeaderboardView($success, $data, $statusCode);
//    }

}


