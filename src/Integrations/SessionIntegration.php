<?php

namespace Rougin\Weasley\Integrations;

use Rougin\Slytherin\Container\ContainerInterface;
use Rougin\Slytherin\Integration\Configuration;
use Rougin\Slytherin\Integration\IntegrationInterface;

/**
 * Session Integration
 *
 * Bootstraps the additional definitions and integrate it to Slytherin.
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class SessionIntegration implements IntegrationInterface
{
    /**
     * @var string
     */
    protected $interface = 'Rougin\Weasley\Session\SessionInterface';

    /**
     * Defines the specified integration.
     *
     * @param  \Rougin\Slytherin\Container\ContainerInterface $container
     * @param  \Rougin\Slytherin\Integration\Configuration    $config
     * @return \Rougin\Slytherin\Container\ContainerInterface
     */
    public function define(ContainerInterface $container, Configuration $config)
    {
        $name = $config->get('session.cookies', 'weasley_session');

        list($container, $handler) = $this->handler($container, $config);

        if (! $cookie = $config->get('app.http.cookies.' . $name, null)) {
            $expiration = $config->get('session.expiration', time() + 7200);

            setcookie($name, $cookie = str_random(40), $expiration, '/');
        }

        $handler->open($config->get('session.path'), $cookie);

        $handler->gc(((integer) $config->get('session.lifetime', 60)) * 60);

        $session = new \Rougin\Weasley\Session\Session($handler, $cookie);

        return $container->set($this->interface, $session);
    }

    /**
     * Returns the specified SessionHandlerInterface.
     *
     * @param  \Rougin\Slytherin\Container\ContainerInterface $container
     * @param  \Rougin\Slytherin\Integration\Configuration    $config
     * @return \SessionHandlerInterface
     */
    protected function handler(ContainerInterface $container, Configuration $config)
    {
        $interface = 'Rougin\Weasley\Session\SessionHandlerInterface';

        $default = array('file' => 'Rougin\Weasley\Session\FileSessionHandler');

        $handlers = $config->get('session.handlers', $default);

        $handler = $handlers[$config->get('session.driver', 'file')];

        $instance = $container->get($handler);

        return array($container->set($interface, $instance), $instance);
    }
}
