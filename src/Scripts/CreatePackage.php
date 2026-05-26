<?php

namespace Rougin\Weasley\Scripts;

use Rougin\Classidy\Method;

/**
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class CreatePackage extends AbstractMake
{
    /**
     * @var string
     */
    protected $command = 'make:package';

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
    protected $text = 'Creates a new Slytherin Integration class';

    /**
     * @return \Rougin\Classidy\Classidy
     */
    protected function stub()
    {
        $class = parent::stub();

        // Set the integration interface of the class --------------
        $name = 'Rougin\Slytherin\Integration\IntegrationInterface';

        $class->addInterface($name);
        // ---------------------------------------------------------

        $method = new Method('define');

        $method->setComment('Defines the specified package.');

        // Set the container interface for the argument --------
        $name = 'Rougin\Slytherin\Container\ContainerInterface';

        $method->addClassArgument('container', $name);
        // -----------------------------------------------------

        // Set the configuration for the argument -----------
        $name = 'Rougin\Slytherin\Integration\Configuration';

        $method->addClassArgument('config', $name);
        // --------------------------------------------------

        // Set the interface to return of the class -------------
        $name = '\Rougin\Slytherin\Container\ContainerInterface';

        $method->setReturn($name);
        // ------------------------------------------------------

        $method->setCodeLine(function ()
        {
            return array('//', '', 'return $container;');
        });

        return $class->addMethod($method);
    }
}
