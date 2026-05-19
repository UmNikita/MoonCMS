<?php

namespace Moon\infrastructure\Http;

use Moon\infrastructure\Render\ViewEngine;

class Environment {

    private Headers $headersRequest;
    private Headers $headersResponse;
    private Request $request;
    private Response $response;
    private ViewEngine $viewEngine;
    
    public function __construct(Request $request, Response $response, ViewEngine $viewEngine)
    {
        $this->request = $request;
        $this->response = $response;
        $this->viewEngine = $viewEngine;
    }

    public function setCurrentEnvironment()
    {
        $headers = [];
        $headers['User-Agent'] = $_SERVER['HTTP_USER_AGENT'];
        $headers['Cookie'] = $_SERVER['HTTP_COOKIE'];
        $this->headersRequest = new Headers($headers);
        $rout = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];
        $query_params = $_GET;
        $this->request->setStates($rout, $method, $query_params, $this->headersRequest, null);
    }

    public function response(Response $response) {
        $this->response->acceptResponseHeaders();
        $this->viewEngine->render($response);
    }

    public function getRequest(): Request {
        return $this->request;
    }
}