<?php
namespace HawksNestGolf\Resources\Field;

class FieldController extends \HawksNestGolf\Resources\Base\BaseController {

    public function __construct() {
        parent::__construct();
        $this->repositoryHandler = $this->repository->Field;
        $this->golfersController = new \HawksNestGolf\Resources\Golfers\GolfersController();
   }

    public function getModel($params) {
        return new FieldEntry($params);
    }
    
    public function clear() {
        return $this->repositoryHandler->clear();
    }

//    public function getView($success, $data, $statusCode=null) {
//		return new FieldView($success, $data, $statusCode);
//    }

    // Override the get method so that the related objects can be included
    public function get ($id, $params, $response=null) {
         $theField = parent::get($id, $params);
        if($theField) {
            // Add includeGolfer objects if desired, default is to include them
            $includeRelated = isset($params['includeRelated']) ? $params['includeRelated'] : true;
            //var_dump($params);
            if($includeRelated) {
               $tmpParams = array('includeRelated' => $includeRelated);
               foreach($theField as $fieldEntry) {
                    if($fieldEntry->golferId > 0) {
                        $golfers = $this->golfersController->get($fieldEntry->golferId, $tmpParams);
                        if($golfers)
                            $fieldEntry->golfer = $golfers[0];
                    }
                }
            }

        }
        if($response) {
            $renderData = ($id && $theField) ? $theField[0] : $theField;
            $statusCode = $renderData ? 200 : 404;
            return $this->render($response, true, $renderData, $statusCode);
         }

        return $theField;
    }
    
    public function updateFromLeaderboard($params, $response=null) {
        $this->clear();
        $eventId = isset($params['eventId']) ? $params['eventId'] : 0;
        $lbGolfers = $this->getLeaderboardGolfers($eventId);
        //var_dump($golfers);
        if($lbGolfers) {
            foreach($lbGolfers as $lbGolfer) {
                $golfer = $this->getGolferIdFromPGATourId($lbGolfer->pgaTourId);
                $golferId = $golfer ? $golfer->id : 0;
                
                if($golferId == 0) {
                    $golfersController = new \HawksNestGolf\Resources\Golfers\GolfersController();
                    $golferParams = (object)[
                                      'pgaTourId' => $lbGolfer->pgaTourId,
                                      'name' => $lbGolfer->name,
                                      'selectionName' => $lbGolfer->selectionName,
                                      'country' => $lbGolfer->country,
                                     ];
//                    var_dump($golferParams);
                    $retData = $golfersController->add($golferParams, null);
                    
                    $golferId = $retData && isset($retData['id']) ? $retData['id'] : 0;
                }
                
                $fieldEntries[] = $this->getModel((object)[
                                      'golferId' => $golferId,
                                      'pgaTourId' => $lbGolfer->pgaTourId,
                                     ]);
            }
            
            //var_dump($fieldEntries);
            if(isset($fieldEntries)) {
                $lastId = $this->repositoryHandler->addMultiple($fieldEntries);
            }
        }
        $retData = array("id" => $lastId);
        $success = ($lastId && ($lastId > 0));
        $statusCode = ($success ? 201 : 400);
        return $this->render($response, $success, $retData, $statusCode);

    }
    
    private function getEvent($eventsController, $eventId, $params) {
        $event = null;
        if($eventId > 0) {
            $tmpParams = array('includeRelated' => true);
            $events = $eventsController->get($eventId, $tmpParams);
            if($events) {
                $event = $events[0];
            }
        }
        
        return $event;
    }

    
    
    private function getLeaderboardGolfers($eventId) {
        $eventsController = new \HawksNestGolf\Resources\Events\EventsController();
        $event = $this->getEvent($eventsController, $eventId, null);
        if($event != null) {
            $jsonFile = $event->tournament->url;
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


}
