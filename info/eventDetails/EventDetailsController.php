<?php
namespace HawksNestGolf\Info\EventDetails;

class EventDetailsController extends \HawksNestGolf\Resources\Base\BaseController {

    public function __construct() {
        parent::__construct();
    }


    // Override the get method so that the related objects can be included
    public function get ($eventId, $params, $response=null) {
        $eventDetails = new EventDetails();
        //echo($eventId);
        $this->getEventDetails($eventDetails, $eventId, $params);

//        var_dump($eventDetails);
        if($response) {
            $renderData = $eventDetails;
            $statusCode = $renderData ? 200 : 404;
            return $this->render($response, true, $renderData, $statusCode);
        }

        return $eventDetails;
    }
    
    
    private function getEventDetails($eventDetails, $eventId, $params) {
        // Get all of the events
        $includeEvents = isset($params['includeEvents']) ? $params['includeEvents'] : true;
        if($includeEvents){
            $eventDetails->events = $this->getEvents();
        }
        
        $eventDetails->event = $this->getEvent($eventId);
        
        // Get the results for the given eventId
        $eventDetails->results = $this->getResults($eventId);
        
        // Get the teams for the given eventId
        $includePicks = isset($params['includePicks']) ? $params['includePicks'] : true;
        $eventDetails->teams = $this->getTeams($eventId, $includePicks);
        
        // Get the leaderboard for the given eventId
        $includeLeaderboard = isset($params['includeLeaderboard']) ? $params['includeLeaderboard'] : true;
        if($includeLeaderboard) {
            $leaderboardSize = isset($params['leaderboardSize']) ? $params['leaderboardSize'] : 0;
            $eventDetails->leaderboard = $this->getGolferResults($eventId, $leaderboardSize);
         }
        
        
        return;
    }
    
    private function getEvents() {
        $eventsController = new \HawksNestGolf\Resources\Events\EventsController();
        $tmpParams = [
                      'orderby' => 'events.eventno desc'
                     ];
        return $eventsController->get(null, $tmpParams);
    }
    
    private function getEvent($eventId) {
        $eventsController = new \HawksNestGolf\Resources\Events\EventsController();
        $tmpParams = [
                     ];
        $events = $eventsController->get($eventId, $tmpParams);

        return $events ? $events[0] : null;
    }
    
    private function getResults($eventId) {
        $resultsController = new \HawksNestGolf\Resources\Results\ResultsController();
        $tmpParams = ['filter' => 'eventId='.$eventId,
                      'includeRelated' => true,
                      'includeEvent' => false,
                      'orderby' => 'betId'
                     ];
        return $resultsController->get(null, $tmpParams);
    }
    
    private function getTeams($eventId, $includePicks) {
        $teamsController = new \HawksNestGolf\Resources\Teams\TeamsController();
        $tmpParams = [
                      'orderby' => 'pointTotal desc',
                      'includeRelated' => $includePicks
                     ];
        return $teamsController->get($eventId, $tmpParams);
    }
    
    private function getGolferResults($eventId, $leaderboardSize) {
        $golferResultsController = new \HawksNestGolf\Resources\GolferResults\GolferResultsController();
        $filter = 'eventId='.$eventId;
        if($leaderboardSize > 0) {
            $filter = $filter.' and posVal > 0 and posVal <= '.$leaderboardSize;
        }
        $tmpParams = ['filter' => $filter,
                      'includeEvent' => false,
                      'orderby' => 'points desc'
                     ];
        return $golferResultsController->get(null, $tmpParams);
    }
    
 }
