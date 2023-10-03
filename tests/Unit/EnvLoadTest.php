<?php

declare(strict_types=1);

use Hindbiswas\Phpdotenv\DotEnv;
use PHPUnit\Framework\TestCase;

final class EnvLoadTest extends TestCase
{
    public function test_dot_env_load()
    {
        $dotEnv = new DotEnv(__DIR__ . '/../../testfiles/dotenvload');
        $dotEnv->load();
        $expected = "env_load_test";
        
        // getenv()
        $this->assertSame($expected, getenv('TEST_NAME'));
        
        // $_ENV[]
        $this->assertSame($expected, $_ENV['TEST_NAME']);
    }
}
