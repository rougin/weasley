<?php

namespace Rougin\Weasley\Packages;

use Rougin\Slytherin\Container\ContainerInterface;
use Rougin\Slytherin\Integration\Configuration;
use Rougin\Slytherin\Integration\IntegrationInterface;
use Rougin\Weasley\Assorted\Random;
use Rougin\Weasley\Session\FileSessionHandler;
use Rougin\Weasley\Session\Session as Instance;

/**
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Session implements IntegrationInterface
{
    const HANDLER = 'SessionHandlerInterface';

    const SESSION = 'Rougin\Weasley\Contract\Session';

    /**
     * Defines the specified integration.
     *
     * @param \Rougin\Slytherin\Container\ContainerInterface $container
     * @param \Rougin\Slytherin\Integration\Configuration    $config
     *
     * @return \Rougin\Slytherin\Container\ContainerInterface
     */
    public function define(ContainerInterface $container, Configuration $config)
    {
        /** @var string */
        $name = $config->get('session.cookies', 'weasley_session');

        $handler = $this->handler($config);

        $container->set(self::HANDLER, $handler);

        /** @var string|null $cookie */
        $cookie = $config->get("app.http.cookies.$name", null);

        if ($cookie === null)
        {
            $cookie = Random::make(40);

            $default = time() + 7200;

            /** @var integer */
            $expiration = $config->get('session.expiration', $default);

            setcookie($name, $cookie, $expiration, '/');
        }

        /** @var string */
        $sessionPath = $config->get('session.path');

        $handler->open($sessionPath, $cookie);

        /** @var integer */
        $lifetime = $config->get('session.lifetime', 60);

        $handler->gc($lifetime * 60);

        $session = new Instance($handler, $cookie);

        return $container->set(self::SESSION, $session);
    }

    /**
     * Returns the specified SessionHandlerInterface.
     *
     * @param \Rougin\Slytherin\Integration\Configuration $config
     *
     * @return \SessionHandlerInterface
     */
    protected function handler(Configuration $config)
    {
        $items = array('file' => new FileSessionHandler);

        /** @var array<string, \SessionHandlerInterface> */
        $handlers = $config->get('session.handlers', $items);

        /** @var string */
        $driver = $config->get('session.driver', 'file');

        return $handlers[$driver];
    }
}
