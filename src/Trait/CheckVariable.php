<?php

namespace Hindbiswas\Phpdotenv\Trait;

trait CheckVariable {
    protected function is_variable_value($str): ?string
    {
        $pattern = '/\{\{(.+?)\}\}/';
        preg_match($pattern, $str, $matches);

        if (isset($matches[1]))  return $matches[1];
        return null;
    }
}