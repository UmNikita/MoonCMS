<?php

namespace Moon\infrastructure\Http;
use Moon\infrastructure\Http\Route\Route;
use Moon\infrastructure\Registry\Container;
use Moon\infrastructure\PathResolver\PathResolver;
use Moon\infrastructure\PathResolver\PathDirectoryType;
use Moon\infrastructure\Exception\ControllerException;
use Moon\infrastructure\Http\Response;

class Executer {
    public function execRoute(Route $route): Response
    {
        $pathResolver = Container::get(PathResolver::class);
        $dir = $pathResolver->getFileFromDirectoryFramework(PathDirectoryType::Local);

        $controllersDir = $dir . 'Controllers/';

        if (!is_dir($controllersDir))
            throw new ControllerException("Директория контроллеров не найдена: " . $controllersDir);

        $controllerName = $route->controller;
        $controllerFile = $controllersDir . $controllerName . '.php';
        if (!file_exists($controllerFile))
            throw new ControllerException("Контроллер '{$controllerName}' не найден по пути: {$controllerFile}");

        require $controllerFile;

        if (!class_exists($controllerName))
            throw new ControllerException("Класс контроллера '{$controllerName}' не найден в файле");
        
        $controller = new $controllerName();

        $methodName = $route->action;
        if (!method_exists($controller, $methodName))
            throw new ControllerException("Метод '{$methodName}' не найден в контроллере '{$controllerName}'");
        
        $response = call_user_func_array([$controller, $methodName], []);
        return $response;
    }
}