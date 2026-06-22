<?php

namespace Moon\infrastructure\ModuleDispatcher;

use Moon\infrastructure\DI\ServiceContainer;
use Moon\infrastructure\PathResolver\PathResolver;
use ReflectionClass;

class ModuleDispatcher {

    private PathResolver $pathResolver;
    private ServiceContainer $serviceContainer;

    public function __construct(PathResolver $pathResolver, ServiceContainer $serviceContainer)
    {
        $this->pathResolver = $pathResolver;
        $this->serviceContainer = $serviceContainer;
    }

    public function boot() {
        $dir = $this->pathResolver->getRoot();
        $modulesDir = $dir.'/modules/system';
        $modules = $this->pathResolver->getListFiles($modulesDir);
        foreach ($modules as $module) {
            $files = $this->pathResolver->getListFiles($modulesDir.'/'.$module);
            foreach ($files as $file) {
                $className = pathinfo($file, PATHINFO_FILENAME);
                
                $fullClassName = 'Modules\\system\\' . $module . '\\' . $className;

                if (class_exists($fullClassName)) {
                    $reflection = new ReflectionClass($fullClassName);
            
                    if ($reflection->implementsInterface("Moon\\infrastructure\\ModuleDispatcher\\Starter")) {
                        $instance = $this->serviceContainer->get($fullClassName);
                        $instance->run();
                    }
                    break;
                }
            }
        }
    }
}