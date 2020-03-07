<?php
namespace HawksNestGolf\Resources\Field;

Class FieldRouter extends \HawksNestGolf\Resources\Base\BaseRouter {

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
        $controller = new FieldController();
         parent::__construct($controller);
    }

    // Define Get Routes
    public function GetRoutes() {
        // NOTE: when $app->get is called, $this is the Slim CONTAINER object, not
        // the current instance of BetsRouter, thus using self::GetInstance()
        $getRoutes['/field'] = function ($request, $response, $args) {
            return self::getInstance()->Get($request, $response,  $args);
        };

        $getRoutes['/field/{id}'] = function ($request, $response, $args) {
            return self::getInstance()->Get($request, $response,  $args);
        };

        return $getRoutes;
    }

    // Define Post Routes
    public function PostRoutes() {
        $postRoutes['/field'] = function ($request, $response, $args) {
            return self::getInstance()->Post($request, $response,  $args);
        };

        $postRoutes['/field/updateFromLeaderboard'] = function ($request, $response, $args) {
            return self::getInstance()->UpdateFromLeaderboard($request, $response);
        };

        return $postRoutes;
    }

    // Define Put Routes
    public function PutRoutes() {
        $putRoutes['/field/{id}'] = function ($request, $response, $args) {
            return self::getInstance()->Put($request, $response,  $args);
        };

        return $putRoutes;
    }

    // Define Delete Routes
    public function DeleteRoutes() {
        $deleteRoutes['/field/{id}'] = function ($request, $response, $args) {
            return self::getInstance()->Delete($request, $response,  $args);
        };

        return $deleteRoutes;
    }
    
    // Handle UpdateFromLeaderboard Route
    private function UpdateFromLeaderboard($request, $response) {
       try {
           $params = $request->getQueryParams();
           $retRes = self::getInstance()->controller->updateFromLeaderboard($params, $response);
       }
        catch (Exception $e) {
            $errMsg = 'Error: Could not update From Leaderboard . Exception: '. $e->getMessage();
            $retRes = $this->createErrorResponse($response, $errMsg, 400);
        }

        return $retRes;
    }
    
 }
