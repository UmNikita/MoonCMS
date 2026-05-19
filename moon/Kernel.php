<?php

namespace Moon;

use Moon\infrastructure\Http\Environment;
use Moon\infrastructure\PathResolver\PathResolver;
use Moon\infrastructure\Config\ConfigManager;
use Moon\infrastructure\Database\Database;
use Moon\infrastructure\Http\HttpEngine;
use Moon\infrastructure\DI\ServiceContainer;
use Moon\infrastructure\Http\Request;
use Moon\infrastructure\ProviderDispatcher\ProviderDispatcher;
use Moon\infrastructure\Render\ViewEngine;

class Kernel {

    private Environment $environment;

    public function run() {
        $serviceContainer = new ServiceContainer();
        $this->environment = $serviceContainer->get(Environment::class);
        $this->environment->setCurrentEnvironment();
        $this->startTechServices($serviceContainer);
        $this->proccessHttp($serviceContainer);
        
    }

    private function startTechServices(ServiceContainer $container) {
        $config = $container->get(ConfigManager::class);
        $config->build();
        $providerDispatcher = new ProviderDispatcher($container->get(PathResolver::class), $container);
        $providerDispatcher->boot();
    }

    private function proccessHttp(ServiceContainer $container) {
        $httpEngine = $container->get(HttpEngine::class);
        $request = $this->environment->getRequest();
        $response = $httpEngine->pipeline($request);
        $viewEngine = $container->get(ViewEngine::class);
        $viewEngine->render($response);
    }
}