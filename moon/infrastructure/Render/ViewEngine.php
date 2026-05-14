<?php

namespace Moon\infrastructure\Render;
use Moon\infrastructure\Http\Response;
use Moon\infrastructure\PathResolver\PathDirectoryType;
use Moon\infrastructure\Registry\Container;
use Moon\infrastructure\PathResolver\PathResolver;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class ViewEngine {

    private Environment $twig;

    public function __construct()
    {

    }

    public function render(Response $response): void
    {
        $this->setEnviroment($response->getKernelDir());
        $template = $response->getTemplate();
        echo $this->twig->render($template . '.twig', []);
    }

    private function setEnviroment(?string $kernelDir = null) {
        $pathResolver = Container::get(PathResolver::class);
        if($kernelDir == null)
            $path = $pathResolver->getFileFromDirectoryFramework(PathDirectoryType::Local, 'Templates');
        else
            $path = $pathResolver->getFileFromDirectoryFramework(PathDirectoryType::Kernel, 'mvc/'.$kernelDir.'/Templates/');
        $loader = new FilesystemLoader($path);
        $this->twig = new Environment($loader);
    }

    public function renderError(string $name, string $message) {
        echo $name;
        echo "
        ";
        echo $message;
    }
}