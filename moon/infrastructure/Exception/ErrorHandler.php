<?php

namespace Moon\infrastructure\Exception;

use Throwable;
use Moon\infrastructure\Render\ViewEngine;

class ErrorHandler {
    public function handle(Throwable $error) {
        $viewEngine = new ViewEngine();
        if ($error instanceof MoonExceptions) {
            $head = $error->getHead();
            $message = $error->getMessage();
        } else {
            $head = "Ошибка";
            $message = $error->getMessage();
        }
        $viewEngine->renderError($head, $message);
    }
}