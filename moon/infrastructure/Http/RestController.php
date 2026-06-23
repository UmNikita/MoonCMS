<?php

namespace Moon\infrastructure\Http;

use Moon\infrastructure\Http\Response;

class RestController {
    
    protected Response $response;
    protected Request $request;

    public function __construct(Request $request, Response $response)
    {
        $this->response = $response;
        $this->request = $request;
    }

    protected function response(array $body) {
        $this->response->setRestApi();
        $this->response->setBody($body);
        
        return $this->response;
    }
}