<?php
namespace HawksNestGolf\Resources\Messages;

class MessagesController extends \HawksNestGolf\Resources\Base\BaseController {

    public function __construct() {
        parent::__construct();
        $this->repositoryHandler = $this->repository->Messages;
        $this->playersController = new \HawksNestGolf\Resources\Players\PlayersController();
    }

    public function getModel($params) {
        return new Message($params);
    }

//    public function getView($success, $data, $statusCode=null) {
//		return new MessagesView($success, $data, $statusCode);
//    }

    // Override the get method so that the related objects can be included
    public function get ($id, $params, $response=null) {
        $messages = parent::get($id, $params);
        if($messages) {
            // Add Player object if desired, default is to include them
            $includeRelated = isset($params['includeRelated']) ? $params['includeRelated'] : true;
            //var_dump($params);
            if($includeRelated) {
               $tmpParams = array('includeRelated' => $includeRelated);
               foreach($messages as $message) {
                    if($message->playerId > 0) {
                        $players = $this->playersController->get($message->playerId, $tmpParams);
                        if($players)
                            $message->player = $players[0];
                    }
                }
            }

        }

         if($response) {
             $renderData = ($id && $messages) ? $messages[0] : $messages;
             $statusCode = $renderData ? 200 : 404;
             return $this->render($response, true, $renderData, $statusCode);
         }

        return $messages;
    }


}
