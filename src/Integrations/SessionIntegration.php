<?php

namespace Rougin\Weasley\Integrations;

use Rougin\Slytherin\Integration\Configuration;
use Rougin\Slytherin\Container\ContainerInterface;

/**
 * Session Integration
 *
 * Bootstraps the additional definitions and integrate it to Slytherin.
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class SessionIntegration implements \Rougin\Slytherin\Integration\IntegrationInterface
{
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

        $handlers = $config->get('session.handlers', $this->handlers());
        $handler = $container->get($handlers[$config->get('session.driver', 'file')]);

        $container->set('Rougin\Weasley\Session\SessionHandlerInterface', $handler);

        if (($cookie = $config->get('app.http.cookies.' . $name, null)) === null) {
            $expiration = $config->get('session.expiration', time() + 7200);

            setcookie($name, $cookie = str_random(40), $expiration);
        }

        $handler->open($config->get('session.path'), $cookie);
        $handler->gc(((integer) $config->get('session.lifetime', 60)) * 60);

        $session = new \Rougin\Weasley\Session\Session($handler, $cookie);

        return $container->set('Rougin\Weasley\Session\SessionInterface', $session);
    }

    /**
     * Returns a listing of session handlers.
     *
     * @return array
     */
    protected function handlers()
    {
        $items = array();

        $items['file'] = 'Rougin\Weasley\Session\FileSessionHandler';

        return $items;
    }
}
