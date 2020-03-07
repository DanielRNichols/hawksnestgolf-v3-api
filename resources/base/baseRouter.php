<?php
namespace HawksNestGolf\Resources\Base;


Class BaseRouter {

    protected $controller = null;

    public function __construct($controller) {
        $this->controller = $controller;

     }

    // Define Get Routes
    public function GetRoutes() {
        return array();
    }

    // Define Post Routes
    public function PostRoutes() {
        return array();
    }

    // Define Put Routes
    public function PutRoutes() {
        return array();
    }

    // Define Patch Routes
    public function PatchRoutes() {
        return array();
    }

    // Define Delete Routes
    public function DeleteRoutes() {
        return array();
    }


    // Handle Get Routes
    protected function Get($request, $response, $args) {
        //echo ('In BaseRouter.get');
        //var_dump($id);
        //var_dump($args);
        try {
            $id = $args && $args['id'] ? $args['id'] : 0;
            $params = $request->getQueryParams();
            //var_dump($params);
            $retRes = $this->controller->get($id, $params, $response);
            //var_dump($data);
            //return $retRes;
        }
        catch (Exception $e) {
            $errMsg = 'Error: Could not get data. Exception: '. $e->getMessage();
            $retRes = $this->createErrorResponse($response, $errMsg, 400);
        }

        return $retRes;
    }

    // Handle Post Routes
    protected function Post($request, $response, $args) {
       try {
           $params = json_decode($request->getBody());
           $retRes = $this->controller->add($params, $response);
       }
        catch (Exception $e) {
            $errMsg = 'Error: Could not post data. Exception: '. $e->getMessage();
            $retRes = $this->createErrorResponse($response, $errMsg, 400);
        }

        return $retRes;
    }

    // Handle Put Routes
    protected function Put($request, $response, $args) {
        try {
            $id = $args && $args['id'] ? $args['id'] : 0;
            $params = json_decode($request->getBody());
            $params->id = $id;
            $retRes = $this->controller->update($params, $response);
        }
        catch (Exception $e) {
            $errMsg = 'Error: Could not put data. Exception: '. $e->getMessage();
            $retRes = $this->createErrorResponse($response, $errMsg, 400);
        }

        return $retRes;

    }

    // Handle Patch Routes
    protected function Patch($request, $response, $args) {
        try {
            $id = $args && $args['id'] ? $args['id'] : 0;
            $params = json_decode($request->getBody());
            $params->id = $id;
            $retRes = $this->controller->update($params, $response);
        }
        catch (Exception $e) {
            $errMsg = 'Error: Could not patch data. Exception: '. $e->getMessage();
            $retRes = $this->createErrorResponse($response, $errMsg, 400);
        }

        return $retRes;

    }

    // Handle Delete Routes
    protected function Delete($request, $response, $args) {
        try {
            $id = $args && $args['id'] ? $args['id'] : 0;
            $retRes = $this->controller->delete($id, $response);
        }
        catch (Exception $e) {
            $errMsg = 'Error: Could not delete data. Exception: '. $e->getMessage();
            $retRes = $this->createErrorResponse($response, $errMsg, 404);
        }

        return $retRes;
    }

    private function createErrorResponse($response, $errMsg, $statusCode) {
        $retRes = $response->withStatus($statusCode);
        $retRes->getBody->write($errMsg);

        return $retRes;
    }
}
