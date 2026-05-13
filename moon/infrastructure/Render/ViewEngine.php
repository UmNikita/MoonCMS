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
        $pathResolver = Container::get(PathResolver::class);
        $path = $pathResolver->getFileFromDirectoryFramework(PathDirectoryType::Local, 'Templates');
        $loader = new FilesystemLoader($path);
        $this->twig = new Environment($loader);
    }

    public function render(Response $response): void
    {
        $template = $response->getTemplate();
        echo $this->twig->render($template . '.twig', []);
    }

    public function renderError(string $name, string $message) {
        echo $name;
        echo "
        ";
        echo $message;
    }
}