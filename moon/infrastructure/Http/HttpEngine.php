<?php

namespace Moon\infrastructure\Http;
use Moon\infrastructure\Http\Request;
use Moon\infrastructure\Registry\Container;
use Moon\infrastructure\Http\Route\Route;
use Moon\infrastructure\Http\Route\TypeRoute;
use Moon\infrastructure\Http\Response;

class HttpEngine {

    public function createCurrentRequest(): Request {
        $router = new Request();
        $router->setStatesGlobals();
        return $router;
    }

    public function pipeline(Request $request): Response {
        Container::registry($request);
        $route = $this->makeRoute($request);
        $response = $this->execRoute($route);
        Container::registry($response);
        return $response;
    }

    private function execRoute(Route $route): Response {
        if($route->type == TypeRoute::NotFound) {
            return $this->notFount();
        }
        $executer = new Executer();
        return $executer->execRoute($route);
    }

    private function makeRoute(Request $request): Route {
        $router = new Router();
        return $router->handleRequest($request);
    }

    private function notFount() {
        return new Response(template: '404');
    }
}