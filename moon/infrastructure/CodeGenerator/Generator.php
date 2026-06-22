<?php

namespace Moon\infrastructure\CodeGenerator;

use Moon\infrastructure\CodeGenerator\files\ConfigFile;
use Moon\infrastructure\CodeGenerator\files\ControllerFile;
use Moon\infrastructure\CodeGenerator\files\TemplateFile;
use Moon\infrastructure\Config\ConfigManager;
use Moon\infrastructure\PathResolver\PathDirectoryType;
use Moon\infrastructure\PathResolver\PathResolver;

class Generator {

    private PathResolver $path;
    private ConfigManager $config;

    public function __construct(PathResolver $path, ConfigManager $config)
    {
        $this->path = $path;
        $this->config = $config;
    }

    public function generateController(string $name, string $template, string $action): void {
        $file = ControllerFile::generate($name, $template, $action);
        $dir = $this->path->getFileFromDirectoryFramework(PathDirectoryType::Local, 'Controllers/');
        if(!$this->path->checkFilesWithExtension($dir, [$name])) {
            $this->path->saveFile($name, $file, $dir);
        }
    }

    public function generateTemplate(string $name, string $content = "Hello World"): void {
        $file = TemplateFile::generate($content);
        $dir = $this->path->getFileFromDirectoryFramework(PathDirectoryType::Local, 'Templates/');
        if(!$this->path->checkFilesWithExtension($dir, [$name], 'twig')) {
            $this->path->saveFile($name, $file, $dir, 'twig');
        }
    }

    public function addConfigRoutes(string $route, string $controller, string $action): void {
        $value = [
            $route => [
                'controller' => $controller,
                'action' => $action
            ]
        ];
        $this->config->add('routes', $value);
        $confStr = $this->config->all()['routes'];
        $content = ConfigFile::generate($confStr);
        $this->path->saveFile('routes', $content, $this->path->getFileFromDirectoryFramework(PathDirectoryType::Config));
    }

}