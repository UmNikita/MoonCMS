<?php

namespace Moon\infrastructure\Http;

use Moon\infrastructure\User\Cookie;

class Response {

    private int $statusCode;
    private string $template;
    private Headers $headers;
    private ?string $module = null;
    private Cookie $cookie;

    public function __construct(Cookie $cookie, $statusCode = 200, $template = 'Example')
    {
        $this->statusCode = $statusCode;
        $this->template = $template;
        $this->headers = new Headers();
        $this->cookie = $cookie;
    }

    public function getTemplate()
    {
        return $this->template;
    }

    public function setModule(string $module) {
        $this->module = $module;
    }

    public function getModule(): ?string {
        return $this->module;
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

    public function acceptCookie() {
        foreach ($this->cookie->all() as $key => $value) {
            setcookie($key, $value);
        }
    }
}