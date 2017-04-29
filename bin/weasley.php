<?php

require 'vendor/autoload.php';

$application = new Symfony\Component\Console\Application;

$application->setName('Weasley');
$application->setVersion('v0.1.0');

$application->add(new Rougin\Weasley\Commands\MakeControllerCommand);
$application->add(new Rougin\Weasley\Commands\MakeIntegrationCommand);
$application->add(new Rougin\Weasley\Commands\MakeMiddlewareCommand);
$application->add(new Rougin\Weasley\Commands\MakeValidatorCommand);

$application->run();
