<?php
namespace HawksNestGolf\Resources\Teams;

class TeamsController extends \HawksNestGolf\Resources\Base\BaseController {

    public function __construct() {
        parent::__construct();
        $this->repositoryHandler = $this->repository->Teams;
    }

    public function getModel($params) {
        return new Team($params);
    }

//    public function getView($success, $data, $statusCode=null) {
//		return new TeamsView($success, $data, $statusCode);
//    }

    // Override the get method so that the related objects can be included
    public function get ($eventId, $params, $response=null) {
        //echo($eventId);
        $teams = parent::get($eventId, $params);
        if($teams) {
            $this->updateTeamPositions($teams);
            $this->getRelatedItems($teams, $eventId, $params);
        }
//        var_dump($teams);
        if($response) {
            $renderData = $teams;
            $statusCode = $renderData ? 200 : 404;
            return $this->render($response, true, $renderData, $statusCode);
        }

        return $teams;
    }
    
    
    private function getRelatedItems($teams, $eventId, $params) {
        // Add Related items if desired, default is to include them
        $includeRelated = isset($params['includeRelated']) ? $params['includeRelated'] : true;
        //var_dump($params);
        if($includeRelated) {
            $picksController = new \HawksNestGolf\Resources\Picks\PicksController();
            foreach($teams as $team) {
               $team->picks = $this->getPicks($picksController, $eventId, $team->entryId, $params);
            }
        }
        
        return;
    }
    
    private function getPicks($picksController, $eventId, $entryId, $params) {
        $picks = null;
        $includePicks = isset($params['includePicks']) ? $params['includePicks'] : true;
        if($includePicks && ($entryId > 0)) {
//            $includeEvent = isset($params['includeEvent']) ? $params['includeEvent'] : true;
            $tmpParams = ['filter' => 'entryId='.$entryId,
                          'eventId' => $eventId,
                          'includeRelated' => true,
                          'includeEntry' => false,
                          'includeEvent' => false
                         ];
            $picks = $picksController->get(null, $tmpParams);
//            var_dump($picks);
        }
        
        return $picks;
     }
     
     private function updateTeamPositions($teams) {
        
        $numTeams = count($teams);
        for ($i = 0; $i < $numTeams; $i++) {
            if(($i > 0) && ($teams[$i]->pointTotal == $teams[$i-1]->pointTotal)) {
                $teams[$i]->position  = $teams[$i-1]->position;
            } else if(($i < ($numTeams - 1)) && ($teams[$i]->pointTotal == $teams[$i+1]->pointTotal)) {
                $teams[$i]->position = 'T'.($i+1);
            } else {
                $teams[$i]->position = $i+1;
            }
        
        }
        
     }
    
    

 }
