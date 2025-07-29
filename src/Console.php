<?php

namespace Rougin\Weasley;

use Rougin\Weasley\Commands\MakeControllerCommand;
use Rougin\Weasley\Commands\MakeIntegrationCommand;
use Rougin\Weasley\Commands\MakeMiddlewareCommand;
use Rougin\Weasley\Commands\MakeValidatorCommand;
use Rougin\Weasley\Scripts\CreateCheck;
use Rougin\Weasley\Scripts\CreateHandler;
use Rougin\Weasley\Scripts\CreatePackage;
use Rougin\Weasley\Scripts\CreateRoute;
use Symfony\Component\Console\Application;

/**
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Console extends Application
{
    const VERSION = '0.7.1';

    /**
     * @param string $version
     */
    public function __construct($version = self::VERSION)
    {
        parent::__construct('Weasley', $version);

        // Old commands -----------------------
        $this->add(new MakeControllerCommand);
        $this->add(new MakeIntegrationCommand);
        $this->add(new MakeMiddlewareCommand);
        $this->add(new MakeValidatorCommand);
        // ------------------------------------

        // New commands --------------
        $this->add(new CreateCheck);
        $this->add(new CreateHandler);
        $this->add(new CreatePackage);
        $this->add(new CreateRoute);
        // ---------------------------
    }
}
