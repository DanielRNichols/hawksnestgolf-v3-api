<?php
namespace HawksNestGolf\Resources\Events;

class EventsController extends \HawksNestGolf\Resources\Base\BaseController {

    public function __construct() {
        parent::__construct();
        $this->repositoryHandler = $this->repository->Events;
        $this->tournamentsController = new \HawksNestGolf\Resources\Tournaments\TournamentsController();
    }

    public function getModel($params) {
        return new Event($params);
    }

//    public function getView($success, $data, $statusCode=null) {
//		return new EventsView($success, $data, $statusCode);
//    }

    // Override the get method so that the related objects can be included
    public function get ($id, $params, $response=null) {
        $events = parent::get($id, $params);
        if($events) {
            // Add Tournament objects if desired, default is to include them
            $includeRelated = isset($params['includeRelated']) ? $params['includeRelated'] : true;
            //var_dump($params);
            if($includeRelated) {
               $tmpParams = array('includeRelated' => $includeRelated);
               foreach($events as $event) {
                    if($event->tournamentId > 0) {
                        $tournaments = $this->tournamentsController->get($event->tournamentId, $tmpParams);
                        if($tournaments)
                            $event->tournament = $tournaments[0];
                    }
                }
            }

         }

        if($response) {
            $renderData = ($id && $events) ? $events[0] : $events;
            $statusCode = $renderData ? 200 : 404;
            return $this->render($response, true, $renderData, $statusCode);
        }

        return $events;
    }

 }
