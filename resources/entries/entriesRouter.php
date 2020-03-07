<?php
namespace HawksNestGolf\Resources\Entries;

Class EntriesRouter  extends \HawksNestGolf\Resources\Base\BaseRouter {

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
        $controller = new EntriesController();
        parent::__construct($controller);
    }

    // Define Get Routes
    public function GetRoutes() {
        // NOTE: when $app->get is called, $this is the Slim CONTAINER object, not
        // the current instance of BetsRouter, thus using self::GetInstance()
        $getRoutes['/entries'] = function ($request, $response, $args) {
            return self::getInstance()->Get($request, $response,  $args);
        };

        $getRoutes['/entries/{id}'] = function ($request, $response, $args) {
            return self::getInstance()->Get($request, $response,  $args);
        };

        return $getRoutes;
    }

    // Define Post Routes
    public function PostRoutes() {
        $postRoutes['/entries'] = function ($request, $response, $args) {
            return self::getInstance()->Post($request, $response,  $args);
        };

        return $postRoutes;
    }

    // Define Put Routes
    public function PutRoutes() {
        $putRoutes['/entries/{id}'] = function ($request, $response, $args) {
            return self::getInstance()->Put($request, $response,  $args);
        };

        return $putRoutes;
    }

    // Define Delete Routes
    public function DeleteRoutes() {
        $deleteRoutes['/entries/{id}'] = function ($request, $response, $args) {
            return self::getInstance()->Delete($request, $response,  $args);
        };

        return $deleteRoutes;
    }
 }
