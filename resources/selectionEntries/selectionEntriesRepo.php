<?php
namespace HawksNestGolf\Resources\SelectionEntries;

Class SelectionEntriesRepo extends \HawksNestGolf\Resources\Base\BaseRepo {
    
    public function __construct($dbInstance) {
        parent::__construct($dbInstance->SelectionEntries);
    }
    
}



