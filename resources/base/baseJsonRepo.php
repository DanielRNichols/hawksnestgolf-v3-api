<?php
namespace HawksNestGolf\Resources\Base;

Class BaseJsonRepo {
    
    protected $jsonHandler = null;
    protected $jsonFile = null;
    
    public function __construct($jsonHandler, $jsonFile) {
        $this->jsonHandler = $jsonHandler;
        $this->jsonFile = $jsonFile;
    }
    
    public function setJsonFile($jsonFile) {
        $this->jsonFile = $jsonFile;
    }
    
    public function get ($id, $params) { 
        $items = $this->jsonHandler->get($id, $params, $this->jsonFile); 
        return (isset($items) ? $items : null);
    }

}
