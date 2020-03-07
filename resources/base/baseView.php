<?php
namespace HawksNestGolf\Resources\Base;

Class BaseView {

    private $content;
    private $success;
    private $statusCode;
    public function __construct($success, $content, $statusCode=null) {
        $this->success = $success;
        $this->content = $content;
        $this->statusCode = ($statusCode ? $statusCode : ($success ? 200 : 400));

    }

    public function Render ($response) {
        // echo ('in BaseView.Render');
        //var_dump($this);
        if(isset($this->success)) {
            $retBody = json_encode($this->content, JSON_NUMERIC_CHECK);
        }
        else {
            $retBody = 'Error: Unable to retrieve data';
        }

        // header('Content-Type: application/json; charset=utf8');
        // http_response_code($this->statusCode);
        $retRes = $response->withHeader('Content-type', 'application/json')->withStatus($this->statusCode);
        $retRes->write($retBody);

        return $retRes;
    }
}
