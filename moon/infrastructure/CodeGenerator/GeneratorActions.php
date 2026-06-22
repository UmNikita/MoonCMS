<?php

namespace Moon\infrastructure\CodeGenerator;

class GeneratorActions {

    private Generator $generator;

    public function __construct(Generator $generator)
    {
        $this->generator = $generator;
    }

    public function createPage(string $name, string $route): void {
        $name = lcfirst($name);
        $controller = ucfirst($name) . 'Controller';
        $action = "index";
        $this->generator->addConfigRoutes($route, $controller, $action);
        $this->generator->generateController($controller, $name, $action);
        $this->generator->generateTemplate($name, ucfirst($name));
    }
}