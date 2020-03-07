<?php
namespace HawksNestGolf\Resources\EventStatus;

class EventStatusController extends \HawksNestGolf\Resources\Base\BaseController {
    
    
    public function __construct() {
        parent::__construct();
        $this->repositoryHandler = $this->repository->EventStatus;
    }
    
    public function getModel($params) {
        return new EventStatus($params);
    }

//    public function getView($success, $data, $statusCode=null) {
//        return new EventStatusView($success, $data, $statusCode);
//    }

}


