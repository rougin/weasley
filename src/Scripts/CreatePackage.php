<?php

namespace Rougin\Weasley\Scripts;

/**
 * Create Package Command
 *
 * @package Weasley
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class CreatePackage extends AbstractMake
{
    /**
     * @var string
     */
    protected $command = 'make:package';

    /**
     * @var string[]
     */
    protected $aliases = array('make:integration');

    /**
     * @var string
     */
    protected $filename = 'Package.stub';

    /**
     * @var string
     */
    protected $message = 'Package created successfully!';

    /**
     * @var string
     */
    protected $namespace = 'App\Packages';

    /**
     * @var string
     */
    protected $path = 'src/Packages';

    /**
     * @var string
     */
    protected $text = 'Create a new Slytherin Integration class';
}
