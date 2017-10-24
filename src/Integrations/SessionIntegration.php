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
        $lifetime = (integer) $config->get('session.lifetime', 60);
        $name = $config->get('session.cookies', 'weasley_session');
        $cookie = $config->get('app.http.cookies.' . $name, null);

        $handler = $this->handler($config->get('session.driver', 'file'));

        $container->set('Rougin\Weasley\Session\SessionHandlerInterface', $handler);

        if ($cookie === null) {
            $expiration = $config->get('session.expiration', time() + 7200);

            setcookie($name, $cookie = str_random(40), $expiration);
        }

        $handler->open($config->get('session.path'), $cookie);
        $handler->gc($lifetime * 60);

        $session = new \Rougin\Weasley\Session\Session($handler, $cookie);

        return $container->set('Rougin\Weasley\Session\SessionInterface', $session);
    }

    /**
     * Returns the specified session handlers.
     *
     * @param  string $type
     * @return array
     */
    protected function handler($type = 'file')
    {
        $items = array();

        $items['file'] = new \Rougin\Weasley\Session\FileSessionHandler;

        return $items[$type];
    }
}
