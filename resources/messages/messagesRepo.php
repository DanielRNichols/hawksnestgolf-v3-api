<?php
namespace HawksNestGolf\Resources\Messages;

Class MessagesRepo extends \HawksNestGolf\Resources\Base\BaseRepo {
    
    public function __construct($dbInstance) {
        parent::__construct($dbInstance->Messages);
    }
}



