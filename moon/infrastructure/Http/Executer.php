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
        $controllerName = $route->controller;
        $controllerFile = $this->getControllerFile($pathResolver, $route);

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
        if ($route->kernelDir != null)
            $response->setKernelDir($route->kernelDir);

        return $response;
    }

    private function getControllerFile(PathResolver $pathResolver, Route $route): string {
        if($route->kernelDir == null)
            $controllersDir = $pathResolver->getFileFromDirectoryFramework(PathDirectoryType::Local, 'Controllers/');
        else
            $controllersDir = $pathResolver->getFileFromDirectoryFramework(PathDirectoryType::Kernel, 'mvc/'.$route->kernelDir.'/Controllers/');
        
        if (!is_dir($controllersDir))
            throw new ControllerException("Директория контроллеров не найдена: " . $controllersDir);

        $controllerName = $route->controller;
        return $controllersDir . $controllerName . '.php';
    }
}