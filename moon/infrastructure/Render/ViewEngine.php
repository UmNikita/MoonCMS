<?php

namespace Moon\infrastructure\Render;
use Moon\infrastructure\Http\Response;
use Moon\infrastructure\PathResolver\PathDirectoryType;
use Moon\infrastructure\PathResolver\PathResolver;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class ViewEngine {

    private Environment $twig;
    private PathResolver $pathResolver;

    public function __construct(PathResolver $pathResolver)
    {
        $path = $pathResolver->getFileFromDirectoryFramework(PathDirectoryType::Local, 'Templates');
        $this->pathResolver = $pathResolver;
        $this->setEnviroment();
    }

    public function render(Response $response): void
    {
        $this->setEnviroment($response->getKernelDir());
        $template = $response->getTemplate();
        echo $this->twig->render($template . '.twig', []);
    }

    private function setEnviroment(?string $kernelDir = null) {
        if($kernelDir == null)
            $path = $this->pathResolver->getFileFromDirectoryFramework(PathDirectoryType::Local, 'Templates');
        else
            $path = $this->pathResolver->getFileFromDirectoryFramework(PathDirectoryType::Kernel, 'mvc/'.$kernelDir.'/Templates/');
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