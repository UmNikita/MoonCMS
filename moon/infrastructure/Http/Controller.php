<?php

namespace Moon\infrastructure\Http;

use Moon\infrastructure\Http\Response;

class Controller {
    
    protected Response $response;
    protected Request $request;

    public function __construct(Request $request, Response $response)
    {
        $this->response = $response;
    }

    protected function setCookie() {

    }

    protected function setSession() {

    }

    protected function setHeader($key, $value) {

    }

    protected function show(string $template): Response {
        $this->response->setTemplate($template);
        return $this->response;
    }

    protected function redirect(string $url): Response {
        $this->response->setRedirectUrl($url);
        return $this->response;
    }
}