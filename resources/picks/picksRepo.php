<?php
namespace HawksNestGolf\Resources\Picks;

Class PicksRepo extends \HawksNestGolf\Resources\Base\BaseRepo {
    
    public function __construct($dbInstance) {
        parent::__construct($dbInstance->Picks);
    }
}



