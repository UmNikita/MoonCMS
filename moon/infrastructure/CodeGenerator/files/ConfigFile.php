<?php

namespace Moon\infrastructure\CodeGenerator\files;


class ConfigFile {

    public static function generate(array $config) {
        foreach ($config as $path => $routes) {
            if (isset($routes['module'])) {
                unset($config[$path]);
            }
        }
        $result = self::exportArrayPretty($config);
        $prefix = "<?php\n\n";
        $prefix .= "return ";
        $result = $prefix . $result . ";";
        return $result;
    }

    private static function exportArrayPretty(array $config, int $indent = 0): string {
        $spaces = str_repeat('    ', $indent);
        $result = "[\n";
        
        foreach ($config as $key => $value) {
            if (is_string($key)) {
                $result .= $spaces . "    '" . addslashes($key) . "' => ";
            } else {
                $result .= $spaces . "    " . $key . " => ";
            }
            
            if (is_array($value)) {
                if (empty($value)) {
                    $result .= "[],\n";
                } else {
                    $isList = array_keys($value) === range(0, count($value) - 1);
                    
                    if ($isList && !empty($value)) {
                        $items = [];
                        foreach ($value as $item) {
                            if (is_string($item)) {
                                $items[] = "'" . addslashes($item) . "'";
                            } else {
                                $items[] = $item;
                            }
                        }
                        $result .= "[" . implode(', ', $items) . "],\n";
                    } else {
                        $result .= self::exportArrayPretty($value, $indent) . ",\n";
                    }
                }
            } elseif (is_string($value)) {
                $result .= "'" . addslashes($value) . "',\n";
            } elseif (is_null($value)) {
                $result .= "null,\n";
            } elseif (is_bool($value)) {
                $result .= $value ? "true,\n" : "false,\n";
            } else {
                $result .= $value . ",\n";
            }
        }
        
        $result .= $spaces . "]";
        return $result;
    }

}