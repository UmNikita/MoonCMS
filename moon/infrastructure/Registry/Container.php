<?php

namespace Moon\infrastructure\Registry;

class Container {
    
    private static array $services = [];

    public static function registry(object $instance) {
        self::$services[get_class($instance)] = $instance;
    }

    public static function get(string $key) {
        if(!isset(self::$services[$key])) {
            die('Not found');
        }
        return self::$services[$key];
    }
}