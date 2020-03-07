<?php
namespace HawksNestGolf\Routes;

Class RouteConfig
{
    private static $instance = null;
    private $routers = array();

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
        // Add Routers
        $this->AddRouter(\HawksNestGolf\Resources\Bets\BetsRouter::getInstance());
        $this->AddRouter(\HawksNestGolf\Resources\Tournaments\TournamentsRouter::getInstance());
        $this->AddRouter(\HawksNestGolf\Resources\Players\PlayersRouter::getInstance());
        $this->AddRouter(\HawksNestGolf\Resources\Golfers\GolfersRouter::getInstance());
        $this->AddRouter(\HawksNestGolf\Resources\Events\EventsRouter::getInstance());
        $this->AddRouter(\HawksNestGolf\Resources\Field\FieldRouter::getInstance());
        $this->AddRouter(\HawksNestGolf\Resources\Entries\EntriesRouter::getInstance());
        $this->AddRouter(\HawksNestGolf\Resources\Picks\PicksRouter::getInstance());
        $this->AddRouter(\HawksNestGolf\Resources\Results\ResultsRouter::getInstance());
        $this->AddRouter(\HawksNestGolf\Resources\Messages\MessagesRouter::getInstance());
        $this->AddRouter(\HawksNestGolf\Resources\GolferResults\GolferResultsRouter::getInstance());
        $this->AddRouter(\HawksNestGolf\Resources\Selections\SelectionsRouter::getInstance());
        $this->AddRouter(\HawksNestGolf\Resources\SelectionEntries\SelectionEntriesRouter::getInstance());
        $this->AddRouter(\HawksNestGolf\Resources\SelectionPicks\SelectionPicksRouter::getInstance());
        $this->AddRouter(\HawksNestGolf\Resources\UserLists\UserListsRouter::getInstance());
        $this->AddRouter(\HawksNestGolf\Resources\Teams\TeamsRouter::getInstance());
        $this->AddRouter(\HawksNestGolf\Resources\SelectionCfg\SelectionCfgRouter::getInstance());
        $this->AddRouter(\HawksNestGolf\Resources\EventStatus\EventStatusRouter::getInstance());
        $this->AddRouter(\HawksNestGolf\Resources\Years\YearsRouter::getInstance());

        $this->AddRouter(\HawksNestGolf\Resources\Leaderboard\LeaderboardRouter::getInstance());

        $this->AddRouter(\HawksNestGolf\Info\EventDetails\EventDetailsRouter::getInstance());

    }


    public function Configure($app) {
        // Add Get Routes
        $getRoutes = $this->GetRoutes();
        if($getRoutes != null) {
            foreach($getRoutes as $routeKey => $routeFunction) {
                $app->get($routeKey, $routeFunction);
                //echo("<br/>".$routeKey);
            }
        }

        // Add Post routes
        $postRoutes = $this->PostRoutes();
        if($postRoutes != null) {
            foreach($postRoutes as $routeKey=>$routeFunction) {
                $app->post($routeKey, $routeFunction);
                //echo("<br/>".$routeKey);
            }
        }

        // Add Put routes
        $putRoutes = $this->PutRoutes();
        if($putRoutes != null) {
            foreach($putRoutes as $routeKey=>$routeFunction) {
                $app->put($routeKey, $routeFunction);
                //echo("<br/>".$routeKey);
            }
        }

        // Add Patch routes
        $patchRoutes = $this->PatchRoutes();
        if($patchRoutes != null) {
            foreach($patchRoutes as $routeKey=>$routeFunction) {
                $app->patch($routeKey, $routeFunction);
                //echo("<br/>".$routeKey);
            }
        }

         // Add Delete Routes
        $deleteRoutes = $this->DeleteRoutes();
        if($deleteRoutes != null) {
            foreach($deleteRoutes as $routeKey=>$routeFunction) {
                $app->delete($routeKey, $routeFunction);
                //echo("<br/>".$routeKey);
            }
        }

    }



    public function AddRouter ($router) {
        array_push($this->routers, $router);
    }

    public function GetRoutes() {
        $getRoutes = array();

        foreach($this->routers as $router) {
            $getRoutes = array_merge($getRoutes, $router->GetRoutes());
        }

        return $getRoutes;
    }

    public function PostRoutes() {
        $postRoutes = array();

        foreach($this->routers as $router) {
            $postRoutes = array_merge($postRoutes, $router->PostRoutes());
        }

        return $postRoutes;
    }

    public function PutRoutes() {
        $putRoutes = array();

        foreach($this->routers as $router) {
            $putRoutes = array_merge($putRoutes, $router->PutRoutes());
        }

        return $putRoutes;
    }

    public function PatchRoutes() {
        $patchRoutes = array();

        foreach($this->routers as $router) {
            $patchRoutes = array_merge($patchRoutes, $router->PatchRoutes());
        }

        return $patchRoutes;
    }

    public function DeleteRoutes() {
        $deleteRoutes = array();

        foreach($this->routers as $router) {
            $deleteRoutes = array_merge($deleteRoutes, $router->DeleteRoutes());
        }

        return $deleteRoutes;

    }


}
