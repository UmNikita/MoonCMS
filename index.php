<?php

require __DIR__.'/vendor/autoload.php';

use Moon\Kernel;
use Moon\infrastructure\Exception\ErrorHandler;

try {
    $app = new Kernel();

    $app->run();
}
catch (Throwable $error) {
    $errorHandler = new ErrorHandler();
    $errorHandler->handle($error);
}