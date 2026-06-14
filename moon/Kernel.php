<?php

namespace Moon;

use Moon\infrastructure\Http\Environment;
use Moon\infrastructure\PathResolver\PathResolver;
use Moon\infrastructure\Config\ConfigManager;
use Moon\infrastructure\Database\Database;
use Moon\infrastructure\Database\DatabaseFactory;
use Moon\infrastructure\Database\QueryTable;
use Moon\infrastructure\Database\builder\SQLBuilder;
use Moon\infrastructure\Http\HttpEngine;
use Moon\infrastructure\DI\ServiceContainer;
use Moon\infrastructure\Http\Request;
use Moon\infrastructure\ProviderDispatcher\ProviderDispatcher;
use Moon\infrastructure\Render\ViewEngine;
use Local\Models\TestModel;
use Moon\infrastructure\Database\Migration\MigrationManager;
use Moon\infrastructure\Database\Migration\Schema;
use Moon\infrastructure\User\Cookie;
use Moon\infrastructure\User\Session;
use Moon\infrastructure\User\SessionStorage;
use PSpell\Config;

class Kernel {

    private Environment $environment;

    public function run() {
        if ($_SERVER['REQUEST_URI'] === '/favicon.ico') {
            http_response_code(204);
            return;
        }
        $serviceContainer = new ServiceContainer();
        $this->environment = $serviceContainer->get(Environment::class);
        $this->environment->setCurrentEnvironment();
        $this->startTechServices($serviceContainer);
        $this->proccessHttp($serviceContainer);
    }

    private function startTechServices(ServiceContainer $container) {
        $config = $container->get(ConfigManager::class);
        $config->build();
        $databaseFactory = $container->get(DatabaseFactory::class);
        $databaseFactory->create();
        $providerDispatcher = new ProviderDispatcher($container->get(PathResolver::class), $container);
        $providerDispatcher->boot();
        SessionStorage::init($container);
    }

    private function proccessHttp(ServiceContainer $container) {
        $httpEngine = $container->get(HttpEngine::class);
        $session = $container->get(Session::class);
        print_r($session->body());
        $request = $this->environment->getRequest();
        $response = $httpEngine->pipeline($request);
        SessionStorage::save($container);
        $this->environment->response($response);
    }
}