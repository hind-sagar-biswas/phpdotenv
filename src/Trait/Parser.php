<?php

namespace Hindbiswas\Phpdotenv\Trait;

trait Parser
{
    protected function parseFile($filePath)
    {
        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $vars = [];

        foreach ($lines as $line) {
            if ($this->isComment($line)) {
                continue;
            }

            list($key, $value) = $this->parseLine($line);
            $vars[$key] = $value;
        }

        return $vars;
    }

    protected function parseLine($line)
    {
        list($key, $value) = explode('=', $line, 2);

        $key = trim($key);
        $value = trim($value);

        if ($value && $value[0] === '"' && substr($value, -1) === '"') {
            $value = substr($value, 1, -1);
        }

        return [$key, $value];
    }

    protected function isComment($line)
    {
        return strpos(trim($line), '#') === 0;
    }
}
