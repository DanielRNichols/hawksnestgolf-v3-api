<?php
namespace HawksNestGolf\Resources\Tournaments;

Class TournamentsRepo extends \HawksNestGolf\Resources\Base\BaseRepo {
    
    public function __construct($dbInstance) {
        parent::__construct($dbInstance->Tournaments);
    }
}



