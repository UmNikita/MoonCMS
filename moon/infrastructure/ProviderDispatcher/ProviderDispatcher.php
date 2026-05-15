<?php

namespace Moon\infrastructure\ProviderDispatcher;

use Moon\infrastructure\DI\ServiceContainer;
use Moon\infrastructure\PathResolver\PathResolver;

class ProviderDispatcher {

    private PathResolver $pathResolver;
    private ServiceContainer $serviceContainer;

    public function __construct(PathResolver $pathResolver, ServiceContainer $serviceContainer)
    {
        $this->pathResolver = $pathResolver;
        $this->serviceContainer = $serviceContainer;
    }

    public function boot() {
        $dir = $this->pathResolver->getRoot();
        $providersDir = $dir.'/moon/providers';
        $providers = $this->pathResolver->getListFiles($providersDir);
        foreach ($providers as $provider) {
            $className = pathinfo($provider, PATHINFO_FILENAME);
            
            $fullClassName = '\\Moon\\providers\\' . $className;
            
            if (class_exists($fullClassName)) {
                $instance = $this->serviceContainer->get($fullClassName);
                $instance->run();
            }
        }
    }
}