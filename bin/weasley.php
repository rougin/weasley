<?php

require 'vendor/autoload.php';

$application = new Symfony\Component\Console\Application;

$application->setName('Weasley');
$application->setVersion('v0.5.0');

$application->add(new Rougin\Weasley\Generator\Commands\MakeControllerCommand);
$application->add(new Rougin\Weasley\Generator\Commands\MakeIntegrationCommand);
$application->add(new Rougin\Weasley\Generator\Commands\MakeMiddlewareCommand);
$application->add(new Rougin\Weasley\Generator\Commands\MakeValidatorCommand);

$application->run();
