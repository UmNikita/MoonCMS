<?php

namespace Moon\infrastructure\Http;

class Response {

    private int $statusCode;
    private string $template;
    private Headers $headers;

    public function __construct($statusCode = 200, $template = 'Example')
    {
        $this->statusCode = $statusCode;
        $this->template = $template;
        $this->headers = new Headers();
    }

    public function getTemplate(): string
    {
        return $this->template;
    }

    public function setTemplate(string $template) {
        $this->template = $template;
    }

    public function setRedirectUrl(string $url)
    {
        $this->headers->set("Location", $url);
    }

    public function acceptResponseHeaders() {
        foreach ($this->headers->all() as $key => $value) {
            header("$key: $value");
        }
    }
}