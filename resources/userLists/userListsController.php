<?php
namespace HawksNestGolf\Resources\UserLists;

class UserListsController extends \HawksNestGolf\Resources\Base\BaseController {

    public function __construct() {
        parent::__construct();
        $this->repositoryHandler = $this->repository->UserLists;
        $this->playersController = new \HawksNestGolf\Resources\Players\PlayersController();
        $this->golfersController = new \HawksNestGolf\Resources\Golfers\GolfersController();
   }

    public function getModel($params) {
        return new UserList($params);
    }

//    public function getView($success, $data, $statusCode=null) {
//		return new UserListsView($success, $data, $statusCode);
//    }

    // Override the get method so that the related objects can be included
    public function get ($id, $params, $response=null) {
         $userLists = parent::get($id, $params);
        if($userLists) {
            // Add includeGolfer objects if desired, default is to include them
            $includeRelated = isset($params['includeRelated']) ? $params['includeRelated'] : true;
            //var_dump($params);
            if($includeRelated) {
               $tmpParams = array('includeRelated' => $includeRelated);
               foreach($userLists as $userListEntry) {
                   if($userListEntry->playerId > 0) {
                       $players = $this->playersController->get($userListEntry->playerId, $tmpParams);
                       if($players)
                           $userListEntry->player = $players[0];
                   }
                    if($userListEntry->golferId > 0) {
                        $golfers = $this->golfersController->get($userListEntry->golferId, $tmpParams);
                        if($golfers)
                            $userListEntry->golfer = $golfers[0];
                    }
                }
            }
        }
        if($response) {
            $renderData = ($id && $userLists) ? $userLists[0] : $userLists;
            $statusCode = $renderData ? 200 : 404;
            return $this->render($response, true, $renderData, $statusCode);
         }

        return $userLists;
    }


}
