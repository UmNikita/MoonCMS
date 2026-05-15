<?php

namespace Moon\infrastructure\DI;

use ReflectionClass;

class ServiceContainer {
    
    private array $services;

    private function registry(string $class): object {
        $reflection = new ReflectionClass($class);
        $constructor = $reflection->getConstructor();
        if(!$constructor)
            return new $class();

        $args = [];
        foreach ($constructor->getParameters() as $param) {
            $type = $param->getType();
            if(!$type || $type->isBuiltin()) {
                continue;
            }
            $dependClass = $type->getName();
            $args[] = $this->get($dependClass);
        }
        return $reflection->newInstanceArgs($args);
    }

    public function get(string $class): object {
        if(isset($this->services[$class])) {
            return $this->services[$class];
        }
        $instance = $this->registry($class);
        $this->services[$class] = $instance;
        return $instance;
    }
}