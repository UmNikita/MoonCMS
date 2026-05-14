<?php

namespace Moon\infrastructure\Http\Route;
use Exception;

class Route {

    readonly ?string $kernelDir;
    readonly ?string $controller;
    readonly ?string $action;
    readonly ?array $args;
    readonly TypeRoute $type;
    readonly ?Exception $exception;
    
    public function __construct(TypeRoute $type=TypeRoute::Success, ?string $kernelDir=null, ?string $controller=null, ?string $action=null, ?array $args=null, ?Exception $exception=null)
    {
        $this->kernelDir = $kernelDir;
        $this->type = $type;
        $this->controller = $controller;
        $this->action = $action;
        $this->args = $args;
        $this->exception = $exception;
    }
}