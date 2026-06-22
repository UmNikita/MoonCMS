<?php

namespace Moon\infrastructure\Http\Route;

use Moon\infrastructure\Http\Route\Route;
use Moon\infrastructure\Config\ConfigManager;
use Moon\infrastructure\Http\Request;
use Moon\infrastructure\Http\Route\TypeRoute;

class Router {

    private ConfigManager $configManager;

    public function __construct(ConfigManager $configManager)
    {
        $this->configManager = $configManager;
    }

    public function handleRequest(Request $request): Route
    {
        $routConf = $this->configManager->get('routes.'.$request->rout);
        if($routConf) {
            if(array_key_exists('module', $routConf)) {
                $rout = new Route(controller: $routConf['controller'], action: $routConf['action'], module: $routConf['module']);
            }
            else {
                $rout = new Route(controller: $routConf['controller'], action: $routConf['action']);
            }
        }
        else {
            $rout = new Route(TypeRoute::NotFound);
        }
        return $rout;
    }
}