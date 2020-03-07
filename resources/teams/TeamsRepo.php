<?php
namespace HawksNestGolf\Resources\Teams;

Class TeamsRepo extends \HawksNestGolf\Resources\Base\BaseRepo {
    
    public function __construct($dbInstance) {
        parent::__construct($dbInstance->Teams);
    }
}



