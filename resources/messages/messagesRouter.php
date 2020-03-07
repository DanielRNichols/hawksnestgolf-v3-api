<?php
namespace HawksNestGolf\Resources\Messages;

Class MessagesRouter  extends \HawksNestGolf\Resources\Base\BaseRouter {

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
        $this->controller = new MessagesController();
         parent::__construct($this->controller);
    }

    // Define Get Routes
    public function GetRoutes() {
        // NOTE: when $app->get is called, $this is the Slim CONTAINER object, not
        // the current instance of BetsRouter, thus using self::GetInstance()
        $getRoutes['/messages'] = function ($request, $response, $args) {
            return self::getInstance()->Get($request, $response,  $args);
        };

        $getRoutes['/messages/{id}'] = function ($request, $response, $args) {
            return self::getInstance()->Get($request, $response,  $args);
        };

        return $getRoutes;
    }

    // Define Post Routes
    public function PostRoutes() {
        $postRoutes['/messages'] = function ($request, $response, $args) {
            return self::getInstance()->Post($request, $response,  $args);
        };

        return $postRoutes;
    }

    // Define Put Routes
    public function PutRoutes() {
        $putRoutes['/messages/{id}'] = function ($request, $response, $args) {
            return self::getInstance()->Put($request, $response,  $args);
        };

        return $putRoutes;
    }

    // Define Delete Routes
    public function DeleteRoutes() {
        $deleteRoutes['/messages/{id}'] = function ($request, $response, $args) {
            return self::getInstance()->Delete($request, $response,  $args);
        };

        return $deleteRoutes;
    }
}
