<?php

namespace Moon\infrastructure\Http;

use Moon\infrastructure\Http\Response;

class Controller {
    
    private Response $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    protected function template(string $template): Response {
        $this->response->setTemplate($template);
        return $this->response;
    }
}