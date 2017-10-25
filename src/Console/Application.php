<?php

namespace Rougin\Weasley\Console;

/**
 * Console Application
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Application extends \Symfony\Component\Console\Application
{
    /**
     * Instantiates the console application.
     *
     * @param string $version
     */
    public function __construct($version = '0.6.0')
    {
        parent::__construct('Weasley', $version);

        $application->add(new Commands\MakeControllerCommand);
        $application->add(new Commands\MakeIntegrationCommand);
        $application->add(new Commands\MakeMiddlewareCommand);
        $application->add(new Commands\MakeValidatorCommand);
    }
}
