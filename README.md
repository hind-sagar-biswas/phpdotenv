# PHP Dot Env

Small `.env` file loader to load and manage Env variables for PHP project. It also has the functionality to load variables from `.env.example` iteractively

## Installation

To install via composer, run:

```
composer install hindbiswas/phpdotenv
```

## Load Env Variable

```php
<?php
require_once __DIR__ . '/vendor/autoload.php';

use Hindbiswas\Phpdotenv\DotEnv;

$dotEnv = new DotEnv(__DIR__); // Location where .env file exists
$dotEnv->load();

// To access variables
// getenv()
$variable_value = getenv('TEST_NAME');
// $_ENV[]
$variable_value = $_ENV['TEST_NAME'];
```

## Generate from Example file

```php
<?php

use Hindbiswas\Phpdotenv\DotEnvFromExample;

require_once __DIR__ . '/vendor/autoload.php';

$env = new DotEnvFromExample();
$env->from(__DIR__ . '/path/to/example/');
$env->to(__DIR__); // This line is not required if destination an source is same
$env->put();
```

This will create a `.env` following the template of `.env.example` and if there are `{{...}}`, it will treat it as variable and ask for value.
So,

if `.env.example`:

```
HOLA=amigos
OGENKI={{desuka}}
```

Now if the generator file is run: `php generator.php` It'll prompt for the value in place of `{{desuka}}` and use it's value in generated `.env`:

```
Enter the value for `desuka`  
>> 
```

So, putting value `Hai` will generate file:

```.env
HOLA=amigos
OGENKI=Hai
```
