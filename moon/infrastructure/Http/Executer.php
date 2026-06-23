<?php

namespace Moon\infrastructure\Http;

use Moon\infrastructure\DI\ServiceContainer;
use Moon\infrastructure\Http\Route\Route;
use Moon\infrastructure\PathResolver\PathResolver;
use Moon\infrastructure\PathResolver\PathDirectoryType;
use Moon\infrastructure\Exception\ControllerException;
use Moon\infrastructure\Http\Response;
use Moon\infrastructure\Http\Route\TypeRoute;

class Executer {

    private PathResolver $pathResolver;
    private Response $response;
    private Request $request;
    private ServiceContainer $container;

    public function __construct(PathResolver $pathResolver, Response $response, Request $request)
    {
        $this->pathResolver = $pathResolver;
        $this->response = $response;
        $this->request = $request;
    }

    public function setContainer(ServiceContainer $container) {
        $this->container = $container;
    }

    public function execRoute(Route $route): Response
    {
        // if($route->type == TypeRoute::NotFound) {
        //     return new Response(template: '404');
        // }
        $controllerName = $this->getController($route);
        $controller = $this->container->get($controllerName);
        $response = $this->callMethodController($route, $controller, $controllerName);
        return $response;
    }

    private function getController(Route $route) {
        $dir = $this->pathResolver->getFileFromDirectoryFramework(PathDirectoryType::Local);

        $controllersDir = $dir . 'Controllers/';

        if (!is_dir($controllersDir))
            throw new ControllerException("Директория контроллеров не найдена: " . $controllersDir);

        $controllerName = $route->controller;
        $controllerFile = $this->getControllerFile($this->pathResolver, $route);

        if (!file_exists($controllerFile))
            throw new ControllerException("Контроллер '{$controllerName}' не найден по пути: {$controllerFile}");

        require $controllerFile;

        if (!class_exists($controllerName))
            throw new ControllerException("Класс контроллера '{$controllerName}' не найден в файле");
        

        return $controllerName;
    }

    private function callMethodController(Route $route, $controller, $controllerName) {
        $methodName = $route->action;
        if (!method_exists($controller, $methodName))
            throw new ControllerException("Метод '{$methodName}' не найден в контроллере '{$controllerName}'");
        
        $response = call_user_func_array([$controller, $methodName], []);
        if ($route->module != null)
            $response->setModule($route->module);

        return $response;
    }

    private function getControllerFile(PathResolver $pathResolver, Route $route): string {
        if($route->module == null)
            $controllersDir = $pathResolver->getFileFromDirectoryFramework(PathDirectoryType::Local, 'Controllers/');
        else
            $controllersDir = $pathResolver->getFileFromDirectoryFramework(PathDirectoryType::Modules, $route->module.'/mvc'.'/Controllers/');
        
        if (!is_dir($controllersDir))
            throw new ControllerException("Директория контроллеров не найдена: " . $controllersDir);

        $controllerName = $route->controller;
        return $controllersDir . $controllerName . '.php';
    }
}