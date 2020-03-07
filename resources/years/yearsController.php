<?php
namespace HawksNestGolf\Resources\Years;

class YearsController extends \HawksNestGolf\Resources\Base\BaseController {
    
    
    public function __construct() {
        parent::__construct();
        $this->repositoryHandler = $this->repository->Years;
    }
    
    public function getModel($params) {
        return new Year($params);
    }

//    public function getView($success, $data, $statusCode=null) {
//        return new YearsView($success, $data, $statusCode);
//    }

}


