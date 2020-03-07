<?php
namespace HawksNestGolf\Resources\SelectionPicks;

Class SelectionPicksRepo extends \HawksNestGolf\Resources\Base\BaseRepo {
    
    public function __construct($dbInstance) {
        parent::__construct($dbInstance->SelectionPicks);
    }
    
}



