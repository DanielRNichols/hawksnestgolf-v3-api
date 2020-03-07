<?php
namespace HawksNestGolf\Resources\Bets;

Class BetsRepo extends \HawksNestGolf\Resources\Base\BaseRepo {
    
    public function __construct($dbInstance) {
        parent::__construct($dbInstance->Bets);
    }
}


