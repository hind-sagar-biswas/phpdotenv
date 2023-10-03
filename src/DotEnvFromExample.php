<?php

namespace Hindbiswas\Phpdotenv;

use Exception;
use Hindbiswas\Phpdotenv\StdIO;
use Hindbiswas\Phpdotenv\Trait\Parser;
use Hindbiswas\Phpdotenv\Trait\CheckVariable;

class DotEnvFromExample
{
    use Parser;
    use CheckVariable;

    protected ?string $destination = null;
    protected string $source;

    public function from(string $sourceDirectory)
    {
        $envExampleFilePath = rtrim($sourceDirectory, '/') . '/.env.example';

        if (file_exists($envExampleFilePath)) {
            $this->source = $envExampleFilePath;
            if (!$this->destination) $this->destination = rtrim($sourceDirectory, '/') . '/.env';
        } else {
            throw new \Exception('.env.example file not found in the specified directory.');
        }
    }

    public function to(string $destinationDirectory)
    {
        $this->destination = rtrim($destinationDirectory, '/') . '/.env';
    }

    public function put(?array $values = null)
    {
        $parsed_vars = $this->parseFile($this->source);

        if (!$values) $this->cli_mode_loader($parsed_vars);
        else $this->general_loader($parsed_vars, $values);
    }

    protected function cli_mode_loader(array $parsed_vars)
    {
        if (php_sapi_name() !== 'cli') throw new \Exception('If values not provided, Script must run on CLI');
        
        $final = [];
        foreach ($parsed_vars as $key => $value) {
            $var = $this->is_variable_value($value);
            if ($var) $value = StdIO::get("Enter $var");
            $final[$key] = $value;
        }
        $this->save($final);
    }

    protected function general_loader(array $parsed_vars, array $values)
    {
        if (array_is_list($parsed_vars)) throw new Exception('Associated array must be provided!');

        $final = [];
        foreach ($parsed_vars as $key => $value) {
            $var = $this->is_variable_value($value);
            if ($var) $value = $values[$var];
            $final[$key] = $value;
        }
        $this->save($final);
    }

    protected function save(array $variables)
    {
        $file = fopen($this->destination, 'w');

        if ($file) {
            foreach ($variables as $key => $value) {
                $escapedValue = addslashes($value);
                fwrite($file, "{$key}={$escapedValue}" . PHP_EOL);
            }
            fclose($file);
            echo ".env generated to {$this->destination}." . PHP_EOL;
        } else {
            echo "Failed to generate {$this->destination}." . PHP_EOL;
        }
    }
}
