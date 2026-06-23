<?php

namespace Modules\system\admin;

use Moon\infrastructure\Config\ConfigManager;
use Moon\infrastructure\ModuleDispatcher\Starter;

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
                'module' => 'admin',
                'protection' => true
            ],
            '/login' => [
                'controller' => 'LoginController',
                'action' => 'index',
                'module' => 'admin',
                'authVisible' => false
            ]
        ]);
        $this->configManager->add('rest', [
            '/login:post' => [
                'controller' => 'LoginApiController',
                'action' => 'login',
                'module' => 'admin'
            ]
        ]);
    }

}