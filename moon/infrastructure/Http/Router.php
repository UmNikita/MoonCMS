<?php

namespace Moon\infrastructure\Http;
use Moon\infrastructure\Http\Route\Route;
use Moon\infrastructure\Registry\Container;
use Moon\infrastructure\Config\ConfigManager;
use Moon\infrastructure\Http\Route\TypeRoute;

class Router {
    public function handleRequest(Request $request): Route
    {
        $config = Container::get(ConfigManager::class);
        $routConf = $config->get('routes.'.$request->rout);
        
        if($routConf) {
            if(array_key_exists('kernelDir', $routConf)) {
                $rout = new Route(controller: $routConf['controller'], action: $routConf['action'], kernelDir: $routConf['kernelDir']);
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