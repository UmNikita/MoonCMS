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
            $protection = false;
            $authVisible = true;
            if(array_key_exists('protection', $routConf)) {
                $protection = $routConf['protection'];
            }
            if(array_key_exists('authVisible', $routConf)) {
                $authVisible = $routConf['authVisible'];
            }
            if(array_key_exists('module', $routConf)) {
                $rout = new Route(controller: $routConf['controller'], action: $routConf['action'], module: $routConf['module'], protection: $protection, authVisible: $authVisible);
            }
            else {
                $rout = new Route(controller: $routConf['controller'], action: $routConf['action'], protection: $protection, authVisible: $authVisible);
            }
        }
        else {
            $rout = new Route(TypeRoute::NotFound);
        }
        return $rout;
    }
}