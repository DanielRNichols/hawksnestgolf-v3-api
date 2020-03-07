<?php
namespace HawksNestGolf\Resources\Entries;

Class EntriesRepo extends \HawksNestGolf\Resources\Base\BaseRepo {
    
    public function __construct($dbInstance) {
        parent::__construct($dbInstance->Entries);
    }
}



