<?php
namespace HawksNestGolf\Resources\GolferResults;

class GolferResultsController extends \HawksNestGolf\Resources\Base\BaseController {

    public function __construct() {
        parent::__construct();
        $this->repositoryHandler = $this->repository->GolferResults;
    }

    public function getModel($params) {
        return new GolferResult($params);
    }

//    public function getView($success, $data, $statusCode=null) {
//		return new GolferResultsView($success, $data, $statusCode);
//    }

    // Override the get method so that the related objects can be included
    public function get ($id, $params, $response=null) {
        $golferResults = parent::get($id, $params);
        if($golferResults) {
            $this->getRelatedItems($golferResults, $params);

        }

        if($response) {
            $renderData = ($id && $golferResults) ? $golferResults[0] : $golferResults;
            $statusCode = $renderData ? 200 : 404;
            return $this->render($response, true, $renderData, $statusCode);
        }

        return $golferResults;
    }
    
    private function getRelatedItems($golferResults, $params) {
        // Add Related objects if desired, default is to include them
        $includeRelated = isset($params['includeRelated']) ? $params['includeRelated'] : true;
        //var_dump($params);
        if($includeRelated) {
           $eventsController = new \HawksNestGolf\Resources\Events\EventsController();
           $golfersController = new \HawksNestGolf\Resources\Golfers\GolfersController();
           $picksController = new \HawksNestGolf\Resources\Picks\PicksController();
           foreach($golferResults as $golferResult) {
                $golferResult->event = $this->getEvent($eventsController, $golferResult->eventId, $params);
                $golferResult->golfer = $this->getGolfer($golfersController, $golferResult->golferId, $params);
                $golferResult->pick = $this->getPick($picksController, $golferResult->eventId, $golferResult->golferId, $params);
            }
        }
        
        return;
    }
    
    private function getEvent($eventsController, $eventId, $params) {
        $event = null;
        $includeEvent = isset($params['includeEvent']) ? $params['includeEvent'] : true;
        if($includeEvent && ($eventId > 0)) {
            $tmpParams = array('includeRelated' => true);
            $events = $eventsController->get($eventId, $tmpParams);
            if($events) {
                $event = $events[0];
            }
        }
        
        return $event;
    }

    private function getGolfer($golfersController, $golferId, $params) {
        $golfer = null;
        $includeGolfer = isset($params['includeGolfer']) ? $params['includeGolfer'] : true;
        if($includeGolfer && ($golferId > 0)) {
            $tmpParams = array('includeRelated' => true);
            $golfers = $golfersController->get($golferId, $tmpParams);
            if($golfers) {
                $golfer = $golfers[0];
            }
        }
        
        return $golfer;
    }
    
    private function getPick($picksController, $eventId, $golferId, $params) {
        $pick = null;
        $includePick = isset($params['includePick']) ? $params['includePick'] : true;
        if($includePick && ($eventId > 0) && ($golferId > 0)) {
            $filter = 'eventId='.$eventId.' and golferId='.$golferId;

            $tmpParams = ['filter' => $filter,
                          'includeRelated' => true,
                          'includeEvent' => false,
                          'includeGolfer' => false,
                          'includeGolferResult' => false
                         ];
            //var_dump($tmpParams);
            $picks = $picksController->get(0, $tmpParams);
            if($picks) {
                $pick = $picks[0];
            }
        }
        
        return $pick;
    }
    
    public function updateFromLeaderboard($params, $response=null) {
        $eventId = isset($params['eventId']) ? $params['eventId'] : 0;
        //var_dump($eventId);
        $lbGolfers = $this->getLeaderboardGolfers($eventId);
        //var_dump($lbGolfers);
        if($lbGolfers) {
            foreach($lbGolfers as $lbGolfer) {
                $posValStr = substr($lbGolfer->pos,0,1) == 'T' ? substr($lbGolfer->pos,1) : $lbGolfer->pos;
                $posVal = intVal($posValStr);
                
                $pos = $lbGolfer->pos == '' ? 
                         ($lbGolfer->status == 'cut' ? 'MC' : strtoupper($lbGolfer->status))
                        : $lbGolfer->pos;
//                $pos = $pos == 'CUT' ? 'MC' : $pos;
                
                $golfer = $this->getGolferIdFromPGATourId($lbGolfer->pgaTourId);
                $golferId = $golfer ? $golfer->id : 0;
                
                $golferResults[] = $this->getModel((object)[
                                      'eventId' => $eventId,
                                      'golferId' => $golferId,
                                      'pgaTourId' => $lbGolfer->pgaTourId,
                                      'position' => $pos,
                                      'posVal' => $posVal,
                                      'points' => $lbGolfer->points,
                                     ]);
            }
            
            //var_dump($golferResults);
            if(isset($golferResults)) {
                $lastId = $this->repositoryHandler->addMultiple($golferResults);
            }
        }
        $retData = array("id" => $lastId);
        $success = ($lastId && ($lastId > 0));
        $statusCode = ($success ? 201 : 400);
        return $this->render($response, $success, $retData, $statusCode);

    }
    
    private function getLeaderboardGolfers($eventId) {
        $eventsController = new \HawksNestGolf\Resources\Events\EventsController();
        $event = $this->getEvent($eventsController, $eventId, null);
        //var_dump($event);
        if($event != null) {
            $jsonFile = $event->url;
            $leaderboardController = new \HawksNestGolf\Resources\Leaderboard\LeaderboardController();
            $leaderboardController->setJsonFile($jsonFile);
            $leaderboard = $leaderboardController->get(null, null, null);
            if($leaderboard) {
                $golfers = isset($leaderboard['golfers']) ? $leaderboard['golfers'] : null;
            }
        }
        
        return isset($golfers) ? $golfers : null;
        
    }
    
    private function getGolferIdFromPGATourId($pgaTourId) {
        $golfersController = new \HawksNestGolf\Resources\Golfers\GolfersController();

        $tmpParams = ['filter' => 'pgaTourId='.$pgaTourId];
        $golfers = $golfersController->get(null, $tmpParams);
        
        return isset($golfers) ? $golfers[0] : null;
        
        
    }
    
    public function getLeaderboardForXLS($params, $response=null) {
        $eventId = isset($params['eventId']) ? $params['eventId'] : 0;
        //var_dump($eventId);
        throw new Exception('Aborting');

        $lbGolfers = $this->getLeaderboardGolfers($eventId);
        //var_dump($lbGolfers);
        if($lbGolfers) {
            foreach($lbGolfers as $lbGolfer) {
                $posValStr = substr($lbGolfer->pos,0,1) == 'T' ? substr($lbGolfer->pos,1) : $lbGolfer->pos;
                $posVal = intVal($posValStr);
                
                $pos = $lbGolfer->pos == '' ? 
                         ($lbGolfer->status == 'cut' ? 'MC' : strtoupper($lbGolfer->status))
                        : $lbGolfer->pos;
                
                //foreach($lbGolfers['rounds'] as $currRound)
                //{
                //    $rounds[$currRound['round_number']] = $currRound['strokes'];
                //}
              
                $results[] = $this->getModel((object)[
                                      'pos' => $pos,
                                      'name' => $lbGolfer->name,
                                      'rounds' => $lbGolfer->rounds,
                                      'points' => $lbGolfer->points,
                                     ]);
            }
            
            //var_dump($results);
        }
        $success = isset($results);
        $retData = ($success ? $results : []);
        $statusCode = ($success ? 200 : 400);
        return $this->render($response, $success, $retData, $statusCode);
//        return $this->renderGet($response, null, $results);

    }
    
}
