<?php

namespace Moon\infrastructure\Http\Route;
use Exception;

class Route {

    readonly ?string $module;
    readonly ?string $controller;
    readonly ?string $action;
    readonly ?array $args;
    readonly TypeRoute $type;
    readonly ?Exception $exception;
    
    public function __construct(TypeRoute $type=TypeRoute::Success, ?string $module=null, ?string $controller=null, ?string $action=null, ?array $args=null, ?Exception $exception=null)
    {
        $this->module = $module;
        $this->type = $type;
        $this->controller = $controller;
        $this->action = $action;
        $this->args = $args;
        $this->exception = $exception;
    }
}