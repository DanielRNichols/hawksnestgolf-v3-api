<?php
namespace HawksNestGolf\Resources\Tournaments;

Class TournamentsRouter extends \HawksNestGolf\Resources\Base\BaseRouter {

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
        $controller = new TournamentsController();
         parent::__construct($controller);
    }

    // Define Get Routes
    public function GetRoutes() {
        $getRoutes['/tournaments'] = function ($request, $response, $args) {
            $thisInstance = self::getInstance();
            $response = $thisInstance->Get($request, $response,  $args);

            return $response;
        };

        $getRoutes['/tournaments/{id}'] = function ($request, $response, $args) {
            $thisInstance = self::getInstance();
            $response = $thisInstance->Get($request, $response,  $args);

            return $response;
        };

        return $getRoutes;
    }

    // Define Post Routes
    public function PostRoutes() {
        $postRoutes['/tournaments'] = function ($request, $response, $args) {
            $thisInstance = self::getInstance();
            //var_dump($thisInstance);
            $response = $thisInstance->Post($request, $response,  $args);
            //var_dump($data);
            return $response;
        };

        return $postRoutes;
    }

    // Define Put Routes
    public function PutRoutes() {
        $putRoutes['/tournaments/{id}'] = function ($request, $response, $args) {
            $thisInstance = self::getInstance();
            //var_dump($thisInstance);
            $response = $thisInstance->Put($request, $response,  $args);
            //var_dump($data);
            return $response;
        };

        return $putRoutes;
    }

    // Define Delete Routes
    public function DeleteRoutes() {
        $deleteRoutes['/tournaments/{id}'] = function ($request, $response, $args) {
            $thisInstance = self::getInstance();
            //var_dump($thisInstance);
            $response = $thisInstance->Delete($request, $response,  $args);
            //var_dump($data);
            return $response;
        };

        return $deleteRoutes;
    }
}
