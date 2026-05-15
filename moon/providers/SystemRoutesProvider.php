<?php

namespace Moon\providers;

use Moon\infrastructure\Config\ConfigManager;
use Moon\infrastructure\ProviderDispatcher\Provider;
use Moon\infrastructure\Registry\Container;

class SystemRoutesProvider implements Provider {

    private ConfigManager $configManager;

    public function __construct(ConfigManager $configManager)
    {
        $this->configManager = $configManager;
    }

    public function run()
    {
        $this->configManager->add('routes', [
            '/moon-admin' => [
                'controller' => 'AdminController',
                'action' => 'index',
                'kernelDir' => 'admin'
            ]
        ]);
    }

}