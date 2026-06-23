<?php

namespace Moon\infrastructure\Http;
use Moon\infrastructure\Http\Request;
use Moon\infrastructure\Http\Route\Route;
use Moon\infrastructure\Http\Route\TypeRoute;
use Moon\infrastructure\Http\Response;
use Moon\infrastructure\Http\Route\Router;
use Moon\infrastructure\User\Auth\Login;

class HttpEngine {

    private Router $router;
    private Executer $executer;
    private Login $login;
    private Response $response;

    public function __construct(Router $router, Executer $executer, Login $login, Response $response)
    {
        $this->router = $router;
        $this->executer = $executer;
        $this->login = $login;
        $this->response = $response;
    }

    public function pipeline(Request $request): Response {
        $route = $this->router->handleRequest($request);
        $auth = $this->login->auth();
        if($route->protection) {
            if ($auth) {
                $response = $this->executer->execRoute($route);
                return $response;
            }
            else {
                $this->response->setRedirectUrl('/login');
                return $this->response;
            }
        }
        if(!$route->authVisible) {
            if ($auth) {
                $this->response->setRedirectUrl('/');
                return $this->response;
            }
        }
        $response = $this->executer->execRoute($route);
        return $response;
    }
}