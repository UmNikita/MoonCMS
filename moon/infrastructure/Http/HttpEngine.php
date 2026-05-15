<?php

namespace Moon\infrastructure\Http;
use Moon\infrastructure\Http\Request;
use Moon\infrastructure\Http\Route\Route;
use Moon\infrastructure\Http\Route\TypeRoute;
use Moon\infrastructure\Http\Response;

class HttpEngine {

    private Router $router;
    private Executer $executer;

    public function __construct(Router $router, Executer $executer)
    {
        $this->router = $router;
        $this->executer = $executer;
    }

    public function createCurrentRequest(): Request {
        $request = new Request();
        $request->setStatesGlobals();
        return $request;
    }

    public function pipeline(Request $request): Response {
        $route = $this->makeRoute($request);
        $response = $this->execRoute($route);
        return $response;
    }

    private function execRoute(Route $route): Response {
        if($route->type == TypeRoute::NotFound) {
            return $this->notFount();
        }
        return $this->executer->execRoute($route);
    }

    private function makeRoute(Request $request): Route {
        return $this->router->handleRequest($request);
    }

    private function notFount() {
        return new Response(template: '404');
    }
}