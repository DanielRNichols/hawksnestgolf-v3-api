<?php
namespace HawksNestGolf\Resources\SelectionCfg;

class SelectionCfgController extends \HawksNestGolf\Resources\Base\BaseController {
    
    
    public function __construct() {
        parent::__construct();
        $this->repositoryHandler = $this->repository->SelectionCfg;
    }
    
    public function getModel($params) {
        return new SelectionCfg($params);
    }

//    public function getView($success, $data, $statusCode=null) {
//		return new SelectionCfgView($success, $data, $statusCode);
//    }
}
