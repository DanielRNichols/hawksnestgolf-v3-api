<?php
namespace HawksNestGolf\Resources\Results;

Class ResultsRepo extends \HawksNestGolf\Resources\Base\BaseRepo {
    
    public function __construct($dbInstance) {
        parent::__construct($dbInstance->Results);
    }
}



