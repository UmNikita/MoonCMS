<?php

namespace Moon\infrastructure\Http;
use Moon\infrastructure\Http\Request;
use Moon\infrastructure\Http\Route\Route;
use Moon\infrastructure\Http\Route\TypeRoute;
use Moon\infrastructure\Http\Response;
use Moon\infrastructure\Http\Route\Router;

class HttpEngine {

    private Router $router;
    private Executer $executer;

    public function __construct(Router $router, Executer $executer)
    {
        $this->router = $router;
        $this->executer = $executer;
    }

    public function pipeline(Request $request): Response {
        $route = $this->router->handleRequest($request);
        $response = $this->executer->execRoute($route);
        return $response;
    }
}