<?php

namespace Rougin\Weasley;

use Symfony\Component\Console\Application;

/**
 * Console Application
 *
 * @package Weasley
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class Console extends Application
{
    const VERSION = '0.7.0';

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
