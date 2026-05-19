<?php

namespace Moon\infrastructure\Http;

class Environment {

    private Headers $headersRequest;
    private Request $request;
    
    public function __construct(Request $request)
    {
        $this->request = $request;
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

    public function getRequest(): Request {
        return $this->request;
    }
}