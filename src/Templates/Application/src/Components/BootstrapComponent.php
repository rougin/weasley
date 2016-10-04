<?php

namespace {{ application.name }}\{{ namespaces.components }};

/**
 * Bootstrap Component
 *
 * @package {{ application.name }}
 * @author  {{ author.name }} <{{ author.email }}>
 */
class BootstrapComponent extends \Rougin\Slytherin\Component\AbstractComponent
{
    /**
     * Sets the component.
     *
     * @param  \Interop\Container\ContainerInterface $container
     * @return void
     */
    public function set(\Interop\Container\ContainerInterface &$container)
    {
        // Loads the environment variables from an .env file.
        (new \Dotenv\Dotenv(base()))->load();

        // Sets the default timezone
        date_default_timezone_set(env('TIMEZONE', 'Asia/Manila'));

        // Start the session
        session_start();
    }
}
