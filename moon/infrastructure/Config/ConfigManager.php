<?php

namespace Moon\infrastructure\Config;
use Moon\infrastructure\PathResolver\PathResolver;
use Moon\infrastructure\Registry\Container;
use Moon\infrastructure\PathResolver\PathDirectoryType;
use Moon\infrastructure\Exception\AppIntegrityException;
use Moon\infrastructure\Exception\ConfigException;

class ConfigManager {

    private array $config;
    private PathResolver $pathResolver;
    
    public function __construct()
    {
        $this->pathResolver = Container::get(PathResolver::class);
        $configPath = $this->pathResolver->getFileFromDirectoryFramework(PathDirectoryType::Config);
        $configList = ['routes'];
        if(!$this->pathResolver->checkFilesWithExtension($configPath, $configList)) {
            throw new AppIntegrityException('Нехватает необходимых конфигурационных файлов.');
        }
    }

    public function build()
    {
        $config = [];
        $dir = $this->pathResolver->getFileFromDirectoryFramework(PathDirectoryType::Config);
        $fileList = $this->pathResolver->getListFiles($dir);
        foreach ($fileList as $file) {
            $nameKey = pathinfo($file, PATHINFO_FILENAME);
            $fullDir = $dir.$file;
            $configElement = require $fullDir;
            if (!is_array($configElement)) {
                throw new ConfigException(
                    "Конфигурационный файл должен возвращать массив. Файл: " . basename($fullDir)
                );
            }
            if (empty($configElement)) {
                throw new ConfigException("Пустой конфигурационный файл " . basename($fullDir));
            }
            $config[$nameKey] = $configElement;
        }
        $this->config = $config;
    }

    private function &resolve(string $path, bool $create = false): mixed
    {
        $keys = explode('.', $path);
        $current = &$this->config;
        
        foreach ($keys as $key) {
            if (!isset($current[$key])) {
                if (!$create) {
                    $null = null;
                    return $null;
                }
                $current[$key] = [];
            }
            $current = &$current[$key];
        }
        
        return $current;
    }
    
    public function get(string $path, $default = null)
    {
        $value = &$this->resolve($path);
        return $value ?? $default;
    }
    
    public function set(string $path, $value): void
    {
        $target = &$this->resolve($path, true);
        $target = $value;
    }
    
    public function has(string $path): bool
    {
        $value = &$this->resolve($path);
        return $value !== null;
    }
    
    public function remove(string $path): bool
    {
        $keys = explode('.', $path);
        $lastKey = array_pop($keys);
        $parentPath = implode('.', $keys);
        
        $parent = &$this->resolve($parentPath);
        
        if (is_array($parent) && isset($parent[$lastKey])) {
            unset($parent[$lastKey]);
            return true;
        }
        
        return false;
    }
    
    public function all(): array
    {
        return $this->config;
    }
}