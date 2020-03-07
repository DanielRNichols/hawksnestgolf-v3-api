<?php
namespace HawksNestGolf\Resources\Players;

class PlayersController extends \HawksNestGolf\Resources\Base\BaseController {
    
    
    public function __construct() {
        parent::__construct();
        $this->repositoryHandler = $this->repository->Players;
    }
    
    public function getModel($params) {
        return new Player($params);
    }

//    public function getView($success, $data, $statusCode=null) {
//	return new PlayersView($success, $data, $statusCode);
//    }
}


