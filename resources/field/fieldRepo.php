<?php
namespace HawksNestGolf\Resources\Field;

Class FieldRepo extends \HawksNestGolf\Resources\Base\BaseRepo {
    
    public function __construct($dbInstance) {
        parent::__construct($dbInstance->Field);
    }
    
    public function addMultiple($fieldEntries) {
        return $this->dbHandler->addMultiple($fieldEntries);
    }
    
    public function clear() {
        return $this->dbHandler->clear();
    }
}



