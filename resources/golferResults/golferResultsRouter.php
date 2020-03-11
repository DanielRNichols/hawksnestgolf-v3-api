<?php
namespace HawksNestGolf\Resources\GolferResults;

Class GolferResultsRouter extends \HawksNestGolf\Resources\Base\BaseRouter {

    private static $instance = null;

    public static function getInstance()
    {
        if (!self::$instance)
        {
        self::$instance = new self();
        }
        return self::$instance;
    }

    private function __clone(){}

    public function __construct() {
            $controller = new GolferResultsController();
             parent::__construct($controller);
        }

    // Define Get Routes
    public function GetRoutes() {
        // NOTE: when $app->get is called, $this is the Slim CONTAINER object, not
        // the current instance of BetsRouter, thus using self::GetInstance()
        $getRoutes['/golferresults'] = function ($request, $response, $args) {
            return self::getInstance()->Get($request, $response,  $args);
        };

        $getRoutes['/golferresults/{id}'] = function ($request, $response, $args) {
            return self::getInstance()->Get($request, $response,  $args);
        };

        $getRoutes['/golferresultsforxls'] = function ($request, $response, $args) {
            return self::getInstance()->GetLeaderboardForXLS($request, $response);
        };

        return $getRoutes;
    }

    // Define Post Routes
    public function PostRoutes() {
        $postRoutes['/golferresults'] = function ($request, $response, $args) {
            return self::getInstance()->Post($request, $response,  $args);
        };

        $postRoutes['/golferresults/updateFromLeaderboard'] = function ($request, $response, $args) {
            return self::getInstance()->UpdateFromLeaderboard($request, $response);
        };

        return $postRoutes;
    }

    // Define Put Routes
    public function PutRoutes() {
        $putRoutes['/golferresults/{id}'] = function ($request, $response, $args) {
            return self::getInstance()->Put($request, $response,  $args);
        };

        return $putRoutes;
    }

    // Define Delete Routes
    public function DeleteRoutes() {
        $deleteRoutes['/golferresults/{id}'] = function ($request, $response, $args) {
            return self::getInstance()->Delete($request, $response,  $args);
        };

        return $deleteRoutes;
    }
    
    
    
    // Handle UpdateFromLeaderboard Route
    private function UpdateFromLeaderboard($request, $response) {
       try {
           //var_dump("In UpdateFromLeaderboard ");
           
           $params = $request->getQueryParams();
           $retRes = self::getInstance()->controller->updateFromLeaderboard($params, $response);
       }
        catch (Exception $e) {
            $errMsg = 'Error: Could not update From Leaderboard . Exception: '. $e->getMessage();
            $retRes = $this->createErrorResponse($response, $errMsg, 400);
        }

        return $retRes;
    }
    
    // Handle Leaderboard1 Route
    private function GetLeaderboardForXLS($request, $response) {
       try {
           //("In GetLeaderboardForXLS ");
           throw new Exception('Aborting');
           $params = $request->getQueryParams();
           $retRes = self::getInstance()->controller->getLeaderboardForXLS($params, $response);
       }
        catch (Exception $e) {
            $errMsg = 'Error: Could not update From Leaderboard . Exception: '. $e->getMessage();
            $retRes = $this->createErrorResponse($response, $errMsg, 400);
        }

        return $retRes;
    }


}
