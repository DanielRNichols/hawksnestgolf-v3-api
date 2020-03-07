<?php
namespace HawksNestGolf\Resources\Years;

Class YearsRepo extends \HawksNestGolf\Resources\Base\BaseRepo {
    
    public function __construct($dbInstance) {
        parent::__construct($dbInstance->Years);
    }
}


