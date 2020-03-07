<?php
namespace HawksNestGolf\Resources\EventStatus;

Class EventStatusRepo extends \HawksNestGolf\Resources\Base\BaseRepo {
    
    public function __construct($dbInstance) {
        parent::__construct($dbInstance->EventStatus);
    }
}


