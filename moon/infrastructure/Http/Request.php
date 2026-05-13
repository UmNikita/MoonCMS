<?php

namespace Moon\infrastructure\Http;

class Request {

    public string $rout;
    private string $method;
    private array $query_params;
    private array $headers;
    private $body = null;

    public function setStatesGlobals()
    {
        $this->rout = $_SERVER['REQUEST_URI'];
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->query_params = $_GET;
        $this->headers = [1];
        $this->body = null;
    }
}