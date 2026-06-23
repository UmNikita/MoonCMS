<?php

namespace Moon\infrastructure\Http;

class Request {

    public string $rout;
    private string $method;
    private array $query_params;
    private Headers $headers;
    private $body = null;

    public function setStates(string $rout, string $method, array $query_params, Headers $headers, $body = null)
    {
        $this->rout = $rout;
        $this->method = $method;
        $this->query_params = $query_params;
        $this->headers = $headers;
        $this->body = $body;
    }

    public function getMethod() { return $this->method; }
    public function getBody() { return $this->body; }
}