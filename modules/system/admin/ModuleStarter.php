<?php

namespace Modules\system\admin;

use Moon\infrastructure\Config\ConfigManager;
use Moon\infrastructure\ModuleDispatcher\Starter;
use Moon\infrastructure\Registry\Container;

class ModuleStarter implements Starter {

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
                'module' => 'admin'
            ]
        ]);
    }

}