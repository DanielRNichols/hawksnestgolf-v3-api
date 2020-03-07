<?php
namespace HawksNestGolf\Resources\Golfers;

Class GolfersRouter extends \HawksNestGolf\Resources\Base\BaseRouter {

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
        $controller = new GolfersController();
         parent::__construct($controller);
    }

    // Define Get Routes
    public function GetRoutes() {
        // NOTE: when $app->get is called, $this is the Slim CONTAINER object, not
        // the current instance of BetsRouter, thus using self::GetInstance()
        $getRoutes['/golfers'] = function ($request, $response, $args) {
            return self::getInstance()->Get($request, $response,  $args);
        };

        $getRoutes['/golfers/{id}'] = function ($request, $response, $args) {
            return self::getInstance()->Get($request, $response,  $args);
        };

        $getRoutes['/golfers/json/fedexrankings'] = function ($request, $response, $args) {
            return self::getInstance()->GetFedExRankingsFromJson($request, $response,  $args);
        };
        
        return $getRoutes;
    }

    // Define Post Routes
    public function PostRoutes() {
        $postRoutes['/golfers'] = function ($request, $response, $args) {
            return self::getInstance()->Post($request, $response,  $args);
        };

        return $postRoutes;
    }

    // Define Put Routes
    public function PutRoutes() {
        $putRoutes['/golfers/{id}'] = function ($request, $response, $args) {
            return self::getInstance()->Put($request, $response,  $args);
        };

        return $putRoutes;
    }

    // Define Delete Routes
    public function DeleteRoutes() {
        $deleteRoutes['/golfers/{id}'] = function ($request, $response, $args) {
            return self::getInstance()->Delete($request, $response,  $args);
        };

        return $deleteRoutes;
    }
        // Define Patch Routes - updates
    public function PatchRoutes() {
 
        $patchRoutes['/golfers/rankings'] = function ($request, $response, $args) {
            return self::getInstance()->UpdateRankings($request, $response,  $args);
        };
        
        $patchRoutes['/golfers/worldrankings'] = function ($request, $response, $args) {
            return self::getInstance()->UpdateWorldRankings($request, $response,  $args);
        };
        
        $patchRoutes['/golfers/fedexrankings'] = function ($request, $response, $args) {
            return self::getInstance()->UpdateFedExRankings($request, $response,  $args);
        };
        
        $patchRoutes['/golfers/fromleaderboard'] = function ($request, $response, $args) {
            return self::getInstance()->UpdateFromLeaderboard($request, $response,  $args);
        };
        
        return $patchRoutes;
    }

    
    // Update Rankings
    private function UpdateRankings($request, $response, $args) {
        try {
            $retRes = self::getInstance()->controller->updateRankings($response);
        }
        catch (Exception $e) {
            $errMsg = 'Error: Could not update data. Exception: '. $e->getMessage();
            $retRes = $this->createErrorResponse($response, $errMsg, 400);
        }

        return $retRes;

    }

   // Update World Rankings
    private function UpdateWorldRankings($request, $response, $args) {
        try {
            $retRes = self::getInstance()->controller->updateWorldRankings($response);
        }
        catch (Exception $e) {
            $errMsg = 'Error: Could not update data. Exception: '. $e->getMessage();
            $retRes = $this->createErrorResponse($response, $errMsg, 400);
        }

        return $retRes;

    }

    // Update FedEx Rankings
    private function UpdateFedExRankings($request, $response, $args) {
        try {
            $retRes = self::getInstance()->controller->updateFedExRankings($response);
        }
        catch (Exception $e) {
            $errMsg = 'Error: Could not update data. Exception: '. $e->getMessage();
            $retRes = $this->createErrorResponse($response, $errMsg, 400);
        }

        return $retRes;

    }

    // Update Golfers table from leaderboard. Add new golfers, update existing info
    
    private function UpdateFromLeaderboard($request, $response, $args) {
        try {
            $retRes = self::getInstance()->controller->updateFromLeaderboard($response);
        }
        catch (Exception $e) {
            $errMsg = 'Error: Could not update data. Exception: '. $e->getMessage();
            $retRes = $this->createErrorResponse($response, $errMsg, 400);
        }

        return $retRes;

    }

    // Get FedEx Rankings from pgatour data
    private function GetFedExRankingsFromJson($request, $response, $args) {
        try {
            $retRes = self::getInstance()->controller->GetFedExRankingsFromJson($response);
        }
        catch (Exception $e) {
            $errMsg = 'Error: Could get data. Exception: '. $e->getMessage();
            $retRes = $this->createErrorResponse($response, $errMsg, 400);
        }

        return $retRes;

    }
}
