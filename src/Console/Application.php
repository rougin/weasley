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
    const VERSION = '0.6.0';

    /**
     * Instantiates the console application.
     *
     * @param string $version
     */
    public function __construct($version = self::VERSION)
    {
        parent::__construct('Weasley', $version);

        $this->add(new Commands\MakeControllerCommand);
        $this->add(new Commands\MakeIntegrationCommand);
        $this->add(new Commands\MakeMiddlewareCommand);
        $this->add(new Commands\MakeValidatorCommand);
    }
}
