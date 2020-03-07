<?php
namespace HawksNestGolf\Resources\Selections;

Class SelectionsRepo extends \HawksNestGolf\Resources\Base\BaseRepo {
    
    public function __construct($dbInstance) {
        parent::__construct($dbInstance->Selections);
    }
    
}



