<?php

namespace Moon\infrastructure\Http\Route;
use Exception;

class Route {

    readonly ?bool $protection;
    readonly ?bool $authVisible;
    readonly ?string $module;
    readonly ?string $controller;
    readonly ?string $action;
    readonly ?array $args;
    readonly TypeRoute $type;
    readonly ?Exception $exception;
    
    public function __construct(TypeRoute $type=TypeRoute::Success, ?bool $authVisible = true, ?bool $protection = false, ?string $module=null, ?string $controller=null, ?string $action=null, ?array $args=null, ?Exception $exception=null)
    {
        $this->protection = $protection;
        $this->authVisible = $authVisible;
        $this->module = $module;
        $this->type = $type;
        $this->controller = $controller;
        $this->action = $action;
        $this->args = $args;
        $this->exception = $exception;
    }
}