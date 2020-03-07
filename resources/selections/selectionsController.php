<?php
namespace HawksNestGolf\Resources\Selections;

class SelectionsController extends \HawksNestGolf\Resources\Base\BaseController {
    
    
    public function __construct() {
        parent::__construct();
        $this->repositoryHandler = $this->repository->Selections;
    }
    
    public function getModel($params) {
        return new Selection($params);
    }
    
//    public function getView($success, $data, $statusCode=null) {
//		return new SelectionsView($success, $data, $statusCode);
//    }
}


