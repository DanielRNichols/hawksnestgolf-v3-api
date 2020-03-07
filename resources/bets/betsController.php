<?php
namespace HawksNestGolf\Resources\Bets;

class BetsController extends \HawksNestGolf\Resources\Base\BaseController {
    
    
    public function __construct() {
        parent::__construct();
        $this->repositoryHandler = $this->repository->Bets;
    }
    
    public function getModel($params) {
        return new Bet($params);
    }

//    public function getView($success, $data, $statusCode=null) {
//        return new BetsView($success, $data, $statusCode);
//    }

}


