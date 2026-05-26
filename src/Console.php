<?php

namespace Rougin\Weasley;

use Rougin\Blueprint\Blueprint;
use Rougin\Blueprint\Wrapper;
use Rougin\Weasley\Commands\MakeControllerCommand;
use Rougin\Weasley\Commands\MakeIntegrationCommand;
use Rougin\Weasley\Commands\MakeMiddlewareCommand;
use Rougin\Weasley\Commands\MakeValidatorCommand;
use Rougin\Weasley\Scripts\CreateCheck;
use Rougin\Weasley\Scripts\CreateHandler;
use Rougin\Weasley\Scripts\CreatePackage;
use Rougin\Weasley\Scripts\CreateRoute;

/**
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Console extends Blueprint
{
    const VERSION = '0.8.0';

    /**
     * @param string $version
     */
    public function __construct($version = self::VERSION)
    {
        $this->setName('Weasley');

        $this->setVersion($version);
    }

    /**
     * @return \Symfony\Component\Console\Command\Command[]
     */
    protected function getCommands()
    {
        $items = array();

        $rows = array();

        // Old commands (to be removed) -----
        $rows[] = new MakeControllerCommand;
        $rows[] = new MakeIntegrationCommand;
        $rows[] = new MakeMiddlewareCommand;
        $rows[] = new MakeValidatorCommand;
        // ----------------------------------

        $rows[] = new CreateCheck;
        $rows[] = new CreateHandler;
        $rows[] = new CreatePackage;
        $rows[] = new CreateRoute;

        foreach ($rows as $item)
        {
            /** @phpstan-ignore-next-line */
            $items[] = new Wrapper($item);
        }

        /** @phpstan-ignore-next-line */
        return $items;
    }
}
