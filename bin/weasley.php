<?php

require 'vendor/autoload.php';

$application = new Symfony\Component\Console\Application;

$application->add(new Rougin\Weasley\Commands\MakeControllerCommand);
$application->add(new Rougin\Weasley\Commands\MakeIntegrationCommand);
$application->add(new Rougin\Weasley\Commands\MakeValidatorCommand);
$application->add(new Rougin\Weasley\Commands\MakeViewCommand);

$application->run();
