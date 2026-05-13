<?php

namespace Moon\infrastructure\Http;

class Response {

    private int $statusCode;
    private string $template;
    private array $headers;

    public function __construct($statusCode = 200, $template = 'Example', $headers = [])
    {
        $this->statusCode = $statusCode;
        $this->template = $template;
        $this->headers = $headers;
    }
    public function getTemplate()
    {
        return $this->template;
    }
}