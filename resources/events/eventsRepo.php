<?php
namespace HawksNestGolf\Resources\Events;

Class EventsRepo extends \HawksNestGolf\Resources\Base\BaseRepo {
    
    public function __construct($dbInstance) {
        parent::__construct($dbInstance->Events);
    }
}



