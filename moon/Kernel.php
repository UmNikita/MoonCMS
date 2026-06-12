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
use Moon\infrastructure\Render\ViewEngine;
use Local\Models\TestModel;
use Moon\infrastructure\Database\Migration\MigrationManager;
use Moon\infrastructure\Database\Migration\Schema;

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
        $databaseFactory = $container->get(DatabaseFactory::class);
        $databaseFactory->create();

        // $migrationManager = $container->get(MigrationManager::class);
        // $migrationManager->initMigrations();
        
        //$sqlBuilder = $container->get(SQLBuilder::class);
        //$sql = $sqlBuilder->table('posts');
        //print_r($sql->select(['ab', 'dx'])->limit(5)->distinct()->where('avb', 21, '>')->get());
        //print_r($sql->insert(['ab' => 'dx', 'ag' => 'dx'])->save());
        //print_r($sql->insertMany([['ab' => '1', 'ag' => '2'], ['ag' => '4', 'ab' => '3']])->save());
        //print_r($sql->update(['ab' => '1', 'ag' => '2'])->where('abx', 12)->save());
        //print_r($sql->delete()->where('abx', 12)->save());
    }

    private function proccessHttp(ServiceContainer $container) {
        $httpEngine = $container->get(HttpEngine::class);
        $request = $this->environment->getRequest();
        $response = $httpEngine->pipeline($request);
        $this->environment->response($response);
    }
}