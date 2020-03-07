<?php
namespace HawksNestGolf\Resources\Picks;

class PicksController extends \HawksNestGolf\Resources\Base\BaseController {

    public function __construct() {
        parent::__construct();
        $this->repositoryHandler = $this->repository->Picks;
     }

    public function getModel($params) {
        return new Pick($params);
    }

//    public function getView($success, $data, $statusCode=null) {
//		return new PicksView($success, $data, $statusCode);
//    }

    // Override the get method so that the related objects can be included
    public function get ($id, $params, $response=null) {
        $picks = parent::get($id, $params);
        if($picks) {
            $this->getRelatedItems($picks, $params);
        }


        if($response) {
            $renderData = ($id && $picks) ? $picks[0] : $picks;
            $statusCode = $renderData ? 200 : 404;
            return $this->render($response, true, $renderData, $statusCode);
        }

        return $picks;
    }
    
    private function getRelatedItems($picks, $params) {
        // Add Related items if desired, default is to include them
        $includeRelated = isset($params['includeRelated']) ? $params['includeRelated'] : true;
        //var_dump($params);
        if($includeRelated) {
            $entriesController = new \HawksNestGolf\Resources\Entries\EntriesController();
            $golfersController = new \HawksNestGolf\Resources\Golfers\GolfersController();
            $golferResultsController = new \HawksNestGolf\Resources\GolferResults\GolferResultsController();
            foreach($picks as $pick) {
               $pick->entry = $this->getEntry($entriesController, $pick->entryId, $params);
               $pick->golfer = $this->getGolfer($golfersController, $pick->golferId, $params);
               $eventId = isset($params['eventId']) ? $params['eventId'] : 0;
               if($eventId == 0) {
                    $eventId = $pick->entry ? $pick->entry->eventId : 0;
               }
               //var_dump($eventId);
               $pick->golferResult = $this->getGolferResult($golferResultsController, $eventId, $pick->golferId, $params);
            }
        }
        
        return;
    }
    
    private function getEntry($entriesController, $entryId, $params) {
        $entry = null;
        $includeEntry = isset($params['includeEntry']) ? $params['includeEntry'] : true;
        if($includeEntry && ($entryId > 0)) {
            $includePlayer = isset($params['includePlayer']) ? $params['includePlayer'] : true;
            $includeEvent = isset($params['includeEvent']) ? $params['includeEvent'] : true;
            $tmpParams = ['includeRelated' => true,
                          'includePlayer' => $includePlayer,
                          'includeEvent' => $includeEvent
                         ];
            $entries = $entriesController->get($entryId, $tmpParams);
            if($entries) {
                $entry = $entries[0];
            }
        }
        
        return $entry;
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
    
    private function getGolferResult($golferResultsController, $eventId, $golferId, $params) {
        $golferResult = null;
        
        $includeGolferResult = isset($params['includeGolferResult']) ? $params['includeGolferResult'] : true;
        if($includeGolferResult && $eventId && $golferId) {
            $filter = 'eventId='.$eventId.' and golferId='.$golferId;

            $tmpParams = ['filter' => $filter,
                          'includeRelated' => false
                         ];
            //var_dump($tmpParams);
            $golferResults = $golferResultsController->get(0, $tmpParams);
            if($golferResults) {
                $golferResult = $golferResults[0];
            }
         }
         
         return $golferResult;
    }
 }
