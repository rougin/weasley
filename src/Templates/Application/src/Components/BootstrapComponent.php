<?php

namespace {{ application.name }}\{{ namespaces.components }};

use Dotenv\Dotenv;
use Interop\Container\ContainerInterface;
use Rougin\Slytherin\Component\AbstractComponent;

/**
 * Bootstrap Component
 *
 * @package {{ application.name }}
 * @author  {{ author.name }} <{{ author.email }}>
 */
class BootstrapComponent extends AbstractComponent
{
    /**
     * Sets the component.
     *
     * @param  \Interop\Container\ContainerInterface $container
     * @return void
     */
    public function set(ContainerInterface &$container)
    {
        // Loads the environment variables from an .env file.
        (new Dotenv(base()))->load();

        // Sets the default timezone
        date_default_timezone_set(env('TIMEZONE', 'Asia/Manila'));

        // Start the session
        session_start();
    }
}
