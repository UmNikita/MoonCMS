<?php

namespace Moon;

use Moon\infrastructure\PathResolver\PathResolver;
use Moon\infrastructure\Registry\Container;
use Moon\infrastructure\Config\ConfigManager;
use Moon\infrastructure\Database\Database;
use Moon\infrastructure\Http\HttpEngine;
use Moon\infrastructure\Render\ViewEngine;

class Kernel {

    public function run() {
        $this->startTechServices();
        $this->proccessHttp();
    }

    private function startTechServices() {
        $pathResolver = new PathResolver();
        Container::registry($pathResolver);
        $config = new ConfigManager();
        $config->build();
        Container::registry($config);
        $db = new Database('pgsql', 'localhost', '5432', 'test', 'postgres', 'sap');
        Container::registry($db);
    }

    private function proccessHttp() {
        $httpEngine = new HttpEngine();
        $request = $httpEngine->createCurrentRequest();
        $response = $httpEngine->pipeline($request);
        $viewEngine = new ViewEngine();
        $viewEngine->render($response);
    }
}