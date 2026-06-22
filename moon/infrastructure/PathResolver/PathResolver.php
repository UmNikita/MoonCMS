<?php

namespace Moon\infrastructure\PathResolver;

use Moon\infrastructure\PathResolver\PathDirectoryType;
use Moon\infrastructure\Exception\AppIntegrityException;

class PathResolver {

    private string $root;
    private string $public_directory;
    private string $local_directory;
    private string $config_directory;
    private string $kernel_directory;
    private string $modules_directory;

    public function __construct()
    {
        $this->root = dirname(dirname(dirname(__DIR__)));
        $this->public_directory = '/public/';
        $this->local_directory = '/local/';
        $this->config_directory = '/config/';
        $this->kernel_directory = '/moon/';
        $this->modules_directory = '/modules/system/';
        $this->checkIntegrityDirectories();
        
    }

    private function checkIntegrityDirectories() {
        $requiredDirs = ['/config', '/local', '/moon'];
        if(!$this->checkFiles($this->root, $requiredDirs)) {
            throw new AppIntegrityException('Нарушена целостность файлов.');
        }
    }

    public function getRoot(): string {
        return $this->root;
    }

    public function checkFilesWithExtension(string $path, array $list, string $extension='.php') {
        $requiredFiles = array_map(function($dir) use ($extension) {
            return $dir . $extension;
        }, $list);
        return $this->checkFiles($path, $requiredFiles);
    }

    public function checkFiles(string $path, array $list) {
        foreach ($list as $dir) {
            if (!file_exists($path . $dir)) {
                return false;
            }
        }
        return true;
    }

    public function getFileFromDirectoryFramework(PathDirectoryType $type = PathDirectoryType::Local, $root=""): string {
        switch($type) {
            case PathDirectoryType::Public: {
                return $this->root.$this->public_directory.$root;
            };
            case PathDirectoryType::Local: {
                return $this->root.$this->local_directory.$root;
            };
            case PathDirectoryType::Config: {
                return $this->root.$this->config_directory.$root;
            };
            case PathDirectoryType::Kernel: {
                return $this->root.$this->kernel_directory.$root;
            };
             case PathDirectoryType::Modules: {
                return $this->root.$this->modules_directory.$root;
            };
        }
    }

    public function getListFiles(string $directory) {
        $files = scandir($directory);
        $files = array_filter($files, function($file) {
            return $file !== '.' && $file !== '..';
        });
        return array_values($files);
    }
}