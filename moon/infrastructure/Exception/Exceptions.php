<?php

namespace Moon\infrastructure\Exception;
use Exception;

class MoonExceptions extends Exception {
    public function getHead(): string {
        return "Ошибка";
    }
};

class AppIntegrityException extends MoonExceptions {
    public function getHead(): string
    {
        return "Ошибка целостности файлов";
    }
}

class ConfigException extends MoonExceptions {
    public function getHead(): string
    {
        return "Ошибка конфигурации";
    }
}

class DatabaseException extends MoonExceptions {
    public function getHead(): string
    {
        return "Ошибка Базы Данных";
    }
}

class ControllerException extends MoonExceptions {
    public function getHead(): string
    {
        return "Ошибка контроллеров";
    }
}