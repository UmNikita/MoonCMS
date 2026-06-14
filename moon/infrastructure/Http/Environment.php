<?php

namespace Moon\infrastructure\Http;

use Moon\infrastructure\Render\ViewEngine;
use Moon\infrastructure\User\Cookie;

class Environment {

    private Headers $headersRequest;
    private Headers $headersResponse;
    private Request $request;
    private Response $response;
    private ViewEngine $viewEngine;
    private Cookie $cookie;
    
    public function __construct(Request $request, ViewEngine $viewEngine, Cookie $cookie)
    {
        $this->request = $request;
        $this->viewEngine = $viewEngine;
        $this->cookie = $cookie;
    }

    public function setCurrentEnvironment()
    {
        $headers = [];
        $headers['User-Agent'] = $_SERVER['HTTP_USER_AGENT'];
        $this->headersRequest = new Headers($headers);
        $rout = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];
        $query_params = $_GET;
        $this->request->setStates($rout, $method, $query_params, $this->headersRequest, null);
        $this->cookie->setCookie($_COOKIE);
    }

    public function response(Response $response) {
        $response->acceptResponseHeaders();
        $response->acceptCookie();
        $this->viewEngine->render($response);
    }

    public function getRequest(): Request {
        return $this->request;
    }
}