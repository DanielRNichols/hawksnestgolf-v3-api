<?php
namespace HawksNestGolf\Resources\GolferResults;

Class GolferResultsRepo extends \HawksNestGolf\Resources\Base\BaseRepo {
    
    public function __construct($dbInstance) {
        parent::__construct($dbInstance->GolferResults);
    }
    
    public function addMultiple($golferResults) {
        return $this->dbHandler->addMultiple($golferResults);
    }
}



