<?php
namespace HawksNestGolf\Resources\SelectionPicks;

class SelectionPicksController extends \HawksNestGolf\Resources\Base\BaseController {
    
    
    public function __construct() {
        parent::__construct();
        $this->repositoryHandler = $this->repository->SelectionPicks;
    }
    
    public function getModel($params) {
        return new SelectionPick($params);
    }
    
//    public function getView($success, $data, $statusCode=null) {
//		return new SelectionPicksView($success, $data, $statusCode);
//    }
}


