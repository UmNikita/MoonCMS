<?php

namespace Moon\infrastructure\CodeGenerator\files;

class TemplateFile {

    public static function generate(string $txt): string {
        $content = "<h1>{$txt}</h1>";
        return $content;
    }

}