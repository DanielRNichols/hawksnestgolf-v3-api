<?php
namespace HawksNestGolf\Resources\Base;

abstract class BaseController {
    protected $repository = null;
    protected $repositoryHandler = null;

    public function __construct() {
        $this->repository = \HawksNestGolf\Repository\HawksNestRepository::getInstance();
    }

    public function get ($id, $params, $response=null) {
        //echo ('In BaseController.get');
        //var_dump($id);
        //var_dump($params);
        $items = null;
        if($this->repositoryHandler != null)
            $items = $this->repositoryHandler->get($id, $params);

        if ($response) {
            return $this->renderGet($response, $id, $items);
        }

        return $items;

    }

    public function renderGet($response, $id, $items) {
        $renderData = ($id && $items) ? $items[0] : $items;
        $statusCode = $renderData ? 200 : 404;
        return $this->render($response, true, $renderData, $statusCode);
}

    public function add ($params, $response) {
        $item = $this->getModel($params);
        $id = $this->repositoryHandler->add($item);
        $retData = array("id" => $id);
        $success = ($id && ($id > 0));
        $statusCode = ($success ? 201 : 400);
        return $this->render($response, $success, $retData, $statusCode);
    }

    public function update ($params, $response) {
        $item = $this->getModel($params);
        $rowsAffected = $this->repositoryHandler->update($item);
        // Changed update to return -1 if error
        $success = ($rowsAffected >= 0);
        if($success) {
            $retData = $this->get($item->id, array(), false);
            $retData = $retData[0];
            $statusCode = 201;
        }
        else {
            $retData = $item;
            $statusCode = 400;
        }
        return $this->render($response, $success, $retData, $statusCode);
    }

    public function delete ($id, $response) {
        $rowsAffected = $this->repositoryHandler->delete($id);
        $success = ($rowsAffected > 0);
        $retData = array("success" => $success);
        $statusCode = ($success ? 201 : 404);
        return $this->render($response, $success, $retData, $statusCode);
    }

    public function getModel($params) {
        return null;
    }

    public function getView($success, $data, $statusCode) {
        return new BaseView($success, $data, $statusCode);
    }

    public function render($response, $success, $data, $statusCode=null) {
        if($response) {
            $view = $this->getView($success, $data, $statusCode);
            return $view->Render($response);
        }
        
        return $data;
    }



}
