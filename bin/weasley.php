<?php

// Includes the Composer Autoloader
require realpath('vendor') . '/autoload.php';

if ( ! defined('BLUEPRINT_FILENAME')) {
    define('BLUEPRINT_FILENAME', 'weasley.yml');
}

// Creates a new instance of Blueprint class
$injector = new Auryn\Injector;
$console = new Symfony\Component\Console\Application;
$app = new Rougin\Blueprint\Blueprint($console, $injector);

// Information of the application
$app->console->setName('Weasley');
$app->console->setVersion('0.2.0');

// Adds a "init" command if the file does not exists
if ( ! file_exists(BLUEPRINT_FILENAME)) {
    $command = new Rougin\Weasley\Commands\InitializationCommand;

    $app->console->add($command);

    return $app->run();
}

// Parses the data from a YAML format
$config = Rougin\Weasley\Common\Configuration::get();

// Instantiate League\Filesystem
$adapter = new League\Flysystem\Adapter\Local($config->output);
$filesystem = new League\Flysystem\Filesystem($adapter);

$app->injector->share($filesystem);

$app->setTemplatePath(str_replace('bin', 'src', __DIR__ . '/Templates'))
    ->setCommandPath(str_replace('bin', 'src', __DIR__ . '/Commands'))
    ->setCommandNamespace('Rougin\Weasley\Commands');

$app->injector->delegate('Rougin\Describe\Describe', function () use ($config)
{
    $configuration = $config->database;
    $name = $config->database->driver;

    $driver = new Rougin\Describe\Drivers\DatabaseDriver($name, $configuration);

    return new Rougin\Describe\Describe($driver);
});

// Run the application
$app->run();
