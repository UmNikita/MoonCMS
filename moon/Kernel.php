<?php

namespace Moon;

use Moon\infrastructure\Config\ConfigManager;
use Moon\infrastructure\Database\Database;
use Moon\infrastructure\Http\HttpEngine;
use Moon\infrastructure\DI\ServiceContainer;
use Moon\infrastructure\PathResolver\PathResolver;
use Moon\infrastructure\ProviderDispatcher\ProviderDispatcher;
use Moon\infrastructure\Render\ViewEngine;

class Kernel {

    public function run() {
        $serviceContainer = new ServiceContainer();
        $this->startTechServices($serviceContainer);
        $this->proccessHttp($serviceContainer);
        
    }

    private function startTechServices(ServiceContainer $container) {
        $config = $container->get(ConfigManager::class);
        $config->build();
        //$db = new Database('pgsql', 'localhost', '5432', 'test', 'postgres', 'sap');
        $providerDispatcher = new ProviderDispatcher($container->get(PathResolver::class), $container);
        $providerDispatcher->boot();
    }

    private function proccessHttp(ServiceContainer $container) {
        $httpEngine = $container->get(HttpEngine::class);
        $request = $httpEngine->createCurrentRequest();
        $response = $httpEngine->pipeline($request);
        $viewEngine = $container->get(ViewEngine::class);
        $viewEngine->render($response);
    }
}