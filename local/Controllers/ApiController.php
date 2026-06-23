<?php

use Moon\infrastructure\Http\RestController;

class ApiController extends RestController {

    public function index() {
        return $this->response(["m"=>"get"]);
    }

    public function post() {
        return $this->response($this->request->getBody());
    }
}