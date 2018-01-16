<?php

namespace Rougin\Weasley\Commands;

/**
 * Make Integration Command
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class MakeIntegrationCommand extends MakeControllerCommand
{
    /**
     * @var string
     */
    protected $command = 'make:integration';

    /**
     * @var string
     */
    protected $filename = 'Integration.stub';

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
    protected $text = 'Create a new integration class';
}
