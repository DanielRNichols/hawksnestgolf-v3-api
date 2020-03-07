<?php
namespace HawksNestGolf\Resources\Leaderboard;

Class LeaderboardRouter  extends \HawksNestGolf\Resources\Base\BaseRouter {

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
        $controller = new LeaderboardController();
         parent::__construct($controller);
    }

    // Define Get Routes
    public function GetRoutes() {
        // NOTE: when $app->get is called, $this is the Slim CONTAINER object, not
        // the current instance of BetsRouter, thus using self::GetInstance()
        $getRoutes['/leaderboard'] = function ($request, $response, $args) {
            return self::getInstance()->Get($request, $response,  $args);
        };

        return $getRoutes;
    }

 
}
