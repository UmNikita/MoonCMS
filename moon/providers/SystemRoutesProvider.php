<?php

namespace Moon\providers;

use Moon\infrastructure\Config\ConfigManager;
use Moon\infrastructure\ProviderDispatcher\Provider;
use Moon\infrastructure\Registry\Container;

class SystemRoutesProvider implements Provider {

    public function run()
    {
        $config = Container::get(ConfigManager::class);
        $config->add('routes', [
            '/moon-admin' => [
                'controller' => 'AdminController',
                'action' => 'index',
                'kernelDir' => 'admin'
            ]
        ]);
    }

}