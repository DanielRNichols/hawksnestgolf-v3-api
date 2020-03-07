<?php
namespace HawksNestGolf\Resources\Tournaments;

class TournamentsController extends \HawksNestGolf\Resources\Base\BaseController {
    
    
    public function __construct() {
        parent::__construct();
        $this->repositoryHandler = $this->repository->Tournaments;
    }
    
    public function getModel($params) {
        return new Tournament($params);
    }

//    public function getView($success, $data, $statusCode=null) {
//		return new TournamentsView($success, $data, $statusCode);
//    }
}


