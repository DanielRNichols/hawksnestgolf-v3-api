<?php
namespace HawksNestGolf\Resources\Results;

class ResultsController extends \HawksNestGolf\Resources\Base\BaseController {

    public function __construct() {
        parent::__construct();
        $this->repositoryHandler = $this->repository->Results;
        $this->betsController = new \HawksNestGolf\Resources\Bets\BetsController();
        $this->entriesController = new \HawksNestGolf\Resources\Entries\EntriesController();
     }

    public function getModel($params) {
        return new Result($params);
    }

//    public function getView($success, $data, $statusCode=null) {
//		return new ResultsView($success, $data, $statusCode);
//    }

    // Override the get method so that the related objects can be included
    public function get ($id, $params, $response=null) {
         $results = parent::get($id, $params);
        if($results) {
            // Add Tournament objects if desired, default is to include them
            $includeRelated = isset($params['includeRelated']) ? $params['includeRelated'] : true;
            $includeEvent = isset($params['includeEvent']) ? $params['includeEvent'] : true;
            //var_dump($params);
            if($includeRelated) {
               $tmpParams = ['includeRelated' => $includeRelated,
                             'includeEvent' => $includeEvent
                            ];
               foreach($results as $result) {
                    if($result->betId > 0) {
                        $bets = $this->betsController->get($result->betId, $tmpParams);
                        if($bets)
                            $result->bet = $bets[0];
                    }
                    if($result->entryId > 0) {
                        $entries = $this->entriesController->get($result->entryId, $tmpParams);
                        if($entries)
                            $result->entry = $entries[0];
                    }
                }
            }

         }

        if($response) {
            $renderData = ($id && $results) ? $results[0] : $results;
            $statusCode = $renderData ? 200 : 404;
            return $this->render($response, true, $renderData, $statusCode);
        }

        return $results;
    }

}
