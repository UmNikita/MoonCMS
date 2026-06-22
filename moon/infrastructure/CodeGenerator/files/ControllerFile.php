<?php

namespace Moon\infrastructure\CodeGenerator\files;

class ControllerFile {

    public static function generate(string $name, string $template, string $action): string {
        $content = "<?php\n\n";
        $content .= "use Moon\infrastructure\Http\Controller;\n\n";
        $content .= "class {$name} extends Controller\n";
        $content .= "{\n";
        $content .= "    public function {$action}()\n";
        $content .= "    {\n";
        $content .= "       return \$this->show('{$template}');\n";
        $content .= "    }\n";
        $content .= "}\n";
        return $content;
    }

}