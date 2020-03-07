<?php
namespace HawksNestGolf\Resources\SelectionEntries;

class SelectionEntriesController extends \HawksNestGolf\Resources\Base\BaseController {
    
    
    public function __construct() {
        parent::__construct();
        $this->repositoryHandler = $this->repository->SelectionEntries;
    }
    
    public function getModel($params) {
        return new SelectionEntry($params);
    }
    
//    public function getView($success, $data, $statusCode=null) {
//		return new SelectionEntriesView($success, $data, $statusCode);
//    }
    
    // Override the get method so that the related objects can be included
    public function get ($id, $params, $response=null) {
        $entries = parent::get($id, $params);
        if($entries) {
            $this->getRelatedItems($entries, $params);
         }

        if($response) {
            $renderData = ($id && $entries) ? $entries[0] : $entries;
            $statusCode = $renderData ? 200 : 404;
            return $this->render($response, true, $renderData, $statusCode);
        }

        return $entries;
    }
    
    private function getRelatedItems($entries, $params) {
        // Add Related objects if desired, default is to include them
        $includeRelated = isset($params['includeRelated']) ? $params['includeRelated'] : true;
        //var_dump($params);
        if($includeRelated) {
           $playersController = new \HawksNestGolf\Resources\Players\PlayersController();
           foreach($entries as $entry) {
                $entry->player = $this->getPlayer($playersController, $entry->playerId, $params);
            }
        }
        
        return;
    }
    
     private function getPlayer($playersController, $playerId, $params) {
        $player = null;
        $includePlayer = isset($params['includePlayer']) ? $params['includePlayer'] : true;
        if($includePlayer && ($playerId > 0)) {
            $tmpParams = array('includeRelated' => true);
            $players = $playersController->get($playerId, $tmpParams);
            if($players) {
                $player = $players[0];
            }
        }
        
        return $player;
    }
    
    
}


