<?php
namespace HawksNestGolf\Resources\Base;

Class BaseRepo {
    
    protected $dbHandler = null;
    
    public function __construct($dbHandler) {
        $this->dbHandler = $dbHandler;
    }
    
    public function get ($id, $params) { 
        $items = $this->dbHandler->get($id, $params); 
        return (isset($items) ? $items : null);
    }
    
    public function add ($item) {
        return $this->dbHandler->add($item);
    }
    
    public function update ($item) {
        return $this->dbHandler->update($item);
    }
    
    public function delete ($id) {
        return $this->dbHandler->delete($id);
    }
}


