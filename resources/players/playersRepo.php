<?php
namespace HawksNestGolf\Resources\Players;

Class PlayersRepo extends \HawksNestGolf\Resources\Base\BaseRepo {
    
    public function __construct($dbInstance) {
        parent::__construct($dbInstance->Players);
    }
}



