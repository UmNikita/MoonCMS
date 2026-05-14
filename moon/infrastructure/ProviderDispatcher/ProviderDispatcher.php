<?php

namespace Moon\infrastructure\ProviderDispatcher;

use Moon\infrastructure\PathResolver\PathResolver;
use Moon\infrastructure\Registry\Container;

class ProviderDispatcher {

    public function boot() {
        $pathResolver = Container::get(PathResolver::class);
        $dir = $pathResolver->getRoot();
        $providersDir = $dir.'/moon/providers';
        $providers = $pathResolver->getListFiles($providersDir);
        foreach ($providers as $provider) {
            $className = pathinfo($provider, PATHINFO_FILENAME);
            
            $fullClassName = '\\Moon\\providers\\' . $className;
            
            if (class_exists($fullClassName)) {
                $instance = new $fullClassName();
                $instance->run();
            }
        }
    }
}