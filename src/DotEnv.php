<?php

namespace Hindbiswas\Phpdotenv;

use Hindbiswas\Phpdotenv\Trait\Parser;

class DotEnv
{
    use Parser;

    protected $envData = [];
    protected $file;

    public function __construct($directory)
    {
        $envFilePath = rtrim($directory, '/') . '/.env';

        if (file_exists($envFilePath)) {
            $this->file = $envFilePath;
        } else {
            throw new \Exception('.env file not found in the specified directory.');
        }
    }

    public function load()
    {
        $vars = $this->parseFile($this->file);
        foreach ($vars as $key => $value) {
            $this->envData[$key] = $value;
            $_ENV[$key] = $value;
            putenv("$key=$value");
        }
    }

    public function get($key, $default = null)
    {
        return $this->envData[$key] ?? $default;
    }
}
