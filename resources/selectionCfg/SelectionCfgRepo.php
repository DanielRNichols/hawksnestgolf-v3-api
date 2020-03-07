<?php
namespace HawksNestGolf\Resources\SelectionCfg;

Class SelectionCfgRepo extends \HawksNestGolf\Resources\Base\BaseRepo {
    
    public function __construct($dbInstance) {
        parent::__construct($dbInstance->SelectionCfg);
    }
}



