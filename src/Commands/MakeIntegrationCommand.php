<?php

namespace Rougin\Weasley\Commands;

use Rougin\Weasley\Scripts\CreatePackage;

/**
 * @deprecated since v0.7, use "Scripts/CreatePackage" instead.
 *
 * Make Integration Command
 *
 * @package Weasley
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class MakeIntegrationCommand extends CreatePackage
{
    /**
     * @var string
     */
    protected $command = 'make:integration';

    /**
     * @var boolean
     */
    protected $deprecated = true;

    /**
     * @var string
     */
    protected $message = 'Integration created successfully!';

    /**
     * @var string
     */
    protected $namespace = 'App\Integrations';

    /**
     * @var string
     */
    protected $path = 'src/Integrations';

    /**
     * @var string
     */
    protected $text = 'Creates a new Slytherin Integration class';
}
